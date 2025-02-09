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
    public function index()
    {
        $suplier = Suplier::all();
        $jenis = Jenis::all();
        $satuan = Satuan::all();

        $barang = Barang::with('detail')->get();

        $data = TransaksiGudang::all();

        // $userId = Auth::id();
        // dd($userId);

        return view('pages.transaksi.gudang', compact('data', 'suplier', 'jenis', 'satuan', 'barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_transaksi' => 'required',
            'suplier_id' => 'required',
            'barang_id' => 'required|exists:barang,id',
            'jml_barang' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);
        
        $userId = Auth::id();
        // dd($userId);

        // Gunakan transaksi database untuk memastikan integritas data
        DB::transaction(function () use ($validated, $userId) {
            // Simpan transaksi ke dalam tabel transaksi_gudang
            $gudang = TransaksiGudang::create([
                'tgl_transaksi' => $validated['tgl_transaksi'],
                'suplier_id' => $validated['suplier_id'] ?? 10,
                'barang_id' => $validated['barang_id'],
                'jml_barang' => $validated['jml_barang'],
                'user_id' => $userId,
                'keterangan' => "-",
            ]);

            // Ambil data barang berdasarkan barang_id
            $barang = Barang::findOrFail($validated['barang_id']);

            // Update stok dengan menambah jumlah barang yang masuk
            $barang->update([
                'stok' => $barang->stok + $validated['jml_barang'],
                'harga_beli' => $validated['harga_beli'],
                'harga_jual' => $validated['harga_jual'],
            ]);
        });
    
        return redirect()->route('transaksi.gudang')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'satuan' => 'required|string|max:255',
        ]);

        $satuan = Satuan::findOrFail($id);
        $satuan->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $satuan = Satuan::findOrFail($id);
        $satuan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
