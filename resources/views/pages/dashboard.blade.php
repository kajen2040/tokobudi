@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $storeSettings['store_name'] }} - Dashboard</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">General Report</h2>
                        <a
                            class="ml-auto flex items-center text-primary"
                            href=""
                        >
                            <x-base.lucide
                                class="mr-3 h-4 w-4"
                                icon="RefreshCcw"
                            /> Reload Data
                        </a>
                    </div>
                    <div class="mt-5 grid grid-cols-12 gap-6">
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-yellow-400"
                                            icon="Layers"
                                        />
                                        <div class="ml-auto">
                                            
                                        </div>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ $itemTypesCount }}</div>
                                    <div class="mt-1 text-base text-slate-500">Jenis Barang</div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-success"
                                            icon="CheckCircle"
                                        />
                                        <div class="ml-auto">
                                            
                                        </div>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ $totalStock }}</div>
                                    <div class="mt-1 text-base text-slate-500">Stok Barang</div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-blue-600"
                                            icon="ShoppingCart"
                                        />
                                        <div class="ml-auto">
                                           
                                        </div>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ $totalSales }}</div>
                                    <div class="mt-1 text-base text-slate-500">
                                        Total Penjualan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-danger"
                                            icon="ThumbsDown"
                                        />
                                        <div class="ml-auto">
                                            
                                        </div>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ $totalRetur }}</div>
                                    <div class="mt-1 text-base text-slate-500">
                                        Total Retur
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
                <!-- BEGIN: Sales Report -->
                <div class="col-span-12 mt-8 lg:col-span-12">
                    <div class="intro-y block h-10 items-center sm:flex">
                        <h2 class="mr-5 truncate text-lg font-medium">Sales Report</h2>
                    </div>
                    <div class="intro-y box mt-12 p-5 sm:mt-5">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="flex">
                                <div>
                                    <div class="text-lg font-medium text-primary dark:text-slate-300 xl:text-xl">
                                        {{ $currentMonthSalesCount }} penjualan
                                    </div>
                                    <div class="mt-0.5 text-slate-500">Bulan ini</div>
                                </div>
                                <div
                                    class="mx-4 h-12 w-px border border-r border-dashed border-slate-200 dark:border-darkmode-300 xl:mx-5">
                                </div>
                                <div>
                                    <div class="text-lg font-medium text-slate-500 xl:text-xl">
                                        {{ $previousMonthSalesCount }} penjualan
                                    </div>
                                    <div class="mt-0.5 text-slate-500">Bulan kemarin</div>
                                </div>
                            </div>
                        </div>
                        <!-- Store monthly sales data in a hidden input for JavaScript to use -->
                        <input type="hidden" id="monthlySalesData" value="{{ json_encode(array_values($monthlySalesData)) }}">
                        
                        <!-- BEGIN: Vertical Bar Chart -->
                        <x-base.preview-component class="intro-y">
                            <div
                                class="flex flex-col items-center border-slate-200/60 p-2 dark:border-darkmode-400 sm:flex-row">
                            </div>
                            <div class="p-5">
                                <x-base.preview>
                                    <x-vertical-bar-chart height="h-[300px]" />
                                </x-base.preview>
                                <x-base.source>
                                    <x-base.highlight>
                                        <x-vertical-bar-chart height="h-[300px]" />
                                    </x-base.highlight>
                                </x-base.source>
                            </div>
                        </x-base.preview-component>
                        <!-- END: Vertical Bar Chart -->
                    </div>
                </div>
                <!-- END: Sales Report -->
            </div>
        </div>
    </div>
@endsection
