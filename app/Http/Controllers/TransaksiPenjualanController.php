<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransaksiPenjualan;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Diskon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiPenjualanController extends Controller
{
    public function index(Request $request)
    {
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

        return view('pages.transaksi.penjualan.index', compact('data', 'search'));
    }

    public function tambah()
    {
        $barang = Barang::with(['detail', 'jenis', 'satuan'])->where('stok', '>', 0)->get();
        $pelanggan = Pelanggan::all();
        $diskon = Diskon::where('status', 1)->get();
        
        return view('pages.transaksi.penjualan.tambah', compact('barang', 'pelanggan', 'diskon'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_transaksi' => 'required|date',
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'barang_id' => 'required|exists:barang,id',
            'jml_barang' => 'required|numeric|min:1',
            'diskon_id' => 'nullable|exists:diskon,id',
            'keterangan' => 'nullable|string|max:255'
        ]);
        
        $userId = Auth::id();
        $barang = Barang::findOrFail($validated['barang_id']);
        
        // Cek stok
        if ($barang->stok < $validated['jml_barang']) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        DB::transaction(function () use ($validated, $userId, $barang) {
            // Simpan transaksi ke dalam tabel transaksi_penjualan
            TransaksiPenjualan::create([
                'tgl_transaksi' => $validated['tgl_transaksi'],
                'pelanggan_id' => $validated['pelanggan_id'],
                'barang_id' => $validated['barang_id'],
                'jml_barang' => $validated['jml_barang'],
                'diskon_id' => $validated['diskon_id'] ?? null,
                'keterangan' => $validated['keterangan'] ?? '-',
                'user_id' => $userId,
            ]);

            // Update stok barang
            $stokBaru = $barang->stok - $validated['jml_barang'];
            $barang->update(['stok' => $stokBaru]);
        });
    
        return redirect()->route('transaksi.penjualan')->with('success', 'Transaksi penjualan berhasil ditambahkan.');
    }
}
