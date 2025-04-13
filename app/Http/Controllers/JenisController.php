<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $data = Jenis::when($search, function($query, $search) {
                return $query->where('jenis', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('pages/barang/jenis', compact('data', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string|max:255',
        ]);

        Jenis::create($request->all());

        return redirect()->route('barang.jenis')->with('success', 'Jenis berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string|max:255',
        ]);

        $jenis = Jenis::findOrFail($id);
        $jenis->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenis = Jenis::findOrFail($id);
        $jenis->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
