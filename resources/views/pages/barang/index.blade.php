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
                @if (session('success'))
                    <div class="text-green-600">{{ session('success') }}</div>
                @endif
            </div>
            <div class="mt-3 flex w-full items-center xl:mt-0 xl:w-auto">
                <form action="{{ route('barang.index') }}" method="GET" class="relative w-56 text-slate-500">
                    <x-base.form-input
                        class="!box w-56 pr-10"
                        type="text"
                        name="search"
                        placeholder="Search..."
                        value="{{ $search ?? '' }}"
                    />
                    <button type="submit" class="absolute inset-y-0 right-0 my-auto mr-3">
                        <x-base.lucide
                            class="h-4 w-4"
                            icon="Search"
                        />
                    </button>
                </form>
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
                            Stok
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Jenis
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
                    @foreach ($data as $barang)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 !py-3.5 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                <div class="flex items-center">
                                    <div class="image-fit zoom-in h-9 w-9">
                                        <img
                                            class="rounded-lg border-white shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                            src="{{ asset('storage/'. $barang->foto) }}"
                                            alt="Toko Budi"
                                            as="img"
                                        />
                                    </div>
                                    <div class="ml-4">
                                        {{ $barang->nama }}
                                    </div>
                                </div>
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $barang->stok }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $barang->detail->jenis->jenis }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $barang->detail->satuan->satuan }}
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
                                        onclick="openDeleteModal('{{ route('barang.destroy', $barang->id ) }}')"
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
                @if ($data->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $data->url(1) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                    <x-base.pagination.link href="{{ $data->previousPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @endif

                @php
                    $start = max(1, $data->currentPage() - 2);
                    $end = min($start + 4, $data->lastPage());
                    $start = max(1, $end - 4);
                @endphp

                @if ($start > 1)
                    <x-base.pagination.link>...</x-base.pagination.link>
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    <x-base.pagination.link href="{{ $data->url($i) }}" :active="$i == $data->currentPage()">
                        {{ $i }}
                    </x-base.pagination.link>
                @endfor

                @if ($end < $data->lastPage())
                    <x-base.pagination.link>...</x-base.pagination.link>
                @endif

                @if ($data->hasMorePages())
                    <x-base.pagination.link href="{{ $data->nextPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                    <x-base.pagination.link href="{{ $data->url($data->lastPage()) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @endif
            </x-base.pagination>
            <div class="text-sm text-slate-500 ml-5">
                Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() }} entries
            </div>
        </div>
        <!-- END: Pagination -->
    </div>

    
    <!-- BEGIN: Tambah Barang Modal -->
    <x-base.preview-component class="intro-y">
        <div class="p-5">
            <x-base.preview>
                <!-- BEGIN: Modal Content -->
                <x-base.dialog id="tambah-barang-modal-preview">
                    <x-base.dialog.panel>
                        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <x-base.dialog.title>
                                <h2 class="mr-auto text-base font-medium">
                                    Tambah Barang
                                </h2>
                            </x-base.dialog.title>
                            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12 sm:col-span-12">
                                    <x-base.form-label for="barang-nama">Nama Barang</x-base.form-label>
                                    <x-base.form-input
                                        id="barang-nama"
                                        type="text"
                                        name="nama"
                                        placeholder="Contoh: Indomie Goreng Ayam"
                                    />
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <x-base.form-label for="barang-jenis">Jenis</x-base.form-label>
                                    <x-base.form-select id="barang-jenis" name="jenis">
                                        @foreach ($jenis as $item)
                                            <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <x-base.form-label for="barang-satuan">Satuan</x-base.form-label>
                                    <x-base.form-select id="barang-satuan" name="satuan">
                                        @foreach ($satuan as $item)
                                            <option value="{{ $item->id }}"><p class="text-gray-600">{{ $item->satuan }}</p></option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <x-base.form-label for="barang-harga-beli">Harga Beli</x-base.form-label>
                                    <x-base.form-input
                                        id="barang-harga-beli"
                                        type="number"
                                        name="harga_beli"
                                        placeholder="Contoh: 50000"
                                    />
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <x-base.form-label for="barang-harga-jual">Harga Jual</x-base.form-label>
                                    <x-base.form-input
                                        id="barang-harga-jual"
                                        type="number"
                                        name="harga_jual"
                                        placeholder="Contoh: 75000"
                                    />
                                </div>
                                <div class="col-span-12 sm:col-span-12">
                                    <x-base.form-label for="barang-foto">Foto Barang</x-base.form-label>
                                    <x-base.form-input
                                        id="barang-foto"
                                        type="file"
                                        name="foto"
                                    />
                                    <x-base.form-input
                                        id="barang-stok"
                                        type="hidden"
                                        name="stok"
                                    />
                                    <x-base.form-input
                                        id="barang-status"
                                        type="hidden"
                                        name="status"
                                    />
                                    <x-base.form-input
                                        id="barang-barcode"
                                        type="hidden"
                                        name="barcode"
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
                                    class="w-20 text-white"
                                    type="submit"
                                    variant="success"
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
    <!-- END: Tambah Barang Modal -->

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
                <form id="delete-barang-form" method="POST">
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
    function openEditModal(url, jenis) {
        document.getElementById('edit-barang-form').action = url;
        document.getElementById('edit-modal-form-1').value = jenis;
    }

    function openDeleteModal(url) {
        const deleteForm = document.getElementById('delete-barang-form');
        deleteForm.action = url;
    }
</script>
