<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $data = Diskon::all();

        return view('pages/barang/diskon', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'persen' => 'required|integer|max:100',
            'status' => 'required|integer|max:100',
        ]);

        Diskon::create($request->all());

        return redirect()->route('barang.diskon')->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'persen' => 'required|number|max:255',
            'status' => 'required|string|max:255',
        ]);

        $diskon = Diskon::findOrFail($id);
        $diskon->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $diskon = Diskon::findOrFail($id);
        $diskon->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
