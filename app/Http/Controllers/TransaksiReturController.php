<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Pelanggan;
use App\Models\TransaksiRetur;
use App\Models\TransaksiPenjualanDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiReturController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $data = TransaksiRetur::with(['transaksiPenjualanDetail.barang', 'transaksiPenjualanDetail.transaksiPenjualan.pelanggan'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('transaksiPenjualanDetail.barang', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('transaksiPenjualanDetail.transaksiPenjualan.pelanggan', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $penjualanDetails = TransaksiPenjualanDetail::with(['transaksiPenjualan.pelanggan', 'barang'])
            ->get();
            
        return view('pages.transaksi.retur', compact('data', 'search', 'penjualanDetails'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_penjualan_detail_id' => 'required|exists:transaksi_penjualan_detail,id',
            'jml_barang' => 'required|numeric|min:1',
            'keterangan' => 'required|string',
        ]);

        $penjualanDetail = TransaksiPenjualanDetail::findOrFail($request->transaksi_penjualan_detail_id);
        
        // Check if the returned quantity is not more than the purchased quantity
        if ($penjualanDetail->jml_barang < $request->jml_barang) {
            return redirect()->back()->with('error', 'Jumlah barang yang diretur tidak boleh melebihi jumlah pembelian');
        }

        // Check for existing returns for this sale detail
        $existingReturns = TransaksiRetur::where('transaksi_penjualan_detail_id', $request->transaksi_penjualan_detail_id)
            ->sum('jml_barang');
            
        $availableForReturn = $penjualanDetail->jml_barang - $existingReturns;
        
        if ($availableForReturn < $request->jml_barang) {
            return redirect()->back()->with('error', "Jumlah barang yang dapat diretur hanya {$availableForReturn}");
        }

        TransaksiRetur::create([
            'user_id' => auth()->id(),
            'transaksi_penjualan_detail_id' => $request->transaksi_penjualan_detail_id,
            'jml_barang' => $request->jml_barang,
            'keterangan' => $request->keterangan,
            'tgl_transaksi' => now(),
        ]);

        return redirect()->route('transaksi.retur')->with('success', 'Retur penjualan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'transaksi_penjualan_detail_id' => 'required|exists:transaksi_penjualan_detail,id',
            'jml_barang' => 'required|numeric|min:1',
            'keterangan' => 'required|string',
        ]);

        $retur = TransaksiRetur::findOrFail($id);
        $penjualanDetail = TransaksiPenjualanDetail::findOrFail($request->transaksi_penjualan_detail_id);
        
        // If the sale detail has changed, we need to check both the old and new detail
        if ($retur->transaksi_penjualan_detail_id != $request->transaksi_penjualan_detail_id) {
            // Check for existing returns for the new sale detail
            $existingReturns = TransaksiRetur::where('transaksi_penjualan_detail_id', $request->transaksi_penjualan_detail_id)
                ->sum('jml_barang');
                
            $availableForReturn = $penjualanDetail->jml_barang - $existingReturns;
            
            if ($availableForReturn < $request->jml_barang) {
                return redirect()->back()->with('error', "Jumlah barang yang dapat diretur hanya {$availableForReturn}");
            }
        } else {
            // Check for existing returns for this sale detail (excluding current retur)
            $existingReturns = TransaksiRetur::where('transaksi_penjualan_detail_id', $request->transaksi_penjualan_detail_id)
                ->where('id', '!=', $id)
                ->sum('jml_barang');
                
            $availableForReturn = $penjualanDetail->jml_barang - $existingReturns;
            
            if ($availableForReturn < $request->jml_barang) {
                return redirect()->back()->with('error', "Jumlah barang yang dapat diretur hanya {$availableForReturn}");
            }
        }

        // Update retur
        $retur->update([
            'transaksi_penjualan_detail_id' => $request->transaksi_penjualan_detail_id,
            'jml_barang' => $request->jml_barang,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transaksi.retur')->with('success', 'Retur penjualan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $retur = TransaksiRetur::findOrFail($id);
        $retur->delete();

        return redirect()->route('transaksi.retur')->with('success', 'Retur penjualan berhasil dihapus');
    }
}
