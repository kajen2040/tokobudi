<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use App\Models\TransaksiPenjualanDetail;
use App\Models\TransaksiRetur;
use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $tanggalMulai = $request->get('tanggal_mulai', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tanggalSelesai = $request->get('tanggal_selesai', Carbon::now()->format('Y-m-d'));
        $jenisBarang = $request->get('jenis_barang', []);
        $status = $request->get('status', 'all');

        // Get all jenis for filter dropdown
        $jenisOptions = Jenis::all();

        // Base query for sales data
        $query = TransaksiPenjualanDetail::with([
            'transaksiPenjualan.pelanggan',
            'transaksiPenjualan.user',
            'barang',
            'barangDetail.jenis',
            'barangDetail.satuan',
            'diskon'
        ])->whereHas('transaksiPenjualan', function($q) use ($tanggalMulai, $tanggalSelesai) {
            $q->whereBetween('tgl_transaksi', [$tanggalMulai, $tanggalSelesai]);
        });

        // Filter by jenis barang if specified
        if (!empty($jenisBarang)) {
            $query->whereHas('barangDetail', function($q) use ($jenisBarang) {
                $q->whereIn('jenis_id', $jenisBarang);
            });
        }

        // Get sales data
        $salesData = $query->orderBy('created_at', 'desc')->get();

        // Filter by status (terjual vs retur)
        if ($status === 'sold') {
            // Only sales without returns
            $salesData = $salesData->reject(function($detail) {
                return TransaksiRetur::where('transaksi_penjualan_detail_id', $detail->id)->exists();
            });
        } elseif ($status === 'return') {
            // Only items that have been returned
            $salesData = $salesData->filter(function($detail) {
                return TransaksiRetur::where('transaksi_penjualan_detail_id', $detail->id)->exists();
            });
        }

        // Calculate summary statistics
        $totalQuantity = $salesData->sum('jml_barang');
        $totalRevenue = $salesData->sum('subtotal');
        $totalTransactions = $salesData->groupBy('transaksi_penjualan_id')->count();
        $totalItems = $salesData->groupBy('barang_id')->count();

        // Top selling products
        $topProducts = $salesData->groupBy('barang_id')->map(function($group) {
            $firstItem = $group->first();
            return [
                'nama' => $firstItem->barang->nama,
                'total_qty' => $group->sum('jml_barang'),
                'total_revenue' => $group->sum('subtotal'),
                'jenis' => $firstItem->barangDetail->jenis->jenis ?? '-'
            ];
        })->sortByDesc('total_qty')->take(5);

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'salesData' => $salesData->map(function($detail) {
                    return [
                        'id' => $detail->id,
                        'tanggal' => $detail->transaksiPenjualan->tgl_transaksi,
                        'nama_barang' => $detail->barang->nama,
                        'jenis' => $detail->barangDetail->jenis->jenis ?? '-',
                        'satuan' => $detail->barangDetail->satuan->satuan ?? '-',
                        'pelanggan' => $detail->transaksiPenjualan->pelanggan->nama,
                        'kasir' => $detail->transaksiPenjualan->user->name ?? '-',
                        'jumlah' => $detail->jml_barang,
                        'harga_satuan' => $detail->harga_satuan,
                        'subtotal' => $detail->subtotal,
                        'diskon' => $detail->diskon->nama ?? '-',
                        'has_return' => TransaksiRetur::where('transaksi_penjualan_detail_id', $detail->id)->exists()
                    ];
                }),
                'summary' => [
                    'total_quantity' => $totalQuantity,
                    'total_revenue' => $totalRevenue,
                    'total_transactions' => $totalTransactions,
                    'total_items' => $totalItems
                ],
                'topProducts' => $topProducts
            ]);
        }

        return view('pages.laporan.index', compact(
            'salesData',
            'jenisOptions',
            'tanggalMulai',
            'tanggalSelesai',
            'jenisBarang',
            'status',
            'totalQuantity',
            'totalRevenue',
            'totalTransactions',
            'totalItems',
            'topProducts'
        ));
    }

    public function export(Request $request)
    {
        // Get filter parameters
        $tanggalMulai = $request->get('tanggal_mulai', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tanggalSelesai = $request->get('tanggal_selesai', Carbon::now()->format('Y-m-d'));
        $jenisBarang = $request->get('jenis_barang', []);
        $status = $request->get('status', 'all');

        $query = TransaksiPenjualanDetail::with([
            'transaksiPenjualan.pelanggan',
            'transaksiPenjualan.user',
            'barang',
            'barangDetail.jenis',
            'barangDetail.satuan',
            'diskon'
        ])->whereHas('transaksiPenjualan', function($q) use ($tanggalMulai, $tanggalSelesai) {
            $q->whereBetween('tgl_transaksi', [$tanggalMulai, $tanggalSelesai]);
        });

        // Filter by jenis barang if specified
        if (!empty($jenisBarang)) {
            $query->whereHas('barangDetail', function($q) use ($jenisBarang) {
                $q->whereIn('jenis_id', $jenisBarang);
            });
        }

        $salesData = $query->orderBy('created_at', 'desc')->get();

        // Filter by status
        if ($status === 'sold') {
            $salesData = $salesData->reject(function($detail) {
                return TransaksiRetur::where('transaksi_penjualan_detail_id', $detail->id)->exists();
            });
        } elseif ($status === 'return') {
            $salesData = $salesData->filter(function($detail) {
                return TransaksiRetur::where('transaksi_penjualan_detail_id', $detail->id)->exists();
            });
        }

        // Generate CSV
        $filename = 'laporan_penjualan_' . $tanggalMulai . '_sampai_' . $tanggalSelesai . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Calculate summary for export
        $totalQuantity = $salesData->sum('jml_barang');
        $totalRevenue = $salesData->sum('subtotal');
        $totalTransactions = $salesData->groupBy('transaksi_penjualan_id')->count();
        
        $callback = function() use ($salesData, $tanggalMulai, $tanggalSelesai, $totalQuantity, $totalRevenue, $totalTransactions) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper Excel encoding
            fwrite($file, "\xEF\xBB\xBF");
            
            // Report Header
            fputcsv($file, ['LAPORAN PENJUALAN']);
            fputcsv($file, ['Periode: ' . date('d/m/Y', strtotime($tanggalMulai)) . ' - ' . date('d/m/Y', strtotime($tanggalSelesai))]);
            fputcsv($file, ['Dicetak pada: ' . date('d/m/Y H:i:s')]);
            fputcsv($file, []); // Empty row
            
            // Summary
            fputcsv($file, ['RINGKASAN']);
            fputcsv($file, ['Total Transaksi', $totalTransactions]);
            fputcsv($file, ['Total Barang Terjual', number_format($totalQuantity)]);
            fputcsv($file, ['Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.')]);
            fputcsv($file, []); // Empty row
            
            // Table Headers
            fputcsv($file, [
                'No',
                'Tanggal',
                'Nama Barang',
                'Jenis',
                'Satuan',
                'Pelanggan',
                'Kasir',
                'Jumlah',
                'Harga Satuan',
                'Subtotal',
                'Diskon',
                'Status'
            ]);

            // Table Data
            foreach ($salesData as $index => $detail) {
                $hasReturn = TransaksiRetur::where('transaksi_penjualan_detail_id', $detail->id)->exists();
                
                fputcsv($file, [
                    $index + 1,
                    date('d/m/Y', strtotime($detail->transaksiPenjualan->tgl_transaksi)),
                    $detail->barang->nama,
                    $detail->barangDetail->jenis->jenis ?? '-',
                    $detail->barangDetail->satuan->satuan ?? '-',
                    $detail->transaksiPenjualan->pelanggan->nama,
                    $detail->transaksiPenjualan->user->name ?? '-',
                    $detail->jml_barang,
                    number_format($detail->harga_satuan, 0, ',', '.'),
                    number_format($detail->subtotal, 0, ',', '.'),
                    $detail->diskon->nama ?? '-',
                    $hasReturn ? 'Retur' : 'Terjual'
                ]);
            }
            
            // Footer totals
            fputcsv($file, []); // Empty row
            fputcsv($file, ['', '', '', '', '', '', 'TOTAL:', number_format($totalQuantity), '', number_format($totalRevenue, 0, ',', '.'), '', '']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
