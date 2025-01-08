@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Quick Count</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Sales Report -->
                <div class="col-span-12 mt-8 lg:col-span-6">
                    
                    <div class="intro-y mt-12 sm:mt-5">
                        <div class="mt-2 grid grid-cols-1 gap-6">
                        
                            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                                <div @class([
                                    'relative zoom-in',
                                    "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
                                ])>
                                    <div class="box p-5">
                                        <div class="flex">
                                            <x-base.lucide
                                                class="h-[28px] w-[28px] text-success"
                                                icon="Monitor"
                                            />
                                            <div class="mx-1 text-xl font-medium text-success">Quick Count</div>
                                            <div class="ml-auto">
                                                <x-base.tippy
                                                    class="flex cursor-pointer items-center rounded-full bg-success py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                    as="div"
                                                    content="75% dari DPT"
                                                >
                                                    75%
                                                    
                                                </x-base.tippy>
                                            </div>
                                        </div>
                                        <div class="mt-6 text-3xl font-medium leading-8">735.819</div>
                                        <div class="mt-1 text-base text-slate-500">
                                            Suara Masuk
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                        <div class="mt-6 grid grid-cols-6 gap-6">
                        
                            
                            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                                <div @class([
                                    'relative zoom-in',
                                    "before:box before:absolute before:inset-x-3 before:mt-3 before:h-full before:bg-slate-50 before:content-['']",
                                ])>
                                    <div class="box p-5">
                                        <div class="flex">
                                            <p class="text-xl text-yellow-500 font-medium">01</p>
                                            <div class="ml-auto">
                                                <x-base.tippy
                                                    class="flex cursor-pointer items-center rounded-full bg-yellow-400 py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                    as="div"
                                                    content="65% dari suara masuk"
                                                >
                                                    65%
                                                    
                                                </x-base.tippy>
                                            </div>
                                        </div>
                                        <div class="mt-6 text-3xl font-medium leading-8">450.149</div>
                                        <div class="mt-1 text-base text-slate-500">
                                            Fadia - Sukirman
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
                                            <p class="text-xl text-red-500 font-medium">02</p>
                                            <div class="ml-auto">
                                                <x-base.tippy
                                                    class="flex cursor-pointer items-center rounded-full bg-red-600 py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                    as="div"
                                                    content="35% dari suara masuk"
                                                >
                                                    35%
                                                    
                                                </x-base.tippy>
                                            </div>
                                        </div>
                                        <div class="mt-6 text-3xl font-medium leading-8">250.149</div>
                                        <div class="mt-1 text-base text-slate-500">
                                            Riswadi - Amin
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>
                <!-- END: Sales Report -->
                <!-- BEGIN: Weekly Top Seller -->
                <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-6">
                    
                    <div class="intro-y box mt-5 p-5">
                        <div class="mt-3">
                            <x-report-pie-chart height="h-[203px]" />
                        </div>
                        <div class="mx-auto mt-8 w-52 sm:w-auto">
                            <div class="flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-primary"></div>
                                <span class="truncate">Fadia - Sukirman</span>
                                <span class="ml-auto font-medium">65%</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-pending"></div>
                                <span class="truncate">Riswadi - Amin</span>
                                <span class="ml-auto font-medium">35%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Weekly Top Seller -->
            </div>
        </div>
    </div>

    <div x-data="{ kecamatan: {} }" class="mt-5 grid grid-cols-12 gap-6">
        <div class="col-span-12 mt-6">
            <div class="intro-y block h-10 mb-10 sm:mb-0 items-center sm:flex">
                <h2 class="mr-5 truncate text-lg font-medium">
                    Detail 
                </h2>
                <div class="mt-3 flex items-center sm:ml-auto sm:mt-0">
                    <x-base.button class="!box flex items-center text-slate-600 dark:text-slate-300">
                        <x-base.lucide
                            class="mr-2 hidden h-4 w-4 sm:block"
                            icon="FileText"
                        />
                        Export to Excel
                    </x-base.button>
                    <x-base.button class="!box ml-3 flex items-center text-slate-600 dark:text-slate-300">
                        <x-base.lucide
                            class="mr-2 hidden h-4 w-4 sm:block"
                            icon="FileText"
                        />
                        Export to PDF
                    </x-base.button>
                </div>
            </div>
        </div>
        
        
            
            <!-- BEGIN: List kecamatan -->
            @foreach ($fakers as $faker)
                <div class="intro-y col-span-12 md:col-span-4">
                    <div class="box">
                        <div class="flex flex-col items-center p-5 lg:flex-row">

                            <div class="mt-3 text-center lg:ml-2 lg:mr-auto lg:mt-0 lg:text-left">
                                <a
                                    class="text-lg font-large"
                                    data-tw-toggle="modal"
                                    data-tw-target="#header-footer-slide-over-preview"
                                    href="#"
                                    as="a"
                                    @click="kecamatan = { name: 'Tirto' }"
                                >
                                    {{-- <mark class="bg-slate-100 text-slate-500 p-1">1. </mark> --}}
                                    Kajen 
                                
                                    <div class="mt-0.5 text-xs text-slate-500">
                                        <mark class="text-md  bg-slate-100 font-medium text-yellow-400 p-1">1.544</mark> /
                                        <mark class="text-md  bg-slate-100 font-medium text-red-600 p-1">2.120</mark>
                                    </div>
                                </a>
                            </div>
                            <div class="mt-4 flex flex-col sm:flex-row items-center lg:mt-0">
                                
                                <x-base.button
                                    class="mr-2 px-4 py-2 "
                                    variant="outline-secondary"
                                    data-tw-toggle="modal"
                                    data-tw-target="#header-footer-slide-over-preview"
                                    href="#"
                                    as="a"
                                    @click="kecamatan = { name: 'Kajen' }"
                                >
                                    <mark class="text-md bg-yellow-300 font-medium text-slate-800 p-1">65%</mark>
                                    <mark class="text-md bg-red-500 font-medium text-slate-100 p-1">35%</mark>
                                </x-base.button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
            <!-- END: List kecamatan -->
        
            
            <!-- BEGIN: List desa per kecamatan -->
            <x-base.preview-component>
                
                <div
                    class="p-5"
                    id="header-footer-slideover"
                >
                    <x-base.preview>
                        
                        <!-- BEGIN: Slide Over Content -->
                        <x-base.slideover
                            id="header-footer-slide-over-preview"
                            staticBackdrop
                        >
                            <!-- BEGIN: Slide Over Header -->
                            <x-base.slideover.panel>
                                <a
                                    class="absolute top-0 left-0 right-auto mt-4 -ml-10 sm:-ml-12"
                                    data-tw-dismiss="modal"
                                    href="#"
                                >
                                    <x-base.lucide
                                        class="w-8 h-8 text-slate-400"
                                        icon="X"
                                    />
                                </a>
                                <x-base.slideover.title>
                                    <h2 class="mr-auto text-base font-medium" x-text="kecamatan.name">
                                        
                                    </h2>
                                    <x-base.button
                                        class="hidden sm:flex"
                                        variant="outline-secondary"
                                    >
                                        <x-base.lucide
                                            class="w-4 h-4 mr-2"
                                            icon="File"
                                        />
                                        Download Docs
                                    </x-base.button>
                                    <x-base.menu class="sm:hidden">
                                        <x-base.menu.button
                                            class="block w-5 h-5"
                                            href="#"
                                            as="a"
                                        >
                                            <x-base.lucide
                                                class="w-5 h-5 text-slate-500"
                                                icon="MoreHorizontal"
                                            />
                                        </x-base.menu.button>
                                        <x-base.menu.items class="w-40">
                                            <x-base.menu.item>
                                                <x-base.lucide
                                                    class="w-4 h-4 mr-2"
                                                    icon="File"
                                                />
                                                Download Docs
                                            </x-base.menu.item>
                                        </x-base.menu.items>
                                    </x-base.menu>
                                </x-base.slideover.title>
                                <!-- END: Slide Over Header -->
                                <!-- BEGIN: Slide Over Body -->
                                <x-base.slideover.description>
                                    <div>
                                        <!-- BEGIN: Boxed Accordion -->
                                        {{-- <x-base.preview-component class="">
                                            
                                            <div class="py-5">
                                                <x-base.preview>
                                                    <x-base.disclosure.group variant="boxed">
                                                        <x-base.disclosure
                                                            id="faq-accordion-5"
                                                            :index="0"
                                                        >
                                                            <x-base.disclosure.button>
                                                                OpenSSL Essentials: Working with SSL Certificates,
                                                                Private Keys
                                                            </x-base.disclosure.button>
                                                            <x-base.disclosure.panel class="leading-relaxed text-slate-600 dark:text-slate-500">
                                                                Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. Lorem Ipsum has been the
                                                                industry's standard dummy text ever since the 1500s,
                                                                when an unknown printer took a galley of type and
                                                                scrambled it to make a type specimen book. It has
                                                                survived not only five centuries, but also the leap
                                                                into electronic typesetting, remaining essentially
                                                                unchanged.
                                                            </x-base.disclosure.panel>
                                                        </x-base.disclosure>
                                                        <x-base.disclosure
                                                            id="faq-accordion-6"
                                                            :index="1"
                                                        >
                                                            <x-base.disclosure.button>
                                                                Understanding IP Addresses, Subnets, and CIDR Notation
                                                            </x-base.disclosure.button>
                                                            <x-base.disclosure.panel class="leading-relaxed text-slate-600 dark:text-slate-500">
                                                                Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. Lorem Ipsum has been the
                                                                industry's standard dummy text ever since the 1500s,
                                                                when an unknown printer took a galley of type and
                                                                scrambled it to make a type specimen book. It has
                                                                survived not only five centuries, but also the leap
                                                                into electronic typesetting, remaining essentially
                                                                unchanged.
                                                            </x-base.disclosure.panel>
                                                        </x-base.disclosure>
                                                        <x-base.disclosure
                                                            id="faq-accordion-7"
                                                            :index="2"
                                                        >
                                                            <x-base.disclosure.button>
                                                                How To Troubleshoot Common HTTP Error Codes
                                                            </x-base.disclosure.button>
                                                            <x-base.disclosure.panel class="leading-relaxed text-slate-600 dark:text-slate-500">
                                                                Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. Lorem Ipsum has been the
                                                                industry's standard dummy text ever since the 1500s,
                                                                when an unknown printer took a galley of type and
                                                                scrambled it to make a type specimen book. It has
                                                                survived not only five centuries, but also the leap
                                                                into electronic typesetting, remaining essentially
                                                                unchanged.
                                                            </x-base.disclosure.panel>
                                                        </x-base.disclosure>
                                                        <x-base.disclosure
                                                            id="faq-accordion-8"
                                                            :index="3"
                                                        >
                                                            <x-base.disclosure.button>
                                                                An Introduction to Securing your Linux VPS
                                                            </x-base.disclosure.button>
                                                            <x-base.disclosure.panel class="leading-relaxed text-slate-600 dark:text-slate-500">
                                                                Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. Lorem Ipsum has been the
                                                                industry's standard dummy text ever since the 1500s,
                                                                when an unknown printer took a galley of type and
                                                                scrambled it to make a type specimen book. It has
                                                                survived not only five centuries, but also the leap
                                                                into electronic typesetting, remaining essentially
                                                                unchanged.
                                                            </x-base.disclosure.panel>
                                                        </x-base.disclosure>
                                                    </x-base.disclosure.group>
                                                </x-base.preview>
                                                <x-base.source>
                                                    <x-base.highlight>
                                                        <x-base.disclosure.group variant="boxed">
                                                            <x-base.disclosure
                                                                id="faq-accordion-5"
                                                                :index="0"
                                                            >
                                                                <x-base.disclosure.button>
                                                                    OpenSSL Essentials: Working with SSL Certificates,
                                                                    Private Keys
                                                                </x-base.disclosure.button>
                                                                <x-base.disclosure.panel class="leading-relaxed text-slate-600 dark:text-slate-500">
                                                                    Lorem Ipsum is simply dummy text of the printing and
                                                                    typesetting industry. Lorem Ipsum has been the
                                                                    industry's standard dummy text ever since the 1500s,
                                                                    when an unknown printer took a galley of type and
                                                                    scrambled it to make a type specimen book. It has
                                                                    survived not only five centuries, but also the leap
                                                                    into electronic typesetting, remaining essentially
                                                                    unchanged.
                                                                </x-base.disclosure.panel>
                                                            </x-base.disclosure>
                                                            <x-base.disclosure
                                                                id="faq-accordion-6"
                                                                :index="1"
                                                            >
                                                                <x-base.disclosure.button>
                                                                    Understanding IP Addresses, Subnets, and CIDR Notation
                                                                </x-base.disclosure.button>
                                                                <x-base.disclosure.panel class="leading-relaxed text-slate-600 dark:text-slate-500">
                                                                    Lorem Ipsum is simply dummy text of the printing and
                                                                    typesetting industry. Lorem Ipsum has been the
                                                                    industry's standard dummy text ever since the 1500s,
                                                                    when an unknown printer took a galley of type and
                                                                    scrambled it to make a type specimen book. It has
                                                                    survived not only five centuries, but also the leap
                                                                    into electronic typesetting, remaining essentially
                                                                    unchanged.
                                                                </x-base.disclosure.panel>
                                                            </x-base.disclosure>
                                                            <x-base.disclosure
                                                                id="faq-accordion-7"
                                                                :index="2"
                                                            >
                                                                <x-base.disclosure.button>
                                                                    How To Troubleshoot Common HTTP Error Codes
                                                                </x-base.disclosure.button>
                                                                <x-base.disclosure.panel class="leading-relaxed text-slate-600 dark:text-slate-500">
                                                                    Lorem Ipsum is simply dummy text of the printing and
                                                                    typesetting industry. Lorem Ipsum has been the
                                                                    industry's standard dummy text ever since the 1500s,
                                                                    when an unknown printer took a galley of type and
                                                                    scrambled it to make a type specimen book. It has
                                                                    survived not only five centuries, but also the leap
                                                                    into electronic typesetting, remaining essentially
                                                                    unchanged.
                                                                </x-base.disclosure.panel>
                                                            </x-base.disclosure>
                                                            <x-base.disclosure
                                                                id="faq-accordion-8"
                                                                :index="3"
                                                            >
                                                                <x-base.disclosure.button>
                                                                    An Introduction to Securing your Linux VPS
                                                                </x-base.disclosure.button>
                                                                <x-base.disclosure.panel class="leading-relaxed text-slate-600 dark:text-slate-500">
                                                                    Lorem Ipsum is simply dummy text of the printing and
                                                                    typesetting industry. Lorem Ipsum has been the
                                                                    industry's standard dummy text ever since the 1500s,
                                                                    when an unknown printer took a galley of type and
                                                                    scrambled it to make a type specimen book. It has
                                                                    survived not only five centuries, but also the leap
                                                                    into electronic typesetting, remaining essentially
                                                                    unchanged.
                                                                </x-base.disclosure.panel>
                                                            </x-base.disclosure>
                                                        </x-base.disclosure.group>
                                                    </x-base.highlight>
                                                </x-base.source>
                                            </div>
                                        </x-base.preview-component> --}}
                                        <!-- END: Boxed Accordion -->

                                        <div class="overflow-x-auto">
                                    
                                            <x-base.table class="border">
                                                <x-base.table.thead>
                                                    <x-base.table.tr>
                                                        <x-base.table.th class="bg-slate-200 dark:bg-darkmode-800">
                                                            Tanjungsari
                                                        </x-base.table.th>
                                                        <x-base.table.th
                                                            class="whitespace-nowrap bg-slate-200 !px-2 text-slate-500 dark:bg-darkmode-800"
                                                        >
                                                            <label class="text-slate-500">Fadia</label>
                                                        </x-base.table.th>
                                                        <x-base.table.th
                                                            class="whitespace-nowrap bg-slate-200 !px-2 text-slate-500 dark:bg-darkmode-800"
                                                        >
                                                            <label class="text-slate-500">Riswadi</label>
                                                        </x-base.table.th>
                                                    </x-base.table.tr>
                                                </x-base.table.thead>
                                                <x-base.table.tbody>
        
                                                    {{-- @foreach ($d->pemetaan as $pemetaan) --}}
                                                        <x-base.table.tr>
                                                            <x-base.table.td class="whitespace-nowrap">
                                                                
                                                                TPS 001
                                                                
                                                            </x-base.table.td>
                                                            <x-base.table.td class="!px-2">
                                                                <x-base.form-input
                                                                    class="min-w-[6rem]"
                                                                    type="number"
                                                                    placeholder="..."
                                                                    id=""
                                                                    value="123"
                                                                    {{-- oninput="update({{ $pemetaan->id }}, 'l', this.value)" --}}
                                                                />
                                                            </x-base.table.td>
                                                            <x-base.table.td class="!px-2">
                                                                <x-base.form-input
                                                                    class="min-w-[6rem]"
                                                                    type="number"
                                                                    placeholder="..."
                                                                    id=""
                                                                    value="123"
                                                                    {{-- oninput="update({{ $pemetaan->id }}, 'l', this.value)" --}}
                                                                />
                                                            </x-base.table.td>
                                                        </x-base.table.tr>

                                                        <x-base.table.tr>
                                                            <x-base.table.td class="whitespace-nowrap">
                                                                
                                                                TPS 002
                                                                
                                                            </x-base.table.td>
                                                            <x-base.table.td class="!px-2">
                                                                <x-base.form-input
                                                                    class="min-w-[6rem]"
                                                                    type="number"
                                                                    placeholder="..."
                                                                    id=""
                                                                    value="123"
                                                                    {{-- oninput="update({{ $pemetaan->id }}, 'l', this.value)" --}}
                                                                />
                                                            </x-base.table.td>
                                                            <x-base.table.td class="!px-2">
                                                                <x-base.form-input
                                                                    class="min-w-[6rem]"
                                                                    type="number"
                                                                    placeholder="..."
                                                                    id=""
                                                                    value="123"
                                                                    {{-- oninput="update({{ $pemetaan->id }}, 'l', this.value)" --}}
                                                                />
                                                            </x-base.table.td>
                                                        </x-base.table.tr>

                                                        <x-base.table.tr>
                                                            <x-base.table.td class="whitespace-nowrap">
                                                                
                                                                TPS 003
                                                                
                                                            </x-base.table.td>
                                                            <x-base.table.td class="!px-2">
                                                                <x-base.form-input
                                                                    class="min-w-[6rem]"
                                                                    type="number"
                                                                    placeholder="..."
                                                                    id=""
                                                                    value="123"
                                                                    {{-- oninput="update({{ $pemetaan->id }}, 'l', this.value)" --}}
                                                                />
                                                            </x-base.table.td>
                                                            <x-base.table.td class="!px-2">
                                                                <x-base.form-input
                                                                    class="min-w-[6rem]"
                                                                    type="number"
                                                                    placeholder="..."
                                                                    id=""
                                                                    value="123"
                                                                    {{-- oninput="update({{ $pemetaan->id }}, 'l', this.value)" --}}
                                                                />
                                                            </x-base.table.td>
                                                        </x-base.table.tr>
                                                    {{-- @endforeach --}}
                                                </x-base.table.tbody>
                                            </x-base.table>
                                            
                                        </div>
                                    </div>
                                </x-base.slideover.description>
                                <!-- END: Slide Over Body -->
                                <!-- BEGIN: Slide Over Footer -->
                                <x-base.slideover.footer>
                                    <x-base.button
                                        class="w-20 mr-1"
                                        data-tw-dismiss="modal"
                                        type="button"
                                        variant="outline-secondary"
                                    >
                                        Cancel
                                    </x-base.button>
                                    <x-base.button
                                        class="w-20"
                                        type="button"
                                        variant="primary"
                                    >
                                        Send
                                    </x-base.button>
                                </x-base.slideover.footer>
                            </x-base.slideover.panel>
                            <!-- END: Slide Over Footer -->
                        </x-base.slideover>
                        <!-- END: Slide Over Content -->
                    </x-base.preview>
                </div>
            </x-base.preview-component>
            <!-- END: List desa per kecamatan -->


    </div>
@endsection

@pushOnce('scripts')
    @vite('resources/js/pages/slideover.js')
@endPushOnce
