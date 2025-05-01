<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransaksiPenjualan;
use App\Models\TransaksiPenjualanDetail;
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

        $data = TransaksiPenjualan::with(['details', 'details.barang', 'pelanggan'])
                ->when($search, function($query, $search) {
                    return $query->whereHas('pelanggan', function($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })->orWhere('tgl_transaksi', 'like', "%{$search}%");
                })
                ->orderBy('tgl_transaksi', 'desc')
                ->paginate(10)
                ->appends(['search' => $search]);

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
                // Hitung total transaksi
                $total = 0;
                foreach ($cartItems as $item) {
                    $total += intval($item['total']);
                }
                
                // Buat header transaksi penjualan
                $transaksi = TransaksiPenjualan::create([
                    'tgl_transaksi' => $validated['tgl_transaksi'],
                    'pelanggan_id'  => $validated['pelanggan_id'],
                    'total'         => $total,
                    'keterangan'    => $validated['keterangan'] ?? '-',
                    'user_id'       => $userId,
                ]);
                
                // Buat detail transaksi untuk setiap item
                foreach ($cartItems as $item) {
                    // Basic item data validation
                    if (!isset($item['barang_id'], $item['jumlah'], $item['total'])) {
                        throw new \Exception('Data keranjang tidak valid.');
                    }
                    
                    $barang = Barang::findOrFail($item['barang_id']);
                    $qty = intval($item['jumlah']);
                    
                    if ($qty < 1 || $barang->stok < $qty) {
                        throw new \Exception("Stok barang {$barang->nama} tidak mencukupi.");
                    }
                    
                    // Harga satuan
                    $hargaSatuan = $barang->detail->harga_jual ?? 0;
                    
                    // Hitung subtotal dengan diskon jika ada
                    $subtotal = $hargaSatuan * $qty;
                    
                    // Terapkan diskon jika ada
                    if (!empty($item['diskon_id'])) {
                        $diskon = Diskon::find($item['diskon_id']);
                        if ($diskon) {
                            $subtotal = $subtotal - ($subtotal * $diskon->persen / 100);
                        }
                    }
                    
                    // Buat detail transaksi
                    TransaksiPenjualanDetail::create([
                        'transaksi_penjualan_id' => $transaksi->id,
                        'barang_id'     => $item['barang_id'],
                        'jml_barang'    => $qty,
                        'harga_satuan'  => $hargaSatuan,
                        'subtotal'      => intval($subtotal),
                        'diskon_id'     => $item['diskon_id'] ?? null,
                    ]);
                    
                    // Kurangi stok barang
                    $barang->decrement('stok', $qty);
                }
            });
            
            return redirect()->route('transaksi.penjualan')->with('success', 'Transaksi penjualan berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Method untuk menampilkan detail transaksi
    public function show($id)
    {
        $transaksi = TransaksiPenjualan::with([
            'details', 
            'details.barang', 
            'details.barangDetail', 
            'details.diskon', 
            'details.barangDetail.satuan', 
            'details.barangDetail.jenis',
            'pelanggan'
        ])->findOrFail($id);
        
        return view('pages.transaksi.penjualan.detail', compact('transaksi'));
    }

    // Method untuk menampilkan form edit transaksi
    public function edit($id)
    {
        $transaksi = TransaksiPenjualan::with([
            'details', 
            'details.barang', 
            'details.barangDetail', 
            'details.diskon',
            'pelanggan'
        ])->findOrFail($id);
        
        $barang = Barang::with(['detail', 'jenis', 'satuan'])->get();
        $pelanggan = Pelanggan::all();
        $diskon = Diskon::where('status', 1)->get();
        
        return view('pages.transaksi.penjualan.edit', compact('transaksi', 'barang', 'pelanggan', 'diskon'));
    }

    // Method untuk menyimpan perubahan transaksi
    public function update(Request $request, $id)
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

        try {
            DB::transaction(function () use ($validated, $id, $cartItems) {
                $transaksi = TransaksiPenjualan::findOrFail($id);
                
                // Ambil semua detail transaksi
                $detailsToDelete = $transaksi->details;
                
                // Kembalikan stok barang untuk setiap detail yang akan dihapus
                foreach ($detailsToDelete as $detail) {
                    $barang = Barang::findOrFail($detail->barang_id);
                    $barang->increment('stok', $detail->jml_barang);
                }
                
                // Hapus semua detail lama
                TransaksiPenjualanDetail::where('transaksi_penjualan_id', $transaksi->id)->delete();
                
                // Hitung total transaksi baru
                $total = 0;
                foreach ($cartItems as $item) {
                    $total += intval($item['subtotal']);
                }
                
                // Update header transaksi
                $transaksi->update([
                    'tgl_transaksi' => $validated['tgl_transaksi'],
                    'pelanggan_id'  => $validated['pelanggan_id'],
                    'total'         => $total,
                    'keterangan'    => $validated['keterangan'] ?? '-',
                ]);
                
                // Buat detail transaksi baru untuk setiap item
                foreach ($cartItems as $item) {
                    // Basic item data validation
                    if (!isset($item['barang_id'], $item['jumlah'], $item['subtotal'])) {
                        throw new \Exception('Data keranjang tidak valid.');
                    }
                    
                    $barang = Barang::findOrFail($item['barang_id']);
                    $qty = intval($item['jumlah']);
                    
                    if ($qty < 1 || $barang->stok < $qty) {
                        throw new \Exception("Stok barang {$barang->nama} tidak mencukupi.");
                    }
                    
                    // Harga satuan
                    $hargaSatuan = $barang->detail->harga_jual ?? 0;
                    
                    // Hitung subtotal dengan diskon jika ada
                    $subtotal = $hargaSatuan * $qty;
                    
                    // Terapkan diskon jika ada
                    if (!empty($item['diskon_id'])) {
                        $diskon = Diskon::find($item['diskon_id']);
                        if ($diskon) {
                            $subtotal = $subtotal - ($subtotal * $diskon->persen / 100);
                        }
                    }
                    
                    // Buat detail transaksi baru
                    TransaksiPenjualanDetail::create([
                        'transaksi_penjualan_id' => $transaksi->id,
                        'barang_id'     => $item['barang_id'],
                        'jml_barang'    => $qty,
                        'harga_satuan'  => $hargaSatuan,
                        'subtotal'      => intval($subtotal),
                        'diskon_id'     => $item['diskon_id'] ?? null,
                    ]);
                    
                    // Kurangi stok barang
                    $barang->decrement('stok', $qty);
                }
            });
            
            return redirect()->route('transaksi.penjualan')->with('success', 'Transaksi penjualan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Method untuk menghapus transaksi
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $transaksi = TransaksiPenjualan::with('details')->findOrFail($id);
                
                // Kembalikan stok barang
                foreach ($transaksi->details as $detail) {
                    $barang = Barang::findOrFail($detail->barang_id);
                    $barang->increment('stok', $detail->jml_barang);
                }
                
                // Hapus transaksi (detail akan terhapus otomatis karena onDelete cascade)
                $transaksi->delete();
            });
            
            return redirect()->route('transaksi.penjualan')->with('success', 'Transaksi penjualan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Method untuk mencetak nota/faktur transaksi
    public function cetak($id)
    {
        $transaksi = TransaksiPenjualan::with([
            'details', 
            'details.barang', 
            'details.barangDetail', 
            'details.diskon', 
            'details.barangDetail.satuan', 
            'details.barangDetail.jenis',
            'pelanggan'
        ])->findOrFail($id);
            
        return view('pages.transaksi.penjualan.cetak', compact('transaksi'));
    }
}
