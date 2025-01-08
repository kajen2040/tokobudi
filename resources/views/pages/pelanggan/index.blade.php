@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Data Pelanggan</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium uppercase">Data Pelanggan</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center xl:flex-nowrap">
            <x-base.button
                class="mr-2 shadow-md text-white"
                variant="success"
                data-tw-toggle="modal"
                data-tw-target="#tambah-pelanggan-modal-preview"
            >
                TAMBAH
            </x-base.button>
            <div class="mx-auto hidden text-slate-500 xl:block">
                @if (session('success'))
                    <div class="text-green-600">{{ session('success') }}</div>
                @endif
            </div>
            <div class="mt-3 flex w-full items-center xl:mt-0 xl:w-auto">
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input
                        class="!box w-56 pr-10"
                        type="text"
                        placeholder="Cari..."
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
                            No. HP
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Alamat
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Tindakan
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($data as $pelanggan)
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
                                            {{ $pelanggan->nama }}
                                        </a>
                                    </div>
                                </div>
                            </x-base.table.td>
                            <x-base.table.td
                                class="box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $pelanggan->no_hp }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $pelanggan->alamat }}
                            </x-base.table.td>
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">
                                    <a
                                        class="mr-3 flex items-center"
                                        href="#"
                                        data-tw-toggle="modal"
                                        data-tw-target="#edit-pelanggan-modal"
                                        onclick="openEditModal('{{ route('pelanggan.update', $pelanggan->id) }}', '{{ $pelanggan->nama }}', '{{ $pelanggan->no_hp }}', '{{ $pelanggan->alamat }}')"
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
                                        onclick="openDeleteModal('{{ route('pelanggan.destroy', $pelanggan->id) }}')"
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
    </div>

    <!-- BEGIN: Tambah Pelanggan Modal -->
    <x-base.preview-component class="intro-y">
        <div class="p-5">
            <x-base.preview>
                <!-- BEGIN: Modal Content -->
                <x-base.dialog id="tambah-pelanggan-modal-preview">
                    <x-base.dialog.panel>
                        <form action="{{ route('pelanggan.store') }}" method="POST">
                            @csrf
                            <x-base.dialog.title>
                                <h2 class="mr-auto text-base font-medium">
                                    Tambah Pelanggan Barang
                                </h2>
                            </x-base.dialog.title>
                       
                            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12 sm:col-span-12">
                                    <x-base.form-label for="modal-form-1">Pelanggan Barang</x-base.form-label>
                                    <x-base.form-input
                                        id="modal-form-1"
                                        type="text"
                                        name="nama"
                                        placeholder="..."
                                    />
                                </div>

                            <div class="col-span-12 sm:col-span-12">
                                <x-base.form-label for="modal-form-6">No. HP</x-base.form-label>
                                <x-base.form-input
                                    id="modal-form-1"
                                    type="text"
                                    name="no_hp"
                                    placeholder="..."
                                />
                            </div>
                            <div class="col-span-12 sm:col-span-12">
                                <x-base.form-label for="modal-form-6">Alamat</x-base.form-label>
                                <x-base.form-input
                                    id="modal-form-1"
                                    type="text"
                                    name="alamat"
                                    placeholder="..."
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
                                    type="submit"
                                    variant="primary"
                                >
                                    Simpan
                                </x-base.button>
                            </x-base.dialog.footer>
                        </form>
                    </x-base.dialog.panel>
                </x-base.dialog>
                <!-- END: Modal Content -->
            </x-base.preview>
        </div>
    </x-base.preview-component>
    <!-- END: Tambah Pelanggan Modal -->
    
    <!-- BEGIN: Edit Pelanggan Modal -->
    <x-base.preview-component class="intro-y">
        <div class="p-5">
            <x-base.preview>
                <!-- BEGIN: Modal Content -->
                <x-base.dialog id="edit-pelanggan-modal">
                    <x-base.dialog.panel>
                        <form id="edit-pelanggan-form" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <x-base.dialog.title>
                                <h2 class="mr-auto text-base font-medium">
                                    Edit Pelanggan Barang
                                </h2>
                            </x-base.dialog.title>

                            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12 sm:col-span-12">
                                    <x-base.form-label for="edit-nama">Pelanggan Barang</x-base.form-label>
                                    <x-base.form-input
                                        id="edit-nama"
                                        type="text"
                                        name="nama"
                                        placeholder="..."
                                    />
                                </div>
                                <div class="col-span-12 sm:col-span-12">
                                    <x-base.form-label for="edit-persen">No. HP</x-base.form-label>
                                    <x-base.form-input
                                        id="edit-no_hp"
                                        type="text"
                                        name="no_hp"
                                        placeholder="..."
                                    />
                                </div>
                                <div class="col-span-12 sm:col-span-12">
                                    <x-base.form-label for="edit-alamat">Alamat</x-base.form-label>
                                    <x-base.form-input
                                        id="edit-alamat"
                                        type="text"
                                        name="alamat"
                                        placeholder="..."
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
                                    type="submit"
                                    variant="primary"
                                >
                                    Simpan
                                </x-base.button>
                            </x-base.dialog.footer>
                        </form>
                    </x-base.dialog.panel>
                </x-base.dialog>
                <!-- END: Modal Content -->
            </x-base.preview>
        </div>
    </x-base.preview-component>
    <!-- END: Edit Pelanggan Modal -->

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
                    Data akan dihapus secara permanen dan <br />
                    tidak bisa dikembalikan lagi.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <form id="delete-pelanggan-form" method="POST">
                    @csrf
                    @method('DELETE')
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
                        type="submit"
                        variant="danger"
                    >
                        Delete
                    </x-base.button>
                </form>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->
@endsection

<script>
    function openEditModal(actionUrl, nama, no_hp, alamat) {
        // Set form action URL
        document.getElementById('edit-pelanggan-form').action = actionUrl;

        // Populate form fields
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-no_hp').value = no_hp;
        document.getElementById('edit-alamat').value = alamat;
    }

    function openDeleteModal(url) {
        const deleteForm = document.getElementById('delete-pelanggan-form');
        deleteForm.action = url;
    }
</script>