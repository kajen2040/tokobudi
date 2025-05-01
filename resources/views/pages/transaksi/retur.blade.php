@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $storeSettings['store_name'] }} - Transaksi Retur Penjualan</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium uppercase">Transaksi Retur Penjualan</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center xl:flex-nowrap">
            <x-base.button
                class="mr-2 shadow-md text-white"
                variant="success"
                data-tw-toggle="modal"
                data-tw-target="#tambah-retur-modal"
            >
                TAMBAH
            </x-base.button>
            <div class="mx-auto hidden text-slate-500 xl:block">
                @if (session('success'))
                    <div class="text-green-600">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="text-red-600">{{ session('error') }}</div>
                @endif
            </div>
            <div class="mt-3 flex w-full items-center xl:mt-0 xl:w-auto">
                <form action="{{ route('transaksi.retur') }}" method="GET" class="relative w-56 text-slate-500">
                    <x-base.form-input
                        class="!box w-56 pr-10"
                        type="text"
                        name="search"
                        placeholder="Cari..."
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
                            Tanggal
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Pelanggan
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Barang
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Jumlah
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Keterangan
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Tindakan
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($data as $retur)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $retur->tgl_transaksi->format('d/m/Y') }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $retur->transaksiPenjualanDetail->transaksiPenjualan->pelanggan->nama }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $retur->transaksiPenjualanDetail->barang->nama }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $retur->jml_barang }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $retur->keterangan }}
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
                                        data-tw-target="#edit-retur-modal-{{ $retur->id }}"
                                    >
                                        <x-base.lucide
                                            class="mr-1 h-4 w-4"
                                            icon="CheckSquare"
                                        />
                                        Edit
                                    </a>
                                    <a
                                        class="flex items-center text-danger"
                                        href="#"
                                        data-tw-toggle="modal"
                                        data-tw-target="#delete-retur-modal-{{ $retur->id }}"
                                    >
                                        <x-base.lucide
                                            class="mr-1 h-4 w-4"
                                            icon="Trash"
                                        />
                                        Hapus
                                    </a>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>

                        <!-- BEGIN: Edit Retur Modal -->
                        <x-base.dialog id="edit-retur-modal-{{ $retur->id }}">
                            <x-base.dialog.panel>
                                <form action="{{ route('transaksi.retur.update', $retur->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <x-base.dialog.title>
                                        <h2 class="mr-auto text-base font-medium">
                                            Edit Retur Penjualan
                                        </h2>
                                    </x-base.dialog.title>
                               
                                    <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                                        <div class="col-span-12">
                                            <x-base.form-label for="edit-transaksi-detail-{{ $retur->id }}">Transaksi Penjualan</x-base.form-label>
                                            <select name="transaksi_penjualan_detail_id" id="edit-transaksi-detail-{{ $retur->id }}" class="form-select w-full">
                                                <option value="">Pilih Transaksi Penjualan</option>
                                                @foreach($penjualanDetails as $detail)
                                                    <option value="{{ $detail->id }}" {{ $retur->transaksi_penjualan_detail_id == $detail->id ? 'selected' : '' }}>
                                                        {{ $detail->transaksiPenjualan->pelanggan->nama }} - {{ $detail->barang->nama }} ({{ $detail->jml_barang }} item) - {{ \Carbon\Carbon::parse($detail->transaksiPenjualan->tgl_transaksi)->format('d/m/Y') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-12">
                                            <x-base.form-label for="edit-jml_barang-{{ $retur->id }}">Jumlah Barang</x-base.form-label>
                                            <x-base.form-input
                                                id="edit-jml_barang-{{ $retur->id }}"
                                                type="number"
                                                name="jml_barang"
                                                placeholder="Masukkan jumlah barang"
                                                min="1"
                                                value="{{ $retur->jml_barang }}"
                                            />
                                        </div>
                                        <div class="col-span-12">
                                            <x-base.form-label for="edit-keterangan-{{ $retur->id }}">Keterangan</x-base.form-label>
                                            <x-base.form-textarea
                                                id="edit-keterangan-{{ $retur->id }}"
                                                name="keterangan"
                                                placeholder="Masukkan keterangan retur"
                                            >{{ $retur->keterangan }}</x-base.form-textarea>
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
                        <!-- END: Edit Retur Modal -->

                        <!-- BEGIN: Delete Confirmation Modal -->
                        <x-base.dialog id="delete-retur-modal-{{ $retur->id }}">
                            <x-base.dialog.panel>
                                <div class="p-5 text-center">
                                    <x-base.lucide
                                        class="mx-auto mt-3 h-16 w-16 text-danger"
                                        icon="XCircle"
                                    />
                                    <div class="mt-5 text-3xl">Apakah Anda yakin?</div>
                                    <div class="mt-2 text-slate-500">
                                        Data retur akan dihapus secara permanen dan <br />
                                        tidak bisa dikembalikan lagi.
                                    </div>
                                </div>
                                <div class="px-5 pb-8 text-center">
                                    <form action="{{ route('transaksi.retur.destroy', $retur->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
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
                                            type="submit"
                                            variant="danger"
                                        >
                                            Hapus
                                        </x-base.button>
                                    </form>
                                </div>
                            </x-base.dialog.panel>
                        </x-base.dialog>
                        <!-- END: Delete Confirmation Modal -->
                    @endforeach
                </x-base.table.tbody>
            </x-base.table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
            {{ $data->links() }}
        </div>
        <!-- END: Pagination -->
    </div>

    <!-- BEGIN: Tambah Retur Modal -->
    <x-base.dialog id="tambah-retur-modal">
        <x-base.dialog.panel>
            <form action="{{ route('transaksi.retur.store') }}" method="POST">
                @csrf
                <x-base.dialog.title>
                    <h2 class="mr-auto text-base font-medium">
                        Tambah Retur Penjualan
                    </h2>
                </x-base.dialog.title>
           
                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <x-base.form-label for="transaksi-detail">Transaksi Penjualan</x-base.form-label>
                        <select name="transaksi_penjualan_detail_id" id="transaksi-detail" class="form-select w-full">
                            <option value="">Pilih Transaksi Penjualan</option>
                            @foreach($penjualanDetails as $detail)
                                <option value="{{ $detail->id }}">
                                    {{ $detail->transaksiPenjualan->pelanggan->nama }} - {{ $detail->barang->nama }} ({{ $detail->jml_barang }} item) - {{ \Carbon\Carbon::parse($detail->transaksiPenjualan->tgl_transaksi)->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="jml_barang">Jumlah Barang</x-base.form-label>
                        <x-base.form-input
                            id="jml_barang"
                            type="number"
                            name="jml_barang"
                            placeholder="Masukkan jumlah barang"
                            min="1"
                        />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="keterangan">Keterangan</x-base.form-label>
                        <x-base.form-textarea
                            id="keterangan"
                            name="keterangan"
                            placeholder="Masukkan keterangan retur"
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
    <!-- END: Tambah Retur Modal -->
@endsection