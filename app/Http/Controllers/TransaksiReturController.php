<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Pelanggan;
use App\Models\TransaksiRetur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiReturController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $data = TransaksiRetur::with(['barang', 'pelanggan', 'barangDetail.satuan', 'barangDetail.jenis'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('barang', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('pelanggan', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('pages.transaksi.retur', compact('data', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'jml_barang' => 'required|numeric|min:1',
            'keterangan' => 'required|string',
            'diskon_id' => 'nullable|exists:diskon,id',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        
        // Check if stock is sufficient
        if ($barang->stok < $request->jml_barang) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi');
        }

        TransaksiRetur::create([
            'user_id' => auth()->id(),
            'barang_id' => $request->barang_id,
            'pelanggan_id' => $request->pelanggan_id,
            'diskon_id' => $request->diskon_id,
            'jml_barang' => $request->jml_barang,
            'keterangan' => $request->keterangan,
            'tgl_transaksi' => now(),
        ]);

        // Update stock
        $barang->update([
            'stok' => $barang->stok + $request->jml_barang
        ]);

        return redirect()->route('transaksi.retur')->with('success', 'Retur penjualan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'jml_barang' => 'required|numeric|min:1',
            'keterangan' => 'required|string',
            'diskon_id' => 'nullable|exists:diskon,id',
        ]);

        $retur = TransaksiRetur::findOrFail($id);
        $barang = Barang::findOrFail($request->barang_id);
        $oldBarang = $retur->barang;

        // Calculate stock changes
        $stockChange = $request->jml_barang - $retur->jml_barang;

        // Check if new stock is sufficient
        if ($barang->stok < $stockChange) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi');
        }

        // Update retur
        $retur->update([
            'barang_id' => $request->barang_id,
            'pelanggan_id' => $request->pelanggan_id,
            'diskon_id' => $request->diskon_id,
            'jml_barang' => $request->jml_barang,
            'keterangan' => $request->keterangan,
        ]);

        // Update stock
        if ($oldBarang->id == $barang->id) {
            // Same barang, just adjust the stock
            $barang->update([
                'stok' => $barang->stok + $stockChange
            ]);
        } else {
            // Different barang, restore old stock and reduce new stock
            $oldBarang->update([
                'stok' => $oldBarang->stok - $retur->jml_barang
            ]);
            $barang->update([
                'stok' => $barang->stok + $request->jml_barang
            ]);
        }

        return redirect()->route('transaksi.retur')->with('success', 'Retur penjualan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $retur = TransaksiRetur::findOrFail($id);
        $barang = $retur->barang;

        // Restore stock
        $barang->update([
            'stok' => $barang->stok - $retur->jml_barang
        ]);

        $retur->delete();

        return redirect()->route('transaksi.retur')->with('success', 'Retur penjualan berhasil dihapus');
    }
}
