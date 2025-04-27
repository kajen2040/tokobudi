<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiReturController extends Controller
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
                ->orderBy('id', 'desc')
                ->paginate(10);
        
        return view('pages.transaksi.retur', compact('jenis', 'satuan', 'data', 'search'));
    }
}
