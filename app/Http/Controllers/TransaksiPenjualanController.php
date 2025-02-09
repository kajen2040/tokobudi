<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();
        $satuan = Satuan::all();

        $data = Barang::with('detail')->get();
        
        return view('pages.transaksi.penjualan', compact('jenis', 'satuan', 'data'));
    }
}
