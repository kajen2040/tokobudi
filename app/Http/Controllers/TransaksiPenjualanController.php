<?php

namespace App\Http\Controllers;

// use App\Models\Jenis;
// use App\Models\Barang;
// use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransaksiPenjualan;
// use App\Models\Pelanggan;
// use App\Models\Diskon;

class TransaksiPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Pelanggan::all();
        // $jenis = Jenis::all();
        // $satuan = Satuan::all();
        // $barang = Barang::with('detail')->get();
        // $diskon = Diskon::all();
        $search = $request->get('search');

        $data = TransaksiPenjualan::with(['barang', 'pelanggan', 'barangDetail'])
                ->when($search, function($query, $search) {
                    return $query->whereHas('barang', function($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })->orWhereHas('pelanggan', function($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })->orWhere('tgl_transaksi', 'like', "%{$search}%");
                })
                ->orderBy('tgl_transaksi', 'desc')
                ->paginate(10);

        // $userId = Auth::id();
        // dd($userId);

        return view('pages.transaksi.penjualan', compact('data', 'pelanggan', 'jenis', 'satuan', 'barang', 'diskon', 'search'));
    }

    public function tambah()
    {
        return view('pages.transaksi.penjualan.tambah');
    }
}
