<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    public function index()
    {
        $data = Suplier::all();

        return view('pages/suplier/index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        Suplier::create($request->all());

        return redirect()->route('suplier.index')->with('success', 'Suplier berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        $suplier = Suplier::findOrFail($id);
        $suplier->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $suplier = Suplier::findOrFail($id);
        $suplier->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
