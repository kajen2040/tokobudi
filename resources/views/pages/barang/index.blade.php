@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Data Barang</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium uppercase">DATA BARANG</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center xl:flex-nowrap">
            <x-base.button
                class="mr-2 shadow-md text-white"
                variant="success"
                data-tw-toggle="modal"
                data-tw-target="#tambah-barang-modal-preview"
            >
                TAMBAH
            </x-base.button>
            <div class="mx-auto hidden text-slate-500 xl:block">
                Showing 1 to 10 of 10 entries
            </div>
            <div class="mt-3 flex w-full items-center xl:mt-0 xl:w-auto">
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input
                        class="!box w-56 pr-10"
                        type="text"
                        placeholder="Search..."
                    />
                    <x-base.lucide
                        class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4"
                        icon="Search"
                    />
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Nama
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Jenis
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Stok
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Satuan
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Tindakan
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach (array_slice($fakers, 0, 9) as $faker)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 !py-3.5 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                <div class="flex items-center">
                                    <div class="image-fit zoom-in h-9 w-9">
                                        <x-base.tippy
                                            class="rounded-lg border-white shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                            src="{{ Vite::asset($faker['images'][0]) }}"
                                            alt="Toko Budi"
                                            as="img"
                                        />
                                    </div>
                                    <div class="ml-4">
                                        Indomie Goreng
                                    </div>
                                </div>
                            </x-base.table.td>
                            <x-base.table.td
                                class="box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                Mie Instan
                            </x-base.table.td>
                            <x-base.table.td
                                class="box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                20
                            </x-base.table.td>
                            <x-base.table.td
                                class="box w-40 whitespace-nowrap rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                Bungkus
                            </x-base.table.td>
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
            <x-base.form-select class="!box mt-3 w-20 sm:mt-0">
                <option>10</option>
                <option>25</option>
                <option>35</option>
                <option>50</option>
            </x-base.form-select>
        </div>
        <!-- END: Pagination -->
    </div>

    <!-- BEGIN: Tambah Jenis Modal -->
    <x-base.preview-component class="intro-y">
        <div class="p-5">
            <x-base.preview>
                <!-- BEGIN: Modal Content -->
                <x-base.dialog id="tambah-barang-modal-preview">
                    <x-base.dialog.panel>
                        <x-base.dialog.title>
                            <h2 class="mr-auto text-base font-medium">
                                Tambah Barang
                            </h2>
                        </x-base.dialog.title>
                        <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12">
                                <x-base.form-label for="modal-form-1">Barang baru</x-base.form-label>
                                <x-base.form-input
                                    id="modal-form-1"
                                    type="text"
                                    placeholder="Contoh : Beras Rojolele"
                                />
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <x-base.form-label for="modal-form-6">Jenis</x-base.form-label>
                                <x-base.form-select id="modal-form-6">
                                    <option>Beras</option>
                                    <option>Mie Instan</option>
                                    <option>Minyak Goreng</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <x-base.form-label for="modal-form-6">Satuan</x-base.form-label>
                                <x-base.form-select id="modal-form-6">
                                    <option>Kg</option>
                                    <option>Lt</option>
                                    <option>Bungkus</option>
                                    <option>Lusin</option>
                                </x-base.form-select>
                            </div>
                        </x-base.dialog.description>
                        <x-base.dialog.footer>
                            <x-base.button
                                class="mr-1 w-20"
                                data-tw-dismiss="modal"
                                type="button"
                                variant="outline-secondary"
                            >
                                Batal
                            </x-base.button>
                            <x-base.button
                                class="w-20 text-white"
                                type="button"
                                variant="success"
                            >
                                Simpan
                            </x-base.button>
                        </x-base.dialog.footer>
                    </x-base.dialog.panel>
                </x-base.dialog>
                <!-- END: Modal Content -->
            </x-base.preview>
        </div>
    </x-base.preview-component>
    <!-- END: Tambah Jenis Modal -->
    <!-- BEGIN: Tambah Jenis Modal -->
    <x-base.preview-component class="intro-y">
        <div class="p-5">
            <x-base.preview>
                <!-- BEGIN: Modal Content -->
                <x-base.dialog id="header-footer-modal-preview">
                    <x-base.dialog.panel>
                        <x-base.dialog.title>
                            <h2 class="mr-auto text-base font-medium">
                                Tambah Jenis
                            </h2>
                        </x-base.dialog.title>
                        <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12">
                                {{-- <h2 class="intro-y mt-6 text-lg font-medium">Data jenis</h2> --}}
                                <x-base.table class="-mt-1 border-separate border-spacing-y-[6px]">
                                    <x-base.table.thead>
                                        <x-base.table.tr>
                                            <x-base.table.th class="whitespace-nowrap border-b-0">
                                                Nama
                                            </x-base.table.th>
                                            <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                                Tindakan
                                            </x-base.table.th>
                                        </x-base.table.tr>
                                    </x-base.table.thead>
                                    <x-base.table.tbody>
                                        @foreach (array_slice($fakers, 0, 3) as $faker)
                                            <x-base.table.tr class="intro-x">
                                                <x-base.table.td
                                                    class="box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 !py-3.5 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                                                >
                                                    <div class="flex items-center">
                                                        <div class="">
                                                            <a
                                                                class="whitespace-nowrap "
                                                                href=""
                                                            >
                                                                {{ $faker['users'][0]['name'] }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </x-base.table.td>
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
                            <div class="col-span-12 sm:col-span-12">
                                <x-base.form-label for="modal-form-1">Jenis baru</x-base.form-label>
                                <x-base.form-input
                                    id="modal-form-1"
                                    type="text"
                                    placeholder="Karet"
                                />
                            </div>
                        </x-base.dialog.description>
                        <x-base.dialog.footer>
                            <x-base.button
                                class="mr-1 w-20"
                                data-tw-dismiss="modal"
                                type="button"
                                variant="outline-secondary"
                            >
                                Batal
                            </x-base.button>
                            <x-base.button
                                class="w-20"
                                type="button"
                                variant="primary"
                            >
                                Simpan
                            </x-base.button>
                        </x-base.dialog.footer>
                    </x-base.dialog.panel>
                </x-base.dialog>
                <!-- END: Modal Content -->
            </x-base.preview>
        </div>
    </x-base.preview-component>
    <!-- END: Tambah Jenis Modal -->
    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide
                    class="mx-auto mt-3 h-16 w-16 text-danger"
                    icon="XCircle"
                />
                <div class="mt-5 text-3xl">Apakah Anda yakin?</div>
                <div class="mt-2 text-slate-500">
                    Data akan dihapus secara permanen. <br />
                    Apabila sudah dihapus tidak dapat dikembalikan lagi.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
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
                    variant="danger"
                >
                    Hapus
                </x-base.button>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->
@endsection
