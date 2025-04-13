<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $data = Satuan::when($search, function($query, $search) {
                return $query->where('satuan', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('pages/barang/satuan', compact('data', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'satuan' => 'required|string|max:255',
        ]);

        Satuan::create($request->all());

        return redirect()->route('barang.satuan')->with('success', 'Satuan berhasil ditambahkan.');
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
