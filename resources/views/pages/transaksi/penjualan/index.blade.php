@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $storeSettings['store_name'] }} - Transaksi Penjualan</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium uppercase">Transaksi Penjualan</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center xl:flex-nowrap">
            <a href="{{ route('transaksi.penjualan.tambah') }}">
                <x-base.button
                    class="mr-2 shadow-md text-white"
                    variant="success"
                    type="button"
                >
                    TAMBAH
                </x-base.button>
            </a>
            <div class="mx-auto hidden text-slate-500 xl:block">
                @if (session('success'))
                    <div class="text-green-600">{{ session('success') }}</div>
                @endif
            </div>
            <div class="mt-3 flex w-full items-center xl:mt-0 xl:w-auto">
                <form action="{{ route('transaksi.penjualan') }}" method="GET" class="relative w-56 text-slate-500">
                    <x-base.form-input
                        class="!box w-56 pr-10"
                        type="text"
                        name="search"
                        placeholder="Cari..."
                        value="{{ $search ?? '' }}"
                    />
                    <button type="submit" class="absolute inset-y-0 right-0 my-auto mr-3">
                        <x-base.lucide class="h-4 w-4" icon="Search" />
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
                            Tanggal
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Pelanggan
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Jumlah Barang
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Total Harga
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Tindakan
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse ($data as $item)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ date('d/m/Y', strtotime($item->tgl_transaksi)) }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $item->pelanggan->nama }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $item->details->count() }} item ({{ $item->details->sum('jml_barang') }} pcs)
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                Rp {{ number_format($item->total, 0, ',', '.') }},-
                                @php
                                    $diskonItems = $item->details->whereNotNull('diskon_id')->count();
                                @endphp
                                @if($diskonItems > 0)
                                    <span class="ml-1 rounded bg-success/20 px-2 py-1 text-xs text-success">
                                        {{ $diskonItems }} item diskon
                                    </span>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('transaksi.penjualan.show', $item->id) }}" class="mr-3 flex items-center">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Eye" />
                                        Detail
                                    </a>
                                    <a href="{{ route('transaksi.penjualan.cetak', $item->id) }}" target="_blank" class="mr-3 flex items-center">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Printer" />
                                        Cetak
                                    </a>
                                    @if(auth()->user()->hasRole('admin'))
                                        <a href="{{ route('transaksi.penjualan.edit', $item->id) }}" class="mr-3 flex items-center text-warning">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Edit" />
                                            Edit
                                        </a>
                                        <a href="javascript:;" class="flex items-center text-danger" 
                                            onclick="if(confirm('Yakin ingin menghapus data ini?')) { 
                                                document.getElementById('delete-form-{{ $item->id }}').submit(); 
                                            }">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" />
                                            Hapus
                                            <form id="delete-form-{{ $item->id }}" action="{{ route('transaksi.penjualan.destroy', $item->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </a>
                                    @endif
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="5" class="text-center">Tidak ada data</x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
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

    <!-- BEGIN: Tambah Jenis Modal -->
    <x-base.preview-component class="intro-y">
        <div class="p-5">
            <x-base.preview>
                <!-- BEGIN: Modal Content -->
                <x-base.dialog id="tambah-barang-modal-preview">
                    <x-base.dialog.panel>
                        <form action="{{ route('barang.jenis.store') }}" method="POST">
                            @csrf
                            <x-base.dialog.title>
                                <h2 class="mr-auto text-base font-medium">
                                    Tambah Jenis Barang
                                </h2>
                            </x-base.dialog.title>
                       
                            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12 sm:col-span-12">
                                    <x-base.form-label for="modal-form-1">Jenis Barang</x-base.form-label>
                                    <x-base.form-input
                                        id="modal-form-1"
                                        type="text"
                                        name="jenis"
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
    <!-- END: Tambah Jenis Modal -->
    
    <!-- BEGIN: Edit Jenis Modal -->
    <x-base.dialog id="edit-barang-modal">
        <x-base.dialog.panel>
            <form id="edit-barang-form" method="POST">
                @csrf
                @method('PUT')
                <x-base.dialog.title>
                    <h2 class="mr-auto text-base font-medium">Edit Jenis Barang</h2>
                </x-base.dialog.title>

                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <x-base.form-label for="edit-modal-form-1">Jenis Barang</x-base.form-label>
                        <x-base.form-input
                            id="edit-modal-form-1"
                            type="text"
                            name="jenis"
                            placeholder="..."
                            value=""
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
    <!-- END: Edit Jenis Modal -->

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