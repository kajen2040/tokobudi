@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Detail Transaksi Penjualan</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium uppercase">Detail Transaksi Penjualan</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center xl:flex-nowrap">
            <a href="{{ route('transaksi.penjualan') }}">
                <x-base.button
                    class="mr-2 shadow-md"
                    variant="secondary"
                    type="button"
                >
                    <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" />
                    KEMBALI
                </x-base.button>
            </a>
            <a href="{{ route('transaksi.penjualan.cetak', $transaksi->id) }}" target="_blank">
                <x-base.button
                    class="mr-2 shadow-md"
                    variant="primary"
                    type="button"
                >
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Printer" />
                    CETAK
                </x-base.button>
            </a>
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('transaksi.penjualan.edit', $transaksi->id) }}">
                    <x-base.button
                        class="mr-2 shadow-md"
                        variant="warning"
                        type="button"
                    >
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" />
                        EDIT
                    </x-base.button>
                </a>
                <form action="{{ route('transaksi.penjualan.destroy', $transaksi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <x-base.button
                        class="mr-2 shadow-md"
                        variant="danger"
                        type="submit"
                    >
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Trash" />
                        HAPUS
                    </x-base.button>
                </form>
            @endif
        </div>
        
        <!-- BEGIN: Data Transaksi -->
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <div class="box p-5">
                <h3 class="text-lg font-medium">Data Transaksi</h3>
                <div class="mt-5 grid grid-cols-12 gap-4">
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <div class="mb-2 font-medium">Nomor Transaksi</div>
                        <div>{{ $transaksi->id }}</div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <div class="mb-2 font-medium">Tanggal Transaksi</div>
                        <div>{{ date('d/m/Y', strtotime($transaksi->tgl_transaksi)) }}</div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <div class="mb-2 font-medium">Pelanggan</div>
                        <div>{{ $transaksi->pelanggan->nama }}</div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <div class="mb-2 font-medium">Total Transaksi</div>
                        <div class="font-medium text-primary">Rp {{ number_format($transaksi->total, 0, ',', '.') }},-</div>
                    </div>
                    <div class="col-span-12">
                        <div class="mb-2 font-medium">Keterangan</div>
                        <div>{{ $transaksi->keterangan }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- BEGIN: Data Barang -->
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <div class="box p-5">
                <h3 class="text-lg font-medium">Daftar Barang</h3>
                <div class="overflow-x-auto">
                    <x-base.table class="mt-5 border-separate border-spacing-y-[10px]">
                        <x-base.table.thead>
                            <x-base.table.tr>
                                <x-base.table.th class="whitespace-nowrap border-b-0">No</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">Nama Barang</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">Jumlah</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">Satuan</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">Jenis</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">Harga Satuan</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">Diskon</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">Subtotal</x-base.table.th>
                            </x-base.table.tr>
                        </x-base.table.thead>
                        <x-base.table.tbody>
                            @forelse($transaksi->details as $index => $detail)
                                <x-base.table.tr class="intro-x">
                                    <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                        {{ $index + 1 }}
                                    </x-base.table.td>
                                    <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                        {{ $detail->barang->nama }}
                                    </x-base.table.td>
                                    <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                        {{ $detail->jml_barang }}
                                    </x-base.table.td>
                                    <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                        {{ $detail->barangDetail->satuan->satuan ?? '-' }}
                                    </x-base.table.td>
                                    <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                        {{ $detail->barangDetail->jenis->jenis ?? '-' }}
                                    </x-base.table.td>
                                    <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                        Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }},-
                                    </x-base.table.td>
                                    <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                        @if($detail->diskon)
                                            <span class="rounded bg-success/20 px-2 py-1 text-success">
                                                {{ $detail->diskon->nama . ' (' . $detail->diskon->persen . '%)' }}
                                            </span>
                                        @else
                                            <span class="text-slate-500">Tidak ada</span>
                                        @endif
                                    </x-base.table.td>
                                    <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }},-
                                    </x-base.table.td>
                                </x-base.table.tr>
                            @empty
                                <x-base.table.tr>
                                    <x-base.table.td colspan="8" class="text-center">Tidak ada data barang</x-base.table.td>
                                </x-base.table.tr>
                            @endforelse
                            <x-base.table.tr class="bg-primary/10">
                                <x-base.table.td colspan="7" class="font-medium text-right">Total</x-base.table.td>
                                <x-base.table.td class="font-medium">Rp {{ number_format($transaksi->total, 0, ',', '.') }},-</x-base.table.td>
                            </x-base.table.tr>
                        </x-base.table.tbody>
                    </x-base.table>
                </div>
            </div>
        </div>
        <!-- END: Data Barang -->
    </div>
@endsection 