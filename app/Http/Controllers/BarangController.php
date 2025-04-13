<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $jenis = Jenis::all();
        $satuan = Satuan::all();
        $search = $request->get('search');

        $data = Barang::with('detail')
                      ->when($search, function($query, $search) {
                          return $query->where('nama', 'like', "%{$search}%");
                      })
                      ->paginate(10);
                      
        return view('pages.barang.index', compact('jenis', 'satuan', 'data', 'search'));
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

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
            'jenis_id' => 'required|exists:jenis,id',
            'satuan_id' => 'required|exists:satuan,id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'barcode' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barang', 'public');
            $barang->foto = $fotoPath;
        }

        $barang->update([
            'nama' => $validated['nama'],
            'stok' => $validated['stok'],
            'status' => $validated['status'],
        ]);

        $barang->detail()->update([
            'jenis_id' => $validated['jenis_id'],
            'satuan_id' => $validated['satuan_id'],
            'harga_beli' => $validated['harga_beli'],
            'harga_jual' => $validated['harga_jual'],
            'barcode' => $validated['barcode'],
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $barang->detail()->delete();
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
