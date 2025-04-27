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
        // Validate basic form data
        $validated = $request->validate([
            'tgl_transaksi' => 'required|date',
            'pelanggan_id'  => 'required|exists:pelanggan,id',
            'keterangan'    => 'nullable|string|max:255',
            'cart_items'    => 'required|json',
        ]);

        // Decode cart items JSON
        $cartItems = json_decode($request->input('cart_items'), true);
        if (!is_array($cartItems) || empty($cartItems)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong!');
        }

        $userId = Auth::id();
        try {
            DB::transaction(function () use ($validated, $userId, $cartItems) {
                foreach ($cartItems as $item) {
                    // Basic item data validation
                    if (!isset($item['barang_id'], $item['jumlah'], $item['total'])) {
                        throw new \Exception('Data keranjang tidak valid.');
                    }
                    $barang = Barang::findOrFail($item['barang_id']);
                    $qty    = intval($item['jumlah']);
                    if ($qty < 1 || $barang->stok < $qty) {
                        throw new \Exception("Stok barang {$barang->nama} tidak mencukupi.");
                    }
                    // Create transaction record
                    TransaksiPenjualan::create([
                        'tgl_transaksi' => $validated['tgl_transaksi'],
                        'pelanggan_id'  => $validated['pelanggan_id'],
                        'barang_id'     => $item['barang_id'],
                        'jml_barang'    => $qty,
                        'total'         => intval($item['total']),
                        'diskon_id'     => $item['diskon_id'] ?? null,
                        'keterangan'    => $validated['keterangan'] ?? '-',
                        'user_id'       => $userId,
                    ]);
                    // Decrement stock
                    $barang->decrement('stok', $qty);
                }
            });
            return redirect()->route('transaksi.penjualan')->with('success', 'Transaksi penjualan berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
