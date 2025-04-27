<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\TransaksiGudang;
use App\Models\BarangDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $jenis = Jenis::all();
        $satuan = Satuan::all();

        $data = Barang::with(['detail.jenis', 'detail.satuan'])
                      ->whereHas('detail')
                      ->when($search, function($query, $search) {
                          return $query->where('nama', 'like', "%{$search}%");
                      })
                      ->latest() // Order by created_at desc (newest first)
                      ->paginate(10);

        // Get last purchase price for each barang
        foreach ($data as $barang) {
            $lastPurchase = TransaksiGudang::where('barang_id', $barang->id)
                ->orderBy('tgl_transaksi', 'desc')
                ->first();
            
            $barang->last_purchase_price = $lastPurchase ? $lastPurchase->harga_beli : 0;
        }
                      
        return view('pages.barang.index', compact('data', 'search', 'jenis', 'satuan'));
    }

    public function store(Request $request)
    {
        $hargaBeli = 0;
        $hargaJual = 0;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok' => 'nullable|integer|min:0',
            'status' => 'nullable|in:1,0',
            'jenis' => 'required|exists:jenis,id',
            'satuan' => 'required|exists:satuan,id',
            'barcode' => 'nullable|string|max:255',
        ]);

        // dd($validated);
    
        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('barang', 'public')
            : null;
    
        $barang = Barang::create([
            'nama' => $validated['nama'],
            'foto' => $fotoPath,
            'stok' => $validated['stok'] ?? 0,
            'status' => $validated['status'] ?? 1,
        ]);
    
        $barang->detail()->create([
            'jenis_id' => $validated['jenis'],
            'satuan_id' => $validated['satuan'],
            'harga_beli' => $hargaBeli,
            'harga_jual' => $hargaJual,
            'barcode' => $validated['barcode'],
        ]);
    
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the barang by ID
            $barang = Barang::findOrFail($id);
            
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'jenis' => 'required|exists:jenis,id',
                'satuan' => 'required|exists:satuan,id',
                'harga_jual' => 'required|numeric|min:0',
                'barcode' => 'nullable|string|max:255',
            ]);

            DB::beginTransaction();

            try {
                // Update barang basic info
                $barang->update([
                    'nama' => $validated['nama'],
                ]);

                // Handle photo update
                if ($request->hasFile('foto')) {
                    // Delete old photo if exists
                    if ($barang->foto && Storage::exists('public/' . $barang->foto)) {
                        Storage::delete('public/' . $barang->foto);
                    }
                    
                    $fotoPath = $request->file('foto')->store('barang', 'public');
                    $barang->update(['foto' => $fotoPath]);
                }

                // Get last purchase price or use current value from BarangDetail
                $lastPurchase = TransaksiGudang::where('barang_id', $barang->id)
                    ->orderBy('tgl_transaksi', 'desc')
                    ->first();
                
                // Determine the harga_beli value, prioritizing existing value if available
                $hargaBeli = 0;
                if ($barang->detail && $barang->detail->harga_beli > 0) {
                    $hargaBeli = $barang->detail->harga_beli;
                } elseif ($lastPurchase && $lastPurchase->harga_beli > 0) {
                    $hargaBeli = $lastPurchase->harga_beli;
                }

                // Prepare BarangDetail data
                $detailData = [
                    'jenis_id' => $validated['jenis'],
                    'satuan_id' => $validated['satuan'],
                    'harga_jual' => $validated['harga_jual'],
                    'barcode' => $validated['barcode'] ?? null,
                    'harga_beli' => $hargaBeli,
                ];

                // Try to find the BarangDetail using the relationship first
                if ($barang->detail) {
                    $barang->detail->update($detailData);
                } else {
                    // If relationship doesn't exist, try direct query as fallback
                    $barangDetail = BarangDetail::where('barang_id', $barang->id)->first();
                    
                    if ($barangDetail) {
                        $barangDetail->update($detailData);
                    } else {
                        // Create new BarangDetail if it doesn't exist
                        $detailData['barang_id'] = $barang->id;
                        BarangDetail::create($detailData);
                    }
                }

                DB::commit();
                return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $barang->detail()->delete();
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
