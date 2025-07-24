@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $storeSettings['store_name'] }} - Laporan Penjualan</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-start sm:items-center mt-8 gap-4 sm:gap-0">
        <h2 class="text-lg font-medium mr-auto">
            <span class="text-primary">Laporan Penjualan</span> 
        </h2>
        <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-2 sm:gap-3 mt-0 no-print">
            <button type="button" class="bg-white border border-primary text-primary hover:bg-primary hover:text-white px-4 py-2 rounded-md shadow-md min-h-[40px] text-sm flex items-center" onclick="printReport()">
                <i data-lucide="printer" class="w-4 h-4 mr-2"></i> 
                <span class="hidden sm:inline">Print Laporan</span>
                <span class="sm:hidden">Print</span>
            </button>
            <button type="button" class="bg-primary border border-primary text-white hover:bg-primary-dark px-4 py-2 rounded-md shadow-md min-h-[40px] text-sm flex items-center" onclick="exportReport()">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i> 
                <span class="hidden sm:inline">Download CSV</span>
                <span class="sm:hidden">Export</span>
            </button>
        </div>
    </div>

    <!-- Print Header (hidden on screen, visible on print) -->
    <div class="print-header" style="display: none;">
        <h1>{{ $storeSettings['store_name'] ?? 'TOKO BUDI' }}</h1>
        <h2>Laporan Penjualan</h2>
        <p>Periode: <span id="printPeriod"></span></p>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Print Area Wrapper -->
    <div class="print-area">
        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mt-5 print-summary">
        <!-- Total Transaksi -->
        <div class="intro-y">
            <div class="box p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-slate-500 text-sm font-medium mb-1">Total Transaksi</div>
                        <div class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-slate-200" id="totalTransactions">
                            {{ number_format($totalTransactions) }}
                        </div>
                        <div class="text-xs text-slate-400 mt-1">Periode aktif</div>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-primary/20 to-primary/10 rounded-xl flex items-center justify-center">
                            <i data-lucide="shopping-cart" class="w-6 h-6 lg:w-7 lg:h-7 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Barang Terjual -->
        <div class="intro-y">
            <div class="box p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-slate-500 text-sm font-medium mb-1">Total Barang Terjual</div>
                        <div class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-slate-200" id="totalQuantity">
                            {{ number_format($totalQuantity) }}
                        </div>
                        <div class="text-xs text-slate-400 mt-1">Unit terjual</div>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-success/20 to-success/10 rounded-xl flex items-center justify-center">
                            <i data-lucide="package" class="w-6 h-6 lg:w-7 lg:h-7 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="intro-y">
            <div class="box p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-slate-500 text-sm font-medium mb-1">Total Pendapatan</div>
                        <div class="text-xl lg:text-2xl font-bold text-slate-800 dark:text-slate-200" id="totalRevenue">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-slate-400 mt-1">Revenue kotor</div>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-warning/20 to-warning/10 rounded-xl flex items-center justify-center">
                            <i data-lucide="dollar-sign" class="w-6 h-6 lg:w-7 lg:h-7 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jenis Barang -->
        <div class="intro-y">
            <div class="box p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-slate-500 text-sm font-medium mb-1">Jenis Barang</div>
                        <div class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-slate-200" id="totalItems">
                            {{ number_format($totalItems) }}
                        </div>
                        <div class="text-xs text-slate-400 mt-1">Kategori aktif</div>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-pending/20 to-pending/10 rounded-xl flex items-center justify-center">
                            <i data-lucide="layers" class="w-6 h-6 lg:w-7 lg:h-7 text-pending"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-6 mt-6">
        <!-- Simplified Filter Section -->
        <div class="lg:col-span-4 xl:col-span-3 no-print">
            <div class="intro-y box mb-5">
                <div class="flex items-center justify-between p-4 sm:p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-semibold text-base">
                        <i data-lucide="filter" class="w-4 h-4 mr-2 inline text-primary"></i>
                        Filter Laporan
                    </h2>
                    <x-base.button variant="outline-secondary" size="sm" id="clearAllFilters">
                        <i data-lucide="rotate-ccw" class="w-3 h-3 mr-1"></i>
                        Reset
                    </x-base.button>
                </div>
                <div class="p-4 sm:p-5">
                    <form id="filterForm" class="space-y-4">
                        <!-- Date Range Section -->
                        <div>
                            <label class="form-label font-medium text-sm mb-3 flex items-center">
                                <i data-lucide="calendar" class="w-4 h-4 mr-2 text-primary"></i>
                                Periode Laporan
                            </label>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="tanggal_mulai" class="block text-xs text-slate-600 mb-1">Dari</label>
                                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control text-sm" 
                                           value="{{ $tanggalMulai }}" max="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label for="tanggal_selesai" class="block text-xs text-slate-600 mb-1">Sampai</label>
                                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control text-sm" 
                                           value="{{ $tanggalSelesai }}" max="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label class="form-label font-medium text-sm mb-2 flex items-center">
                                <i data-lucide="check-circle" class="w-4 h-4 mr-2 text-success"></i>
                                Status Penjualan
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="all" class="form-radio text-primary" 
                                           {{ $status === 'all' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm">Semua</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="sold" class="form-radio text-success"
                                           {{ $status === 'sold' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm">Terjual</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="return" class="form-radio text-danger"
                                           {{ $status === 'return' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm">Retur</span>
                                </label>
                            </div>
                        </div>

                        <!-- Jenis Barang Filter -->
                        <div>
                            <label for="jenis_barang" class="form-label font-medium text-sm flex items-center mb-2">
                                <i data-lucide="tag" class="w-4 h-4 mr-2 text-warning"></i>
                                Jenis Barang
                            </label>
                            <select id="jenis_barang" name="jenis_barang[]" class="form-select" multiple>
                                @foreach($jenisOptions as $jenis)
                                    <option value="{{ $jenis->id }}" 
                                        {{ in_array($jenis->id, $jenisBarang) ? 'selected' : '' }}>
                                        {{ $jenis->jenis }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-xs text-slate-500 mt-1">Pilih satu atau lebih jenis</div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-2">
                            <x-base.button type="submit" variant="primary" class="flex-1">
                                <i data-lucide="search" class="w-4 h-4 mr-2"></i> 
                                Terapkan Filter
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Report Overview Section -->
        <div class="lg:col-span-8 xl:col-span-9">
            <!-- Top Selling Products and Quick Stats Row -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 lg:gap-6 mb-5">
                <!-- Top Selling Products -->
                <div class="intro-y box">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 sm:p-5 border-b border-slate-200/60 dark:border-darkmode-400 gap-2 sm:gap-0">
                        <h2 class="font-semibold text-base">
                            <i data-lucide="trending-up" class="w-4 h-4 mr-2 inline text-success"></i>
                            Barang Terlaris
                        </h2>
                        <div class="text-xs text-slate-500 bg-slate-100 dark:bg-darkmode-800 px-2 py-1 rounded-full self-start sm:self-auto">Top 5</div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div id="topProductsList" class="space-y-3">
                            @if($topProducts->count() > 0)
                                @foreach($topProducts as $index => $product)
                                    <div class="flex items-center p-3 rounded-lg border border-slate-100 dark:border-darkmode-400 hover:bg-slate-50 dark:hover:bg-darkmode-800 transition-colors">
                                        <div class="w-8 h-8 bg-gradient-to-br from-primary/20 to-primary/10 rounded-lg flex items-center justify-center text-primary font-bold text-sm mr-3 flex-shrink-0">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-medium text-slate-800 dark:text-slate-200 truncate">{{ $product['nama'] }}</div>
                                            <div class="text-slate-500 text-xs">{{ $product['jenis'] }}</div>
                                        </div>
                                        <div class="text-right flex-shrink-0 ml-2">
                                            <div class="font-semibold text-slate-800 dark:text-slate-200">{{ number_format($product['total_qty']) }}</div>
                                            <div class="text-slate-500 text-xs">Rp {{ number_format($product['total_revenue'], 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-slate-500 py-8">
                                    <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                                    <p class="font-medium">Tidak ada data barang terlaris</p>
                                    <p class="text-xs mt-1">Sesuaikan filter untuk melihat data</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="intro-y box">
                    <div class="flex items-center p-4 sm:p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-semibold text-base mr-auto">
                            <i data-lucide="bar-chart-2" class="w-4 h-4 mr-2 inline text-info"></i>
                            Statistik Cepat
                        </h2>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0 p-2 sm:p-3 bg-slate-50 dark:bg-darkmode-800 rounded-lg">
                                <span class="text-slate-600 text-xs sm:text-sm">Rata-rata per Transaksi</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-200 text-sm sm:text-base" id="avgPerTransaction">
                                    Rp {{ $totalTransactions > 0 ? number_format($totalRevenue / $totalTransactions, 0, ',', '.') : '0' }}
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0 p-2 sm:p-3 bg-slate-50 dark:bg-darkmode-800 rounded-lg">
                                <span class="text-slate-600 text-xs sm:text-sm">Rata-rata Item per Transaksi</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-200 text-sm sm:text-base" id="avgItemsPerTransaction">
                                    {{ $totalTransactions > 0 ? number_format($totalQuantity / $totalTransactions, 1) : '0' }}
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0 p-2 sm:p-3 bg-slate-50 dark:bg-darkmode-800 rounded-lg">
                                <span class="text-slate-600 text-xs sm:text-sm">Periode</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-200 text-xs sm:text-sm break-words" id="periodInfo">
                                    {{ \Carbon\Carbon::parse($tanggalMulai)->format('d M') }} - {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d M Y') }}
                                </span>
                            </div>
                            @if($totalTransactions > 0)
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0 p-2 sm:p-3 bg-gradient-to-r from-primary/5 to-primary/10 rounded-lg border border-primary/20">
                                    <span class="text-slate-600 text-xs sm:text-sm">Barang Terlaris</span>
                                    <span class="font-semibold text-primary text-xs sm:text-sm break-words">
                                        {{ $topProducts->first()['nama'] ?? 'N/A' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Table -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 sm:p-5 border-b border-slate-200/60 dark:border-darkmode-400 gap-3 sm:gap-0">
                    <div>
                        <h2 class="font-semibold text-base mb-1">
                            <i data-lucide="table" class="w-4 h-4 mr-2 inline text-slate-600"></i>
                            Detail Penjualan
                        </h2>
                        <div class="text-slate-500 text-sm" id="recordCount">
                            {{ number_format($salesData->count()) }} record ditemukan
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 mt-3 sm:mt-0">
                        <span class="text-xs bg-success/10 text-success px-2 sm:px-3 py-1 rounded-full font-medium">● Terjual</span>
                        <span class="text-xs bg-danger/10 text-danger px-2 sm:px-3 py-1 rounded-full font-medium">● Retur</span>
                    </div>
                </div>
                <div class="p-0 sm:p-5">
                    <div class="overflow-x-auto -mx-4 sm:mx-0" id="reportTableContainer">
                        <table class="table table-bordered w-full min-w-[800px]" id="reportTable">
                            <thead>
                                <tr class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-darkmode-800 dark:to-darkmode-700">
                                    <th class="whitespace-nowrap w-12 text-center py-2 sm:py-4 font-semibold text-xs sm:text-sm">#</th>
                                    <th class="whitespace-nowrap w-24 sm:w-32 py-2 sm:py-4 cursor-pointer hover:bg-slate-200 dark:hover:bg-darkmode-600 transition-colors font-semibold text-xs sm:text-sm" onclick="sortTable(1)">
                                        <span class="hidden sm:inline">Tanggal</span>
                                        <span class="sm:hidden">Tgl</span>
                                        <i data-lucide="chevrons-up-down" class="w-3 h-3 inline ml-1"></i>
                                    </th>
                                    <th class="whitespace-nowrap min-w-[120px] sm:min-w-[150px] py-2 sm:py-4 cursor-pointer hover:bg-slate-200 dark:hover:bg-darkmode-600 transition-colors font-semibold text-xs sm:text-sm" onclick="sortTable(2)">
                                        <span class="hidden sm:inline">Nama Barang</span>
                                        <span class="sm:hidden">Barang</span>
                                        <i data-lucide="chevrons-up-down" class="w-3 h-3 inline ml-1"></i>
                                    </th>
                                    <th class="whitespace-nowrap w-20 sm:w-24 py-2 sm:py-4 font-semibold text-xs sm:text-sm">Jenis</th>
                                    <th class="whitespace-nowrap w-16 sm:w-20 py-2 sm:py-4 font-semibold text-xs sm:text-sm">Satuan</th>
                                    <th class="whitespace-nowrap min-w-[100px] sm:min-w-[120px] py-2 sm:py-4 font-semibold text-xs sm:text-sm">Pelanggan</th>
                                    <th class="whitespace-nowrap w-16 sm:w-20 text-center py-2 sm:py-4 cursor-pointer hover:bg-slate-200 dark:hover:bg-darkmode-600 transition-colors font-semibold text-xs sm:text-sm" onclick="sortTable(6)">
                                        Qty <i data-lucide="chevrons-up-down" class="w-3 h-3 inline ml-1"></i>
                                    </th>
                                    <th class="whitespace-nowrap w-24 sm:w-32 text-right py-2 sm:py-4 font-semibold text-xs sm:text-sm">
                                        <span class="hidden sm:inline">Harga Satuan</span>
                                        <span class="sm:hidden">Harga</span>
                                    </th>
                                    <th class="whitespace-nowrap w-24 sm:w-32 text-right py-2 sm:py-4 cursor-pointer hover:bg-slate-200 dark:hover:bg-darkmode-600 transition-colors font-semibold text-xs sm:text-sm" onclick="sortTable(8)">
                                        <span class="hidden sm:inline">Subtotal</span>
                                        <span class="sm:hidden">Total</span>
                                        <i data-lucide="chevrons-up-down" class="w-3 h-3 inline ml-1"></i>
                                    </th>
                                    <th class="whitespace-nowrap w-20 sm:w-24 py-2 sm:py-4 font-semibold text-xs sm:text-sm">Diskon</th>
                                    <th class="whitespace-nowrap w-16 sm:w-20 text-center py-2 sm:py-4 font-semibold text-xs sm:text-sm">Status</th>
                                </tr>
                            </thead>
                            <tbody id="reportTableBody">
                                @if($salesData->count() > 0)
                                    @foreach($salesData as $index => $detail)
                                        @php
                                            $hasReturn = \App\Models\TransaksiRetur::where('transaksi_penjualan_detail_id', $detail->id)->exists();
                                        @endphp
                                        <tr class="hover:bg-slate-50 dark:hover:bg-darkmode-800 transition-colors">
                                            <td class="text-center py-2 sm:py-4 font-medium text-xs sm:text-sm">{{ $index + 1 }}</td>
                                            <td class="py-2 sm:py-4 text-xs sm:text-sm">{{ \Carbon\Carbon::parse($detail->transaksiPenjualan->tgl_transaksi)->format('d/m/Y') }}</td>
                                            <td class="py-2 sm:py-4">
                                                <div class="font-medium text-slate-800 dark:text-slate-200 text-xs sm:text-sm">{{ $detail->barang->nama }}</div>
                                            </td>
                                            <td class="py-2 sm:py-4">
                                                <span class="px-1 sm:px-2 py-1 bg-slate-100 dark:bg-darkmode-800 text-slate-600 dark:text-slate-300 rounded text-xs">
                                                    {{ $detail->barangDetail->jenis->jenis ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="py-2 sm:py-4 text-slate-600 text-xs sm:text-sm">{{ $detail->barangDetail->satuan->satuan ?? '-' }}</td>
                                            <td class="py-2 sm:py-4 text-xs sm:text-sm">{{ $detail->transaksiPenjualan->pelanggan->nama }}</td>
                                            <td class="text-center py-2 sm:py-4 font-semibold text-xs sm:text-sm">{{ number_format($detail->jml_barang) }}</td>
                                            <td class="text-right py-2 sm:py-4 text-xs sm:text-sm">
                                                <span class="hidden sm:inline">Rp </span>{{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-right py-2 sm:py-4 font-semibold text-xs sm:text-sm">
                                                <span class="hidden sm:inline">Rp </span>{{ number_format($detail->subtotal, 0, ',', '.') }}
                                            </td>
                                            <td class="py-2 sm:py-4">
                                                @if($detail->diskon)
                                                    <span class="text-xs bg-warning/20 text-warning px-1 sm:px-2 py-1 rounded-full font-medium">
                                                        <span class="hidden sm:inline">{{ $detail->diskon->nama }} ({{ $detail->diskon->persen }}%)</span>
                                                        <span class="sm:hidden">{{ $detail->diskon->persen }}%</span>
                                                    </span>
                                                @else
                                                    <span class="text-slate-400 text-xs">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center py-2 sm:py-4">
                                                @if($hasReturn)
                                                    <span class="bg-danger/10 text-danger px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
                                                        <span class="hidden sm:inline">Retur</span>
                                                        <span class="sm:hidden">R</span>
                                                    </span>
                                                @else
                                                    <span class="bg-success/10 text-success px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">
                                                        <span class="hidden sm:inline">Terjual</span>
                                                        <span class="sm:hidden">T</span>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11" class="text-center py-8 sm:py-12 text-slate-500">
                                            <i data-lucide="inbox" class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-3 sm:mb-4 text-slate-300"></i>
                                            <p class="text-base sm:text-lg font-medium mb-2">Tidak ada data laporan</p>
                                            <p class="text-xs sm:text-sm">Silakan ubah filter tanggal atau kriteria lainnya</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            @if($salesData->count() > 0)
                                <tfoot>
                                    <tr class="bg-gradient-to-r from-primary/5 to-primary/10 border-t-2 border-primary/20">
                                        <td colspan="6" class="text-right py-2 sm:py-4 font-bold text-slate-800 dark:text-slate-200 text-xs sm:text-sm">Total</td>
                                        <td class="text-center py-2 sm:py-4 font-bold text-primary text-xs sm:text-sm" id="footerQuantity">{{ number_format($salesData->sum('jml_barang')) }}</td>
                                        <td colspan="1" class="py-2 sm:py-4"></td>
                                        <td class="text-right py-2 sm:py-4 font-bold text-primary text-xs sm:text-sm" id="footerSubtotal">
                                            <span class="hidden sm:inline">Rp </span>{{ number_format($salesData->sum('subtotal'), 0, ',', '.') }}
                                        </td>
                                        <td colspan="2" class="py-2 sm:py-4"></td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div> <!-- End Print Area -->

    <!-- Loading indicator -->
    <div id="loadingIndicator" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white dark:bg-darkmode-600 rounded-xl p-6 flex items-center shadow-2xl">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary mr-4"></div>
            <span class="font-medium">Memuat data...</span>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Global functions for button handlers
function printReport() {
    console.log('Print Report function called');
    try {
        // Update print period
        updatePrintPeriod();
        
        // Show print header
        const printHeader = document.querySelector('.print-header');
        if (printHeader) {
            printHeader.style.display = 'block';
        }
        
        // Small delay then print
        setTimeout(() => {
            window.print();
            
            // Hide print header after print
            setTimeout(() => {
                if (printHeader) {
                    printHeader.style.display = 'none';
                }
            }, 500);
        }, 100);
        
    } catch (error) {
        console.error('Print error:', error);
        alert('Terjadi kesalahan saat mencetak. Silakan coba lagi.');
    }
}

function exportReport() {
    console.log('Export Report function called');
    try {
        const form = document.getElementById('filterForm');
        if (!form) {
            alert('Form filter tidak ditemukan');
            return;
        }
        
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();
        console.log('Export params:', params);
        
        // Show loading
        const loadingIndicator = document.getElementById('loadingIndicator');
        if (loadingIndicator) {
            loadingIndicator.classList.remove('hidden');
        }
        
        // Create export URL
        const exportUrl = '{{ route("laporan.export") }}?' + params;
        console.log('Export URL:', exportUrl);
        
        // Trigger download
        window.location.href = exportUrl;
        
        // Hide loading after delay
        setTimeout(() => {
            if (loadingIndicator) {
                loadingIndicator.classList.add('hidden');
            }
        }, 2000);
        
    } catch (error) {
        console.error('Export error:', error);
        alert('Terjadi kesalahan saat mengexport data. Silakan coba lagi.');
    }
}

function updatePrintPeriod() {
    try {
        const startDateInput = document.getElementById('tanggal_mulai');
        const endDateInput = document.getElementById('tanggal_selesai');
        const printPeriodElement = document.getElementById('printPeriod');
        
        if (startDateInput && endDateInput && printPeriodElement) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const options = { day: '2-digit', month: 'long', year: 'numeric' };
            
            const periodText = startDate.toLocaleDateString('id-ID', options) + ' - ' + 
                              endDate.toLocaleDateString('id-ID', options);
            printPeriodElement.textContent = periodText;
        }
    } catch (error) {
        console.error('Error updating print period:', error);
    }
}

$(document).ready(function() {
    console.log('Document ready - laporan page loaded');
    
    // Test if global functions are available
    if (typeof printReport === 'function') {
        console.log('printReport function is available');
    } else {
        console.error('printReport function NOT available');
    }
    
    if (typeof exportReport === 'function') {
        console.log('exportReport function is available');
    } else {
        console.error('exportReport function NOT available');
    }

    // Reset filters functionality
    function resetFilters() {
        // Reset form to default state
        document.getElementById('filterForm').reset();
        
        // Set default date values (current month)
        const today = new Date();
        const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        $('#tanggal_mulai').val(formatDate(startOfMonth));
        $('#tanggal_selesai').val(formatDate(today));
        
        // Reset jenis barang selection
        $('#jenis_barang').val([]).trigger('change');
        
        // Reset status to 'all'
        $('input[name="status"][value="all"]').prop('checked', true);
        
        // Submit the form to apply default filters
        filterData();
    }

    // Form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateDates()) {
            return false;
        }
        
        filterData();
    });

    // Reset button handler
    $('#clearAllFilters').on('click', function() {
        resetFilters();
    });
    

    


    // Date validation
    function validateDates() {
        const startDate = new Date($('#tanggal_mulai').val());
        const endDate = new Date($('#tanggal_selesai').val());
        
        if (startDate > endDate) {
            alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai');
            return false;
        }
        
        const today = new Date();
        if (startDate > today || endDate > today) {
            alert('Tanggal tidak boleh melebihi hari ini');
            return false;
        }
        return true;
    }

    function formatDate(date) {
        return date.toISOString().split('T')[0];
    }
    
    function filterData() {
        const formData = new FormData(document.getElementById('filterForm'));
        
        $('#loadingIndicator').removeClass('hidden');
        
        $.ajax({
            url: '{{ route("laporan.index") }}',
            method: 'GET',
            data: Object.fromEntries(formData),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                updateSummaryStats(response.summary);
                updateReportTable(response.salesData);
                updateTopProducts(response.topProducts);
                updateQuickStats(response.summary);
                $('#loadingIndicator').addClass('hidden');
            },
            error: function(xhr) {
                console.error('Error filtering data:', xhr);
                $('#loadingIndicator').addClass('hidden');
                alert('Terjadi kesalahan saat memfilter data. Silakan coba lagi.');
            }
        });
    }
    
    function updateSummaryStats(summary) {
        $('#totalTransactions').text(new Intl.NumberFormat('id-ID').format(summary.total_transactions));
        $('#totalQuantity').text(new Intl.NumberFormat('id-ID').format(summary.total_quantity));
        $('#totalRevenue').text('Rp ' + new Intl.NumberFormat('id-ID').format(summary.total_revenue));
        $('#totalItems').text(new Intl.NumberFormat('id-ID').format(summary.total_items));
    }
    
    function updateQuickStats(summary) {
        const avgPerTransaction = summary.total_transactions > 0 ? summary.total_revenue / summary.total_transactions : 0;
        const avgItemsPerTransaction = summary.total_transactions > 0 ? summary.total_quantity / summary.total_transactions : 0;
        
        $('#avgPerTransaction').text('Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(avgPerTransaction)));
        $('#avgItemsPerTransaction').text(new Intl.NumberFormat('id-ID', {minimumFractionDigits: 1, maximumFractionDigits: 1}).format(avgItemsPerTransaction));
        
        // Update period info in quick stats
        const startDate = new Date($('#tanggal_mulai').val());
        const endDate = new Date($('#tanggal_selesai').val());
        const options = { day: '2-digit', month: 'short' };
        const optionsWithYear = { day: '2-digit', month: 'short', year: 'numeric' };
        
        let periodText = '';
        if (startDate.getFullYear() === endDate.getFullYear()) {
            periodText = startDate.toLocaleDateString('id-ID', options) + ' - ' + 
                        endDate.toLocaleDateString('id-ID', optionsWithYear);
        } else {
            periodText = startDate.toLocaleDateString('id-ID', optionsWithYear) + ' - ' + 
                        endDate.toLocaleDateString('id-ID', optionsWithYear);
        }
        $('#periodInfo').text(periodText);
    }
    
    function updateReportTable(salesData) {
        const tbody = $('#reportTableBody');
        const recordCount = $('#recordCount');
        const footerQuantity = $('#footerQuantity');
        const footerSubtotal = $('#footerSubtotal');
        
        tbody.empty();
        
        if (salesData.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="11" class="text-center py-12 text-slate-500">
                        <i data-lucide="inbox" class="w-16 h-16 mx-auto mb-4 text-slate-300"></i>
                        <p class="text-lg font-medium mb-2">Tidak ada data laporan</p>
                        <p class="text-sm">Silakan ubah filter tanggal atau kriteria lainnya</p>
                    </td>
                </tr>
            `);
            recordCount.text('0 record ditemukan');
            return;
        }
        
        let totalQuantity = 0;
        let totalSubtotal = 0;
        
        salesData.forEach((detail, index) => {
            totalQuantity += parseInt(detail.jumlah);
            totalSubtotal += parseInt(detail.subtotal);
            
            const date = new Date(detail.tanggal);
            const formattedDate = date.toLocaleDateString('id-ID', { 
                day: '2-digit', 
                month: '2-digit', 
                year: 'numeric' 
            });
            
            const statusBadge = detail.has_return ? 
                '<span class="bg-danger/10 text-danger px-2 sm:px-3 py-1 rounded-full text-xs font-semibold"><span class="hidden sm:inline">Retur</span><span class="sm:hidden">R</span></span>' :
                '<span class="bg-success/10 text-success px-2 sm:px-3 py-1 rounded-full text-xs font-semibold"><span class="hidden sm:inline">Terjual</span><span class="sm:hidden">T</span></span>';
            
            const discountInfo = detail.diskon && detail.diskon !== '-' ? 
                `<span class="text-xs bg-warning/20 text-warning px-1 sm:px-2 py-1 rounded-full font-medium"><span class="hidden sm:inline">${detail.diskon}</span><span class="sm:hidden">%</span></span>` :
                '<span class="text-slate-400 text-xs">-</span>';
            
            tbody.append(`
                <tr class="hover:bg-slate-50 dark:hover:bg-darkmode-800 transition-colors">
                    <td class="text-center py-2 sm:py-4 font-medium text-xs sm:text-sm">${index + 1}</td>
                    <td class="py-2 sm:py-4 text-xs sm:text-sm">${formattedDate}</td>
                    <td class="py-2 sm:py-4">
                        <div class="font-medium text-slate-800 dark:text-slate-200 text-xs sm:text-sm">${detail.nama_barang}</div>
                    </td>
                    <td class="py-2 sm:py-4">
                        <span class="px-1 sm:px-2 py-1 bg-slate-100 dark:bg-darkmode-800 text-slate-600 dark:text-slate-300 rounded text-xs">
                            ${detail.jenis}
                        </span>
                    </td>
                    <td class="py-2 sm:py-4 text-slate-600 text-xs sm:text-sm">${detail.satuan}</td>
                    <td class="py-2 sm:py-4 text-xs sm:text-sm">${detail.pelanggan}</td>
                    <td class="text-center py-2 sm:py-4 font-semibold text-xs sm:text-sm">${new Intl.NumberFormat('id-ID').format(detail.jumlah)}</td>
                    <td class="text-right py-2 sm:py-4 text-xs sm:text-sm"><span class="hidden sm:inline">Rp </span>${new Intl.NumberFormat('id-ID').format(detail.harga_satuan)}</td>
                    <td class="text-right py-2 sm:py-4 font-semibold text-xs sm:text-sm"><span class="hidden sm:inline">Rp </span>${new Intl.NumberFormat('id-ID').format(detail.subtotal)}</td>
                    <td class="py-2 sm:py-4">${discountInfo}</td>
                    <td class="text-center py-2 sm:py-4">${statusBadge}</td>
                </tr>
            `);
        });
        
        recordCount.text(new Intl.NumberFormat('id-ID').format(salesData.length) + ' record ditemukan');
        footerQuantity.text(new Intl.NumberFormat('id-ID').format(totalQuantity));
        footerSubtotal.text((window.innerWidth > 640 ? 'Rp ' : '') + new Intl.NumberFormat('id-ID').format(totalSubtotal));
        
        // Re-initialize Lucide icons
        lucide.createIcons();
    }
    
    function updateTopProducts(topProducts) {
        const container = $('#topProductsList');
        container.empty();
        
        if (Object.keys(topProducts).length === 0) {
            container.append(`
                <div class="text-center text-slate-500 py-8">
                    <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                    <p class="font-medium">Tidak ada data barang terlaris</p>
                    <p class="text-xs mt-1">Sesuaikan filter untuk melihat data</p>
                </div>
            `);
            return;
        }
        
        Object.values(topProducts).forEach((product, index) => {
            container.append(`
                <div class="flex items-center p-3 rounded-lg border border-slate-100 dark:border-darkmode-400 hover:bg-slate-50 dark:hover:bg-darkmode-800 transition-colors ${index < Object.keys(topProducts).length - 1 ? 'mb-3' : ''}">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary/20 to-primary/10 rounded-lg flex items-center justify-center text-primary font-bold text-sm mr-3 flex-shrink-0">
                        ${index + 1}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-slate-800 dark:text-slate-200 truncate">${product.nama}</div>
                        <div class="text-slate-500 text-xs">${product.jenis}</div>
                    </div>
                    <div class="text-right flex-shrink-0 ml-2">
                        <div class="font-semibold text-slate-800 dark:text-slate-200">${new Intl.NumberFormat('id-ID').format(product.total_qty)}</div>
                        <div class="text-slate-500 text-xs">Rp ${new Intl.NumberFormat('id-ID').format(product.total_revenue)}</div>
                    </div>
                </div>
            `);
        });
        
        // Re-initialize Lucide icons
        lucide.createIcons();
    }
});

// Table sorting functionality
function sortTable(columnIndex) {
    const table = document.getElementById('reportTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = Array.from(tbody.rows);
    const isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        // Check if sorting by number
        if (columnIndex === 6 || columnIndex === 8) { // Qty or Subtotal
            const aNum = parseFloat(aText.replace(/[^\d]/g, ''));
            const bNum = parseFloat(bText.replace(/[^\d]/g, ''));
            return isAscending ? aNum - bNum : bNum - aNum;
        }
        
        // Sort by text
        return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText);
    });
    
    // Update row numbers
    rows.forEach((row, index) => {
        row.cells[0].textContent = index + 1;
        tbody.appendChild(row);
    });
    
    table.setAttribute('data-sort-direction', isAscending ? 'asc' : 'desc');
}
</script>

<style>
/* Responsive table styles */
@media (max-width: 768px) {
    .table th,
    .table td {
        padding: 8px 4px !important;
        font-size: 12px !important;
    }
    
    .table th:first-child,
    .table td:first-child {
        padding-left: 8px !important;
    }
    
    .table th:last-child,
    .table td:last-child {
        padding-right: 8px !important;
    }
    
    #reportTableContainer {
        padding: 0 16px;
    }
}

@media (max-width: 640px) {
    .table th,
    .table td {
        padding: 6px 3px !important;
        font-size: 11px !important;
        white-space: nowrap;
    }
    
    /* Hide less important columns on very small screens */
    .table th:nth-child(4), /* Jenis */
    .table td:nth-child(4),
    .table th:nth-child(5), /* Satuan */
    .table td:nth-child(5),
    .table th:nth-child(10), /* Diskon */
    .table td:nth-child(10) {
        display: none;
    }
}

/* Touch improvements */
.touch-manipulation {
    touch-action: manipulation;
    -webkit-tap-highlight-color: transparent;
}

.min-h-touch {
    min-height: 44px;
}

/* Print styles */
@media print {
    /* Hide everything by default */
    body * {
        visibility: hidden;
    }
    
    /* Show only printable content */
    .print-area,
    .print-area * {
        visibility: visible;
    }
    
    /* Print layout */
    .print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 20px;
    }
    
    /* Remove shadows and backgrounds */
    .box {
        box-shadow: none !important;
        border: 1px solid #000 !important;
        background: white !important;
    }
    
    /* Print header styling */
    .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
    }
    
    .print-header h1 {
        font-size: 18px !important;
        font-weight: bold;
        margin: 0 0 5px 0;
        color: #000 !important;
    }
    
    .print-header h2 {
        font-size: 14px !important;
        margin: 0 0 10px 0;
        color: #000 !important;
    }
    
    .print-header p {
        font-size: 12px !important;
        margin: 2px 0;
        color: #000 !important;
    }
    
    .print-summary {
        margin-bottom: 15px;
        font-size: 11px;
    }
    
    /* Table styling for print */
    .table {
        border-collapse: collapse !important;
        width: 100% !important;
        font-size: 9px !important;
    }
    
    .table th,
    .table td {
        border: 1px solid #000 !important;
        padding: 3px !important;
        text-align: left !important;
    }
    
    .table th {
        background-color: #f0f0f0 !important;
        font-weight: bold !important;
    }
    
    /* Hide interactive elements */
    .no-print {
        display: none !important;
    }
    
    /* Show hidden mobile elements */
    .sm\:hidden {
        display: table-cell !important;
    }
    
    .hidden {
        display: none !important;
    }
    
    /* Page break settings */
    .print-area {
        page-break-inside: avoid;
    }
    
    .table {
        page-break-inside: auto;
    }
    
    .table tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
}
</style>
@endpush