@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Dashboard - Toko Budi</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
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
                                        49 penjualan
                                    </div>
                                    <div class="mt-0.5 text-slate-500">Bulan ini</div>
                                </div>
                                <div
                                    class="mx-4 h-12 w-px border border-r border-dashed border-slate-200 dark:border-darkmode-300 xl:mx-5">
                                </div>
                                <div>
                                    <div class="text-lg font-medium text-slate-500 xl:text-xl">
                                        25 penjualan
                                    </div>
                                    <div class="mt-0.5 text-slate-500">Bulan kemarin</div>
                                </div>
                            </div>
                        </div>
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
                <!-- BEGIN: Total Sales -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">Total Sales</h2>
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
                                            class="h-[28px] w-[28px] text-primary"
                                            icon="ShoppingCart"
                                        />
                                        <div class="ml-auto">
                                            
                                        </div>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ $totalSales }}</div>
                                    <div class="mt-1 text-base text-slate-500">Total Penjualan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Total Sales -->
            </div>
        </div>
        <div class="col-span-12 2xl:col-span-3">
            <div class="-mb-10 pb-10 2xl:border-l">
                <div class="grid grid-cols-12 gap-x-6 gap-y-6 2xl:gap-x-0 2xl:pl-6">
                    
                    <!-- BEGIN: Important Notes -->
                    <div
                        class="col-span-12 mt-3 md:col-span-6 xl:col-span-12 xl:col-start-1 xl:row-start-1 2xl:col-start-auto 2xl:row-start-auto">
                        <div class="intro-x flex h-10 items-center">
                            <h2 class="mr-auto truncate text-lg font-medium">
                                Pesan Penting
                            </h2>
                            <x-base.button
                                class="tiny-slider-navigator mr-2 border-slate-300 px-2 text-slate-600 dark:text-slate-300"
                                data-carousel="important-notes"
                                data-target="prev"
                            >
                                <x-base.lucide
                                    class="h-4 w-4"
                                    icon="ChevronLeft"
                                />
                            </x-base.button>
                            <x-base.button
                                class="tiny-slider-navigator mr-2 border-slate-300 px-2 text-slate-600 dark:text-slate-300"
                                data-carousel="important-notes"
                                data-target="next"
                            >
                                <x-base.lucide
                                    class="h-4 w-4"
                                    icon="ChevronRight"
                                />
                            </x-base.button>
                        </div>
                        <div class="intro-x mt-5">
                            <div class="box zoom-in">
                                <x-base.tiny-slider id="important-notes">
                                    <div class="p-5">
                                        <div class="truncate text-base font-medium">
                                            Bersikaplah ramah 
                                        </div>
                                        <div class="mt-1 text-slate-400">2 Hours ago</div>
                                        <div class="mt-1 text-justify text-slate-500">
                                            Sapa dan senyum kepada setiap pembeli yang datang.
                                        </div>

                                    </div>
                                    <div class="p-5">
                                        <div class="truncate text-base font-medium">
                                            Teliti ketika bertransaksi
                                        </div>
                                        <div class="mt-1 text-slate-400">5 Hours ago</div>
                                        <div class="mt-1 text-justify text-slate-500">
                                            Pastikan semua transaksi dilakukan dengan benar dan terekam di aplikasi.
                                        </div>
                                        
                                    </div>
                                    <div class="p-5">
                                        <div class="truncate text-base font-medium">
                                            Cek berkala stok barang
                                        </div>
                                        <div class="mt-1 text-slate-400">11 Hours ago</div>
                                        <div class="mt-1 text-justify text-slate-500">
                                            Rutin cek stok barang dan laporkan jika ada barang yang habis.
                                        </div>
                                        
                                    </div>
                                </x-base.tiny-slider>
                            </div>
                        </div>
                    </div>
                    <!-- END: Important Notes -->
                    
                </div>
            </div>
        </div>
    </div>
@endsection
