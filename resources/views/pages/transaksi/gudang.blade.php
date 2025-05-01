@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $storeSettings['store_name'] }} - Transaksi Gudang</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium uppercase">Transaksi Gudang</h2>
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
                <form action="{{ route('transaksi.gudang') }}" method="GET" class="relative w-56 text-slate-500">
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
                            Suplier
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Barang
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Jumlah
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Harga Beli
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Keterangan
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            User
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Tindakan
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($data as $transaksi)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $transaksi->tgl_transaksi->format('d/m/Y') }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $transaksi->suplier->nama }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $transaksi->barang->nama }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $transaksi->jml_barang }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                Rp {{ number_format($transaksi->harga_beli, 0, ',', '.') }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $transaksi->keterangan }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $transaksi->user->name }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                <div class="flex items-center justify-center">
                                    <a
                                        class="mr-3 flex items-center"
                                        href="#"
                                        data-tw-toggle="modal"
                                        data-tw-target="#edit-transaksi-modal"
                                        onclick="openEditModal('{{ route('transaksi.gudang.update', $transaksi->id) }}', {{ json_encode($transaksi) }})"
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
                                        onclick="openDeleteModal('{{ route('transaksi.gudang.destroy', $transaksi->id) }}')"
                                        href="#"
                                    >
                                        <x-base.lucide
                                            class="mr-1 h-4 w-4"
                                            icon="Trash2"
                                        />
                                        Hapus
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

    <!-- BEGIN: Tambah Transaksi Modal -->
    <x-base.dialog id="tambah-barang-modal-preview">
        <x-base.dialog.panel>
            <form action="{{ route('transaksi.gudang.store') }}" method="POST" enctype="multipart/form-data" id="transaksiForm">
                @csrf
                <x-base.dialog.title>
                    <h2 class="mr-auto text-base font-medium">
                        <i class="fas fa-plus-circle mr-2 text-success"></i>Tambah Transaksi Gudang
                    </h2>
                </x-base.dialog.title>
                <x-base.dialog.description class="space-y-4">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <x-base.form-label for="tgl_transaksi">Tanggal Transaksi</x-base.form-label>
                            <div class="relative">
                                <x-base.form-input
                                    id="tgl_transaksi"
                                    type="date"
                                    name="tgl_transaksi"
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full pl-2"
                                    required
                                />
                                <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="suplier">Suplier</x-base.form-label>
                            <div class="relative">
                                <x-base.form-select id="suplier" name="suplier_id" class="w-full pl-2" required>
                                    <option value="">Pilih Suplier</option>
                                    @foreach ($suplier as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </x-base.form-select>
                                <i class="fas fa-truck absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="barang">Nama Barang</x-base.form-label>
                            <div class="relative">
                                <x-base.form-select id="barang" name="barang_id" class="w-full pl-2" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id }}" data-stok="{{ $item->stok }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                                    @endforeach
                                </x-base.form-select>
                                <i class="fas fa-box absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="jml_barang">Jumlah Barang</x-base.form-label>
                            <div class="relative">
                                <x-base.form-input
                                    id="jml_barang"
                                    type="number"
                                    name="jml_barang"
                                    min="1"
                                    class="w-full pl-2"
                                    required
                                />
                                <i class="fas fa-cubes absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <small class="text-gray-500 mt-1 block">Stok tersedia: <span id="stok-tersedia" class="font-semibold">-</span></small>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="harga_beli">Harga Beli</x-base.form-label>
                            <div class="relative">
                                <x-base.form-input
                                    id="harga_beli"
                                    type="number"
                                    name="harga_beli"
                                    min="0"
                                    class="w-full pl-2"
                                    required
                                />
                                <i class="fas fa-money-bill absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="keterangan">Keterangan</x-base.form-label>
                            <div class="relative">
                                <x-base.form-textarea
                                    id="keterangan"
                                    name="keterangan"
                                    class="w-full pl-2"
                                    rows="3"
                                    placeholder="Masukkan keterangan transaksi (opsional)"
                                />
                                <i class="fas fa-comment absolute left-3 top-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </x-base.dialog.description>
                <x-base.dialog.footer class="flex justify-end space-x-2">
                    <x-base.button
                        class="w-24"
                        data-tw-dismiss="modal"
                        type="button"
                        variant="outline-secondary"
                    >
                        <i class="fas fa-times mr-2"></i>Batal
                    </x-base.button>
                    <x-base.button
                        class="w-24 text-white"
                        type="submit"
                        variant="success"
                    >
                        <i class="fas fa-save mr-2"></i>Simpan
                    </x-base.button>
                </x-base.dialog.footer>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Tambah Transaksi Modal -->
    
    <!-- BEGIN: Edit Transaksi Modal -->
    <x-base.dialog id="edit-transaksi-modal">
        <x-base.dialog.panel>
            <form id="edit-transaksi-form" method="POST" action="{{ route('transaksi.gudang.update', 0) }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="original-jml" name="original_jml_barang" value="0">

                <x-base.dialog.title>
                    <h2 class="mr-auto text-base font-medium">
                        <i class="fas fa-edit mr-2 text-warning"></i>Edit Transaksi Gudang
                    </h2>
                </x-base.dialog.title>
                <x-base.dialog.description class="space-y-4">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <x-base.form-label for="edit-tgl_transaksi">Tanggal Transaksi</x-base.form-label>
                            <div class="relative">
                                <x-base.form-input
                                    id="edit-tgl_transaksi"
                                    type="date"
                                    name="tgl_transaksi"
                                    class="w-full pl-2"
                                    required
                                />
                                <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="edit-suplier">Suplier</x-base.form-label>
                            <div class="relative">
                                <x-base.form-select id="edit-suplier" name="suplier_id" class="w-full pl-2" required>
                                    <option value="">Pilih Suplier</option>
                                    @foreach ($suplier as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </x-base.form-select>
                                <i class="fas fa-truck absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="edit-barang">Nama Barang</x-base.form-label>
                            <div class="relative">
                                <x-base.form-select id="edit-barang" name="barang_id" class="w-full pl-2" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id }}" data-stok="{{ $item->stok }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                                    @endforeach
                                </x-base.form-select>
                                <i class="fas fa-box absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="edit-jml_barang">Jumlah Barang</x-base.form-label>
                            <div class="relative">
                                <x-base.form-input
                                    id="edit-jml_barang"
                                    type="number"
                                    name="jml_barang"
                                    min="1"
                                    class="w-full pl-2"
                                    required
                                />
                                <i class="fas fa-cubes absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <small class="text-gray-500 mt-1 block">Stok tersedia: <span id="edit-stok-tersedia" class="font-semibold">-</span></small>
                                <div id="sales-warning" class="mt-2" style="display: none;"></div>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="edit-harga_beli">Harga Beli</x-base.form-label>
                            <div class="relative">
                                <x-base.form-input
                                    id="edit-harga_beli"
                                    type="number"
                                    name="harga_beli"
                                    min="0"
                                    class="w-full pl-2"
                                    required
                                />
                                <i class="fas fa-money-bill absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <x-base.form-label for="edit-keterangan">Keterangan</x-base.form-label>
                            <div class="relative">
                                <x-base.form-textarea
                                    id="edit-keterangan"
                                    name="keterangan"
                                    class="w-full pl-2"
                                    rows="3"
                                    placeholder="Masukkan keterangan transaksi (opsional)"
                                />
                                <i class="fas fa-comment absolute left-3 top-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </x-base.dialog.description>
                <x-base.dialog.footer class="flex justify-end space-x-2">
                    <x-base.button
                        class="w-24"
                        data-tw-dismiss="modal"
                        type="button"
                        variant="outline-secondary"
                    >
                        <i class="fas fa-times mr-2"></i>Batal
                    </x-base.button>
                    <x-base.button
                        class="w-24 text-white"
                        type="submit"
                        variant="warning"
                    >
                        <i class="fas fa-save mr-2"></i>Update
                    </x-base.button>
                </x-base.dialog.footer>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Edit Transaksi Modal -->

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
    function openEditModal(url, transaksi) {
        document.getElementById('edit-transaksi-form').action = url;
        document.getElementById('edit-tgl_transaksi').value = transaksi.tgl_transaksi;
        document.getElementById('edit-suplier').value = transaksi.suplier_id;
        document.getElementById('edit-barang').value = transaksi.barang_id;
        document.getElementById('edit-jml_barang').value = transaksi.jml_barang;
        document.getElementById('edit-harga_beli').value = transaksi.harga_beli;
        document.getElementById('edit-keterangan').value = transaksi.keterangan;
    }

    function openDeleteModal(url) {
        document.getElementById('delete-barang-form').action = url;
    }
</script>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2 for both forms
        $('#suplier, #barang, #edit-suplier, #edit-barang').select2({
            theme: 'bootstrap4',
            width: '100%'
        });

        // Update stok info when barang is selected (Add Form)
        $('#barang').change(function() {
            let selectedOption = $(this).find('option:selected');
            let stok = selectedOption.data('stok');
            $('#stok-tersedia').text(stok || '-');
            $('#jml_barang').attr('max', stok);
        });

        // Update stok info when barang is selected (Edit Form)
        $('#edit-barang').change(function() {
            let selectedOption = $(this).find('option:selected');
            let stok = selectedOption.data('stok');
            $('#edit-stok-tersedia').text(stok || '-');
            $('#edit-jml_barang').attr('max', stok);
            
            // Check if this barang has sales transactions
            checkSalesTransactions($(this).val());
        });
        
        // Check sales transactions when editing quantity
        $('#edit-jml_barang').on('change', function() {
            let barangId = $('#edit-barang').val();
            let originalJml = $('#original-jml').val();
            let newJml = $(this).val();
            
            // If reducing quantity, check sales transactions
            if (parseInt(newJml) < parseInt(originalJml)) {
                checkSalesTransactions(barangId);
            } else {
                $('#sales-warning').hide();
            }
        });
        
        // Function to check if barang has sales transactions
        function checkSalesTransactions(barangId) {
            if (!barangId) return;
            
            $.ajax({
                url: "/api/check-sales-transactions/" + barangId,
                type: "GET",
                success: function(response) {
                    if (response.has_transactions) {
                        $('#sales-warning').show().html(
                            '<div class="text-yellow-600"><i class="fas fa-exclamation-triangle"></i> ' +
                            'Peringatan: Barang ini sudah terjual dalam transaksi penjualan. ' +
                            'Mengurangi jumlah dapat menyebabkan stok negatif.</div>'
                        );
                    } else {
                        $('#sales-warning').hide();
                    }
                },
                error: function() {
                    $('#sales-warning').hide();
                }
            });
        }

        // Format harga beli on input (Add Form)
        $('#harga_beli').on('input', function() {
            let value = $(this).val();
            if (value) {
                $(this).val(parseInt(value.replace(/[^\d]/g, '')));
            }
        });

        // Format harga beli on input (Edit Form)
        $('#edit-harga_beli').on('input', function() {
            let value = $(this).val();
            if (value) {
                $(this).val(parseInt(value.replace(/[^\d]/g, '')));
            }
        });

        // Form validation (Add Form)
        $('#transaksiForm').on('submit', function(e) {
            let jmlBarang = parseInt($('#jml_barang').val());
            let stok = parseInt($('#barang option:selected').data('stok'));
            
            if (jmlBarang > stok) {
                e.preventDefault();
                alert('Jumlah barang melebihi stok yang tersedia!');
            }
        });

        // Form validation (Edit Form)
        $('#edit-transaksi-form').on('submit', function(e) {
            let jmlBarang = parseInt($('#edit-jml_barang').val());
            let stok = parseInt($('#edit-barang option:selected').data('stok'));
            
            if (jmlBarang > stok) {
                e.preventDefault();
                alert('Jumlah barang melebihi stok yang tersedia!');
            }
        });

        // Open edit modal
        function openEditModal(url, transaksi) {
            $('#edit-transaksi-form').attr('action', url);
            $('#edit-tgl_transaksi').val(transaksi.tgl_transaksi);
            $('#edit-suplier').val(transaksi.suplier_id).trigger('change');
            $('#edit-barang').val(transaksi.barang_id).trigger('change');
            $('#edit-jml_barang').val(transaksi.jml_barang);
            $('#original-jml').val(transaksi.jml_barang);
            $('#edit-harga_beli').val(transaksi.harga_beli);
            $('#edit-keterangan').val(transaksi.keterangan);
            
            // Check for sales transactions
            checkSalesTransactions(transaksi.barang_id);
            
            // Update stok info
            let selectedOption = $('#edit-barang').find('option:selected');
            let stok = selectedOption.data('stok');
            $('#edit-stok-tersedia').text(stok || '-');
        }
    });
</script>
@endpush