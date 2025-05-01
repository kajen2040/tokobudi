<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Suplier;
use Illuminate\Http\Request;
use App\Models\TransaksiGudang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiGudangController extends Controller
{
    public function index(Request $request)
    {
        $suplier = Suplier::all();
        $jenis = Jenis::all();
        $satuan = Satuan::all();
        $barang = Barang::with('detail')->get();
        $search = $request->get('search');

        $data = TransaksiGudang::with(['barang', 'suplier', 'barangDetail', 'user'])
                ->when($search, function($query, $search) {
                    return $query->whereHas('barang', function($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })->orWhereHas('suplier', function($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })->orWhere('tgl_transaksi', 'like', "%{$search}%");
                })
                ->orderBy('tgl_transaksi', 'desc')
                ->paginate(10);

        // $userId = Auth::id();
        // dd($userId);

        return view('pages.transaksi.gudang', compact('data', 'suplier', 'jenis', 'satuan', 'barang', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_transaksi' => 'required|date',
            'suplier_id' => 'required|exists:suplier,id',
            'barang_id' => 'required|exists:barang,id',
            'jml_barang' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255'
        ]);
        
        $userId = Auth::id();

        DB::transaction(function () use ($validated, $userId) {
            // Simpan transaksi ke dalam tabel transaksi_gudang
            $gudang = TransaksiGudang::create([
                'tgl_transaksi' => $validated['tgl_transaksi'],
                'suplier_id' => $validated['suplier_id'],
                'barang_id' => $validated['barang_id'],
                'jml_barang' => $validated['jml_barang'],
                'harga_beli' => $validated['harga_beli'],
                'keterangan' => $validated['keterangan'] ?? '-',
                'user_id' => $userId,
            ]);

            // Ambil data barang berdasarkan barang_id
            $barang = Barang::findOrFail($validated['barang_id']);

            // Update stok
            $stokBaru = $barang->stok + $validated['jml_barang'];

            // Update stok dan harga beli
            $barang->update([
                'stok' => $stokBaru,
                'harga_beli' => $validated['harga_beli']
            ]);
        });
    
        return redirect()->route('transaksi.gudang')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $transaksi = TransaksiGudang::findOrFail($id);
        
        $validated = $request->validate([
            'tgl_transaksi' => 'required|date',
            'suplier_id' => 'required|exists:suplier,id',
            'barang_id' => 'required|exists:barang,id',
            'jml_barang' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255'
        ]);

        try {
            DB::transaction(function () use ($transaksi, $validated) {
                // Check if barang_id changed
                $barangIdChanged = $transaksi->barang_id != $validated['barang_id'];
                
                // Get original and new barang
                $originalBarang = Barang::findOrFail($transaksi->barang_id);
                $newBarang = $barangIdChanged 
                    ? Barang::findOrFail($validated['barang_id']) 
                    : $originalBarang;
                
                // Calculate stock difference
                $selisihStok = $validated['jml_barang'] - $transaksi->jml_barang;
                
                // Check if there are sales transactions for this item
                $hasSalesTransactions = false;
                if ($selisihStok < 0) {  // Only check if decreasing the stock
                    $hasSalesTransactions = DB::table('transaksi_penjualan_detail')
                        ->where('barang_id', $transaksi->barang_id)
                        ->exists();
                    
                    // Check if we have enough stock after sales transactions
                    if ($hasSalesTransactions && ($originalBarang->stok + $selisihStok < 0)) {
                        throw new \Exception('Tidak dapat mengurangi stok karena barang sudah terjual');
                    }
                }
                
                // Update transaction
                $transaksi->update($validated);

                // If barang_id changed, we need to update both original and new barang
                if ($barangIdChanged) {
                    // Revert stock from original barang
                    $originalBarang->update([
                        'stok' => $originalBarang->stok - $transaksi->jml_barang
                    ]);
                    
                    // Update stock in new barang
                    $newBarang->update([
                        'stok' => $newBarang->stok + $validated['jml_barang'],
                        'harga_beli' => $validated['harga_beli']
                    ]);
                } else {
                    // If same barang, just update with difference
                    $stokBaru = $originalBarang->stok + $selisihStok;
                    
                    $originalBarang->update([
                        'stok' => $stokBaru,
                        'harga_beli' => $validated['harga_beli']
                    ]);
                }
            });

            return redirect()->route('transaksi.gudang')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $transaksi = TransaksiGudang::findOrFail($id);

        DB::transaction(function () use ($transaksi) {
            // Ambil data barang
            $barang = Barang::findOrFail($transaksi->barang_id);

            // Update stok
            $stokBaru = $barang->stok - $transaksi->jml_barang;

            // Update stok barang
            $barang->update(['stok' => $stokBaru]);

            // Hapus transaksi
            $transaksi->delete();
        });

        return redirect()->route('transaksi.gudang')->with('success', 'Transaksi berhasil dihapus.');
    }
}
