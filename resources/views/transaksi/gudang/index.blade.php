@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Transaksi Gudang</h3>
                    <form action="{{ route('transaksi.gudang.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <form action="{{ route('transaksi.gudang.store') }}" method="POST" id="transaksiForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tgl_transaksi">Tanggal Transaksi</label>
                                    <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="suplier_id">Suplier</label>
                                    <select class="form-control select2" id="suplier_id" name="suplier_id" required>
                                        <option value="">Pilih Suplier</option>
                                        @foreach($suplier as $s)
                                            <option value="{{ $s->id }}">{{ $s->nama_suplier }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="barang_id">Barang</label>
                                    <select class="form-control select2" id="barang_id" name="barang_id" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach($barang as $b)
                                            <option value="{{ $b->id }}" data-stok="{{ $b->stok }}">{{ $b->nama_barang }} (Stok: {{ $b->stok }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jml_barang">Jumlah Barang</label>
                                    <input type="number" class="form-control" id="jml_barang" name="jml_barang" required min="1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="harga_beli">Harga Beli</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" required min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan (opsional)">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </form>

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Suplier</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Beli</th>
                                    <th>Keterangan</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi as $t)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($t->tgl_transaksi)->format('d/m/Y') }}</td>
                                    <td>{{ $t->suplier->nama_suplier }}</td>
                                    <td>{{ $t->barang->nama_barang }}</td>
                                    <td>{{ number_format($t->jml_barang, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($t->harga_beli, 0, ',', '.') }}</td>
                                    <td>{{ $t->keterangan ?? '-' }}</td>
                                    <td>{{ $t->user->name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $t->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('transaksi.gudang.destroy', $t->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $transaksi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        // Format harga beli on input
        $('#harga_beli').on('input', function() {
            let value = $(this).val();
            if (value) {
                $(this).val(parseInt(value.replace(/[^\d]/g, '')));
            }
        });

        // Check stok when barang is selected
        $('#barang_id').change(function() {
            let selectedOption = $(this).find('option:selected');
            let stok = selectedOption.data('stok');
            $('#jml_barang').attr('max', stok);
        });

        // Form validation
        $('#transaksiForm').on('submit', function(e) {
            let jmlBarang = parseInt($('#jml_barang').val());
            let stok = parseInt($('#barang_id option:selected').data('stok'));
            
            if (jmlBarang > stok) {
                e.preventDefault();
                alert('Jumlah barang melebihi stok yang tersedia!');
            }
        });

        // Edit button functionality
        $('.edit-btn').click(function() {
            var id = $(this).data('id');
            // Add your edit functionality here
        });
    });
</script>
@endpush 