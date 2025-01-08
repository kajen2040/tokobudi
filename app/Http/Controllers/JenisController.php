<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $data = Jenis::all();

        return view('pages/barang/jenis', compact('data'));
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
