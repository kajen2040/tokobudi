<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Suplier;
use Illuminate\Http\Request;

class TransaksiGudangController extends Controller
{
    public function index()
    {
        $suplier = Suplier::all();
        $jenis = Jenis::all();
        $satuan = Satuan::all();

        $barang = Barang::with('detail')->get();

        return view('pages.transaksi.gudang', compact('suplier', 'jenis', 'satuan', 'barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok' => 'nullable|integer|min:0',
            'status' => 'nullable|in:1,0',
            'jenis' => 'required|exists:jenis,id',
            'satuan' => 'required|exists:satuan,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'barcode' => 'nullable|string|max:255',
        ]);

        // dd($validated);
    
        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('barang', 'public')
            : null;
    
        $barang = Barang::create([
            'nama' => $validated['nama'],
            'foto' => $fotoPath,
            'stok' => $validated['stok'] ?? 0,
            'status' => $validated['status'] ?? 1,
        ]);
    
        $barang->detail()->create([
            'jenis_id' => $validated['jenis'],
            'satuan_id' => $validated['satuan'],
            'harga_beli' => $validated['harga_beli'],
            'harga_jual' => $validated['harga_jual'],
            'barcode' => $validated['barcode'],
        ]);
    
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
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
