@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Pengguna</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Data Pengguna</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <x-base.button
                class="mr-2 px-12 shadow-md"
                variant="primary"
                data-tw-toggle="modal"
                data-tw-target="#add-item-modal"
            >
                Tambah 
            </x-base.button>
            <div class="mx-auto hidden text-slate-500 md:block">
                
            </div>
            <div class="mt-2 w-auto ml-auto sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <div class=" w-35 text-slate-500">
                    Jumlah : 2.000
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y mt-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form
                class="sm:mr-auto xl:flex"
                id="tabulator-html-filter-form"
            >
                <div class="items-center sm:mr-4 sm:flex">
                    <x-base.form-select
                        class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full"
                        id="tabulator-html-filter-field"
                    >
                        <option value="nik">Level</option>
                        <option value="nama">Nama</option>
                        <option value="kecamatan">Kecamatan</option>
                        <option value="desa">Desa / Kelurahan</option>
                    </x-base.form-select>
                </div>
                <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                    <x-base.form-input
                        class="mt-2 sm:mt-0 sm:w-60 2xl:w-full"
                        type="text"
                        placeholder="Apa yang Anda cari ?"
                    />
                </div>
                <div class="mt-4 xl:mt-0">
                    <x-base.button
                        class="w-full sm:w-16"
                        id="tabulator-html-filter-go"
                        type="button"
                        variant="primary"
                    >
                        Cari
                    </x-base.button>
                    <x-base.button
                        class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16"
                        id="tabulator-html-filter-reset"
                        type="button"
                        variant="secondary"
                    >
                        Reset
                    </x-base.button>
                </div>
            </form>
            <div class="mt-5 flex sm:mt-0">
                {{-- <x-base.button
                    class="mr-2 w-1/2 sm:w-auto"
                    id="tabulator-print"
                    variant="outline-secondary"
                >
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="Printer"
                    /> Print
                </x-base.button> --}}
                {{-- <x-base.menu class="w-1/2 sm:w-auto">
                    <x-base.menu.button
                        class="w-full sm:w-auto"
                        as="x-base.button"
                        variant="outline-secondary"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="FileText"
                        /> Export
                        <x-base.lucide
                            class="ml-auto h-4 w-4 sm:ml-2"
                            icon="ChevronDown"
                        />
                    </x-base.menu.button>
                    <x-base.menu.items class="w-40">
                        <x-base.menu.item id="tabulator-export-csv">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="FileText"
                            /> Export CSV
                        </x-base.menu.item>
                        <x-base.menu.item id="tabulator-export-json">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="FileText"
                            /> Export
                            JSON
                        </x-base.menu.item>
                        <x-base.menu.item id="tabulator-export-xlsx">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="FileText"
                            /> Export
                            XLSX
                        </x-base.menu.item>
                        <x-base.menu.item id="tabulator-export-html">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="FileText"
                            /> Export
                            HTML
                        </x-base.menu.item>
                    </x-base.menu.items>
                </x-base.menu> --}}
            </div>
        </div>
    </div>

    <!-- BEGIN: Data List -->
    <div class="intro-y mt-6 col-span-12 overflow-auto lg:overflow-visible">
        <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
            <x-base.table.thead>
                <x-base.table.tr>
                    <x-base.table.th class="whitespace-nowrap border-b-0">
                        LEVEL
                    </x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0">
                        NAMA
                    </x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0">
                        NO. WA
                    </x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0">
                        KECAMATAN
                    </x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0">
                        DESA
                    </x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                        TPS
                    </x-base.table.th>
                    {{-- <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                        STATUS
                    </x-base.table.th> --}}
                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                        ACTIONS
                    </x-base.table.th>
                </x-base.table.tr>
            </x-base.table.thead>
            <x-base.table.tbody>
                @foreach (array_slice($fakers, 0, 9) as $faker)
                    <x-base.table.tr class="intro-x">
                        <x-base.table.td
                            class="box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                        >
                            Super Admin
                        </x-base.table.td>
                        <x-base.table.td
                            class="box w-30 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                        >
                            <p
                                class="whitespace-nowrap font-medium"
                            >
                                {{ $faker['users'][0]['name'] }}
                            </p>
                        </x-base.table.td>
                        <x-base.table.td
                            class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                        >
                            085123777700
                        </x-base.table.td>
                        <x-base.table.td
                            class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                        >
                            Kajen
                        </x-base.table.td>
                        <x-base.table.td
                            class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                        >
                            Tanjungsari
                        </x-base.table.td>
                        <x-base.table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                        >
                            001
                        </x-base.table.td>
                        {{-- <x-base.table.td
                            class="box w-40 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                        >
                            <div @class([
                                'flex items-center justify-center',
                                'text-success' => $faker['true_false'][0],
                                'text-danger' => !$faker['true_false'][0],
                            ])>
                                <x-base.lucide
                                    class="mr-2 h-4 w-4"
                                    icon="CheckSquare"
                                />
                                {{ $faker['true_false'][0] ? 'Active' : 'Inactive' }}
                            </div>
                        </x-base.table.td> --}}
                        <x-base.table.td @class([
                            'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                            'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                        ])>
                            <div class="flex items-center justify-center">
                                <a
                                    class="mr-3 flex items-center"
                                    href="#"
                                >
                                    <x-base.lucide
                                        class="mr-1 h-4 w-4"
                                        icon="CheckSquare"
                                    />
                                    Edit
                                </a>
                                <a
                                    class="flex items-center text-danger"
                                    data-tw-toggle="modal"
                                    data-tw-target="#delete-confirmation-modal"
                                    href="#"
                                >
                                    <x-base.lucide
                                        class="mr-1 h-4 w-4"
                                        icon="Trash"
                                    /> Delete
                                </a>
                            </div>
                        </x-base.table.td>
                    </x-base.table.tr>
                @endforeach
            </x-base.table.tbody>
        </x-base.table>
    </div>
    <!-- END: Data List -->

    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
        <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
            <x-base.pagination.link>
                <x-base.lucide
                    class="h-4 w-4"
                    icon="ChevronsLeft"
                />
            </x-base.pagination.link>
            <x-base.pagination.link>
                <x-base.lucide
                    class="h-4 w-4"
                    icon="ChevronLeft"
                />
            </x-base.pagination.link>
            <x-base.pagination.link>...</x-base.pagination.link>
            <x-base.pagination.link>1</x-base.pagination.link>
            <x-base.pagination.link active>2</x-base.pagination.link>
            <x-base.pagination.link>3</x-base.pagination.link>
            <x-base.pagination.link>...</x-base.pagination.link>
            <x-base.pagination.link>
                <x-base.lucide
                    class="h-4 w-4"
                    icon="ChevronRight"
                />
            </x-base.pagination.link>
            <x-base.pagination.link>
                <x-base.lucide
                    class="h-4 w-4"
                    icon="ChevronsRight"
                />
            </x-base.pagination.link>
        </x-base.pagination>
    </div>
    <!-- END: Pagination -->

    <!-- END: HTML Table Data -->

    <!-- BEGIN: Add Item Modal -->
    <x-base.dialog id="add-item-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">
                    Tambah Pendukung
                </h2>
            </x-base.dialog.title>
            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                <!-- BEGIN: Kecamatan -->
                <div class="col-span-12">
                    <x-base.form-label
                        class="form-label"
                        for="pos-form-4"
                    >
                        Kecamatan
                    </x-base.form-label>
                    <x-base.tom-select
                        class="w-full"
                        data-placeholder="Pilih kecamatan"
                    >
                        <option value="1">Leonardo DiCaprio</option>
                        <option value="2">Johnny Deep</option>
                        <option value="3">Robert Downey, Jr</option>
                        <option value="4">Samuel L. Jackson</option>
                        <option value="5">Morgan Freeman</option>
                    </x-base.tom-select>
                </div>
                <!-- END: Kecamatan -->
                <!-- BEGIN: Desa -->
                <div class="col-span-12">
                    <x-base.form-label
                        class="form-label"
                        for="pos-form-4"
                    >
                        Desa
                    </x-base.form-label>
                    <x-base.tom-select
                        class="w-full"
                        data-placeholder="Pilih desa"
                    >
                        <option value="1">Leonardo DiCaprio</option>
                        <option value="2">Johnny Deep</option>
                        <option value="3">Robert Downey, Jr</option>
                        <option value="4">Samuel L. Jackson</option>
                        <option value="5">Morgan Freeman</option>
                    </x-base.tom-select>
                </div>
                <!-- END: Desa -->
                <div class="col-span-12">
                    <x-base.form-label for="pos-form-5">Upload File Excel</x-base.form-label>
                    <x-base.preview>
                        <x-base.dropzone
                            class="dropzone"
                            data-single="true"
                            action="/file-upload"
                        >
                            <div class="text-lg font-medium">
                                Tarik file atau klik disini.
                            </div>
                            <div class="text-gray-600">
                                Pastikan file yang di upload adalah 
                                <span class="font-medium">File Excel</span> 
                            </div>
                        </x-base.dropzone>
                    </x-base.preview>
                </div>
            </x-base.dialog.description>
            <x-base.dialog.footer class="text-right">
                <x-base.button
                    class="mr-1 w-24"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Batal
                </x-base.button>
                <x-base.button
                    class="w-24"
                    type="button"
                    variant="primary"
                >
                    Simpan
                </x-base.button>
            </x-base.dialog.footer>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Add Item Modal -->

    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide
                    class="mx-auto mt-3 h-16 w-16 text-danger"
                    icon="XCircle"
                />
                <div class="mt-5 text-3xl">Are you sure?</div>
                <div class="mt-2 text-slate-500">
                    Do you really want to delete these records? <br />
                    This process cannot be undone.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <x-base.button
                    class="mr-1 w-24"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Cancel
                </x-base.button>
                <x-base.button
                    class="w-24"
                    type="button"
                    variant="danger"
                >
                    Delete
                </x-base.button>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->


@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/lucide.js')
    @vite('resources/js/vendors/xlsx.js')
@endPushOnce
