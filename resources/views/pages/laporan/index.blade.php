@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $storeSettings['store_name'] }} - Laporan Penjualan</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            <span class="text-primary">Laporan Penjualan</span> 
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <x-base.button variant="primary" class="shadow-md mr-2">
                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Download Laporan
            </x-base.button>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Filter Laporan
                    </h2>
                </div>
                <div id="input" class="p-5">
                    <div class="preview">
                        <div>
                            <label for="regular-form-1" class="form-label">Tanggal Mulai</label>
                            <div class="input-group">
                                <input type="date" class="form-control" placeholder="Pilih tanggal mulai">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Tanggal Selesai</label>
                            <div class="input-group">
                                <input type="date" class="form-control" placeholder="Pilih tanggal selesai">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Jenis Barang</label>
                            <select data-placeholder="Pilih Jenis Barang" class="tom-select w-full" multiple>
                                <option value="1" selected>Sport & Outdoor</option>
                                <option value="2">PC & Laptop</option>
                                <option value="3" selected>Smartphone & Tablet</option>
                                <option value="4">Photography</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Status</label>
                            <div class="flex flex-col sm:flex-row mt-2">
                                <div class="form-check mr-2">
                                    <input id="radio-switch-4" class="form-check-input" type="radio" name="status_filter" value="all" checked>
                                    <label class="form-check-label" for="radio-switch-4">Semua</label>
                                </div>
                                <div class="form-check mr-2">
                                    <input id="radio-switch-5" class="form-check-input" type="radio" name="status_filter" value="sold">
                                    <label class="form-check-label" for="radio-switch-5">Terjual</label>
                                </div>
                                <div class="form-check mr-2">
                                    <input id="radio-switch-6" class="form-check-input" type="radio" name="status_filter" value="return">
                                    <label class="form-check-label" for="radio-switch-6">Retur</label>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-4">
                            <x-base.button variant="outline-secondary" class="w-20 mr-1">
                                <i data-lucide="x" class="w-4 h-4 mr-1"></i> Reset
                            </x-base.button>
                            <x-base.button variant="primary" class="w-20">
                                <i data-lucide="filter" class="w-4 h-4 mr-1"></i> Filter
                            </x-base.button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Preview -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Preview Laporan
                    </h2>
                </div>
                <div class="p-5">
                    <div class="preview">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-slate-50 dark:bg-darkmode-800">
                                        <th class="whitespace-nowrap w-12 text-center py-3">#</th>
                                        <th class="whitespace-nowrap w-32 py-3">Tanggal</th>
                                        <th class="whitespace-nowrap min-w-[200px] py-3">Nama Barang</th>
                                        <th class="whitespace-nowrap w-24 text-center py-3">Jumlah</th>
                                        <th class="whitespace-nowrap w-40 text-right py-3">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-darkmode-800">
                                        <td class="text-center py-3">1</td>
                                        <td class="py-3">01 Jan 2024</td>
                                        <td class="py-3">Minyak Goreng</td>
                                        <td class="text-center py-3">5</td>
                                        <td class="text-right py-3">Rp 150.000</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-darkmode-800">
                                        <td class="text-center py-3">2</td>
                                        <td class="py-3">02 Jan 2024</td>
                                        <td class="py-3">Beras</td>
                                        <td class="text-center py-3">3</td>
                                        <td class="text-right py-3">Rp 120.000</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-darkmode-800">
                                        <td class="text-center py-3">3</td>
                                        <td class="py-3">03 Jan 2024</td>
                                        <td class="py-3">Gula Pasir</td>
                                        <td class="text-center py-3">2</td>
                                        <td class="text-right py-3">Rp 50.000</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="font-medium bg-primary/5">
                                        <td colspan="4" class="text-right py-3">Total</td>
                                        <td class="text-right py-3">Rp 320.000</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Preview -->
        </div>
    </div>
@endsection

<script>
    
</script>