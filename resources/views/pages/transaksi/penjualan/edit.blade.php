@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $storeSettings['store_name'] }} - Edit Transaksi Penjualan</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium uppercase">Edit Transaksi Penjualan</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2">
            <form action="{{ route('transaksi.penjualan.update', $transaksi->id) }}" method="POST" id="transaksi-form">
                @csrf
                @method('PUT')

                @if(session('error'))
                    <div class="mb-4 flex items-center rounded-md border border-danger bg-danger/20 px-5 py-4 text-danger dark:border-0">
                        <x-base.lucide icon="AlertCircle" class="mr-2 h-6 w-6" />
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Data Transaksi -->
                <div class="intro-y box p-5 mb-5">
                    <h3 class="text-lg font-medium pb-3 border-b">Data Transaksi</h3>
                    <div class="grid grid-cols-12 gap-x-5 gap-y-5 mt-5">
                        <div class="col-span-12 sm:col-span-6">
                            <div>
                                <x-base.form-label for="tgl_transaksi">Tanggal Transaksi</x-base.form-label>
                                <x-base.form-input
                                    id="tgl_transaksi"
                                    name="tgl_transaksi"
                                    type="date"
                                    class="w-full"
                                    value="{{ old('tgl_transaksi', $transaksi->tgl_transaksi) }}"
                                    required
                                />
                                @error('tgl_transaksi')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <div>
                                <x-base.form-label for="pelanggan_id">Pelanggan</x-base.form-label>
                                <x-base.tom-select
                                    id="pelanggan_id"
                                    name="pelanggan_id"
                                    class="w-full"
                                    data-placeholder="Pilih Pelanggan"
                                    required
                                >
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach($pelanggan as $p)
                                        <option value="{{ $p->id }}" {{ old('pelanggan_id', $transaksi->pelanggan_id) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama }}
                                        </option>
                                    @endforeach
                                </x-base.tom-select>
                                @error('pelanggan_id')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-12">
                            <div>
                                <x-base.form-label for="keterangan">Keterangan</x-base.form-label>
                                <x-base.form-textarea
                                    id="keterangan"
                                    name="keterangan"
                                    class="w-full"
                                    placeholder="Masukkan keterangan (opsional)"
                                >{{ old('keterangan', $transaksi->keterangan) }}</x-base.form-textarea>
                                @error('keterangan')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tambah Barang -->
                <div class="intro-y box p-5 mb-5">
                    <h3 class="text-lg font-medium pb-3 border-b">Tambah Barang</h3>
                    <div class="grid grid-cols-12 gap-x-5 gap-y-5 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div>
                                <x-base.form-label for="add_barang_id">Barang</x-base.form-label>
                                <x-base.tom-select
                                    id="add_barang_id"
                                    class="w-full"
                                    data-placeholder="Pilih Barang"
                                >
                                    <option value="">Pilih Barang</option>
                                    @foreach($barang as $b)
                                        <option value="{{ $b->id }}"
                                            data-id="{{ $b->id }}"
                                            data-nama="{{ $b->nama }}"
                                            data-stok="{{ $b->stok }}"
                                            data-harga="{{ $b->detail->harga_jual ?? 0 }}"
                                            data-satuan="{{ $b->detail->satuan->satuan ?? '-' }}"
                                            data-jenis="{{ $b->detail->jenis->jenis ?? '-' }}">
                                            {{ $b->nama }} (Stok: {{ $b->stok }})
                                        </option>
                                    @endforeach
                                </x-base.tom-select>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-2">
                            <div>
                                <x-base.form-label for="add_jml_barang">Jumlah</x-base.form-label>
                                <x-base.form-input
                                    id="add_jml_barang"
                                    type="number"
                                    class="w-full"
                                    min="1"
                                    value="1"
                                    placeholder="Qty"
                                />
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div>
                                <x-base.form-label for="add_diskon_id">Diskon</x-base.form-label>
                                <x-base.tom-select
                                    id="add_diskon_id"
                                    class="w-full"
                                    data-placeholder="Pilih Diskon (opsional)"
                                >
                                    <option value="">Tanpa Diskon</option>
                                    @foreach($diskon as $d)
                                        <option value="{{ $d->id }}"
                                            data-id="{{ $d->id }}"
                                            data-nama="{{ $d->nama }}"
                                            data-persen="{{ $d->persen }}">
                                            {{ $d->nama }} ({{ $d->persen }}%)
                                        </option>
                                    @endforeach
                                </x-base.tom-select>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div>
                                <x-base.form-label for="add_subtotal">Subtotal</x-base.form-label>
                                <div class="flex">
                                    <x-base.form-input
                                        id="add_subtotal"
                                        type="number"
                                        class="w-full rounded-r-none"
                                        min="0"
                                        readonly
                                    />
                                    <button type="button" id="add_to_cart" class="btn btn-success rounded-l-none ml-5 px-5 py-2.5 flex items-center font-medium shadow-md hover:bg-success/80 hover:shadow-lg transition-all duration-200 focus:ring-2 focus:ring-success/50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                        <x-base.lucide icon="ShoppingCart" class="h-5 w-5 mr-2" />
                                        <span>Tambah</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keranjang Belanja -->
                <div class="intro-y box p-5">
                    <div class="flex items-center justify-between pb-3 border-b">
                        <h3 class="text-lg font-medium">Keranjang Belanja</h3>
                        <button type="button" id="refresh-cart" class="btn btn-outline-secondary btn-sm flex items-center transition duration-200 hover:bg-slate-100 rounded-md px-3 py-1.5 shadow hover:shadow-md focus:ring-2 focus:ring-slate-200">
                            <x-base.lucide icon="RefreshCw" class="h-4 w-4 mr-1" />
                            <span>Refresh</span>
                        </button>
                    </div>
                    <div class="overflow-x-auto mt-5">
                        <table class="table table-bordered w-full">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th class="whitespace-nowrap">Barang</th>
                                    <th class="whitespace-nowrap">Jenis</th>
                                    <th class="whitespace-nowrap text-center">Jumlah</th>
                                    <th class="whitespace-nowrap">Satuan</th>
                                    <th class="whitespace-nowrap text-right">Harga</th>
                                    <th class="whitespace-nowrap">Diskon</th>
                                    <th class="whitespace-nowrap text-right">Subtotal</th>
                                    <th class="whitespace-nowrap text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                <tr id="empty-cart-row">
                                    <td colspan="8" class="text-center">Keranjang belanja kosong</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-primary/5 font-bold">
                                    <td colspan="6" class="text-right font-medium">Total:</td>
                                    <td class="text-right font-medium">
                                        <span id="cart-total">Rp 0,-</span>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <!-- Hidden Template for Edit/Delete Buttons -->
                    <div id="button-template" class="hidden">
                        <div class="flex justify-center space-x-2">
                            <button type="button" class="btn btn-warning btn-sm edit-item-btn w-16">
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-item-btn w-16">
                                Hapus
                            </button>
                        </div>
                    </div>
                    
                    <input type="hidden" name="cart_items" id="cart_items" value="[]" required>
                    <div class="mt-5 text-center">
                        <div class="inline-flex space-x-3">
                            <a href="{{ route('transaksi.penjualan') }}">
                                <x-base.button
                                    class="w-24"
                                    type="button"
                                    variant="outline-secondary"
                                >
                                    <span class="flex items-center justify-center">
                                        <x-base.lucide icon="X" class="h-4 w-4 mr-1" />
                                        Batal
                                    </span>
                                </x-base.button>
                            </a>
                            <x-base.button
                                class="w-24"
                                type="submit"
                                variant="primary"
                                id="submit-btn"
                                disabled
                            >
                                <span class="flex items-center justify-center">
                                    <x-base.lucide icon="Save" class="h-4 w-4 mr-1" />
                                    Simpan
                                </span>
                            </x-base.button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Item -->
    <x-base.dialog id="edit-item-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Edit Barang</h2>
            </x-base.dialog.title>

            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12">
                    <x-base.form-label for="edit-item-nama">Barang</x-base.form-label>
                    <x-base.form-input
                        id="edit-item-nama"
                        type="text"
                        class="form-control"
                        readonly
                    />
                    <input type="hidden" id="edit-item-index" />
                    <input type="hidden" id="edit-item-barang-id" />
                    <input type="hidden" id="edit-item-harga" />
                    <input type="hidden" id="edit-item-stok" />
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <x-base.form-label for="edit-item-jumlah">Jumlah</x-base.form-label>
                    <x-base.form-input
                        id="edit-item-jumlah"
                        type="number"
                        class="form-control"
                        min="1"
                    />
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <x-base.form-label for="edit-item-diskon">Diskon</x-base.form-label>
                    <x-base.form-select id="edit-item-diskon" class="w-full">
                        <option value="">Tanpa Diskon</option>
                        @foreach($diskon as $d)
                            <option value="{{ $d->id }}" data-persen="{{ $d->persen }}" data-nama="{{ $d->nama }}">
                                {{ $d->nama }} ({{ $d->persen }}%)
                            </option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12">
                    <x-base.form-label for="edit-item-subtotal">Subtotal</x-base.form-label>
                    <x-base.form-input
                        id="edit-item-subtotal"
                        type="number"
                        class="form-control"
                        readonly
                    />
                </div>
            </x-base.dialog.description>

            <x-base.dialog.footer>
                <div class="flex justify-end space-x-3">
                    <x-base.button
                        class="w-24"
                        data-tw-dismiss="modal"
                        type="button"
                        variant="outline-secondary"
                    >
                        <span class="flex items-center justify-center">
                            <x-base.lucide icon="X" class="h-4 w-4 mr-1" />
                            Batal
                        </span>
                    </x-base.button>
                    <x-base.button
                        class="w-24"
                        type="button"
                        variant="primary"
                        id="update-item-btn"
                    >
                        <span class="flex items-center justify-center">
                            <x-base.lucide icon="CheckSquare" class="h-4 w-4 mr-1" />
                            Update
                        </span>
                    </x-base.button>
                </div>
            </x-base.dialog.footer>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Modal Edit Item -->
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let cartItems = [];
        const cartItemsInput = document.getElementById('cart_items');
        const submitBtn = document.getElementById('submit-btn');
        const cartItemsContainer = document.getElementById('cart-items');
        const emptyCartRow = document.getElementById('empty-cart-row');
        
        // Load existing transaction details into cart
        @foreach($transaksi->details as $detail)
        cartItems.push({
            barang_id: {{ $detail->barang_id }},
            nama_barang: "{{ $detail->barang->nama }}",
            jenis: "{{ $detail->barangDetail->jenis->jenis ?? '-' }}",
            satuan: "{{ $detail->barangDetail->satuan->satuan ?? '-' }}",
            harga_satuan: {{ $detail->harga_satuan }},
            jumlah: {{ $detail->jml_barang }},
            diskon_id: {{ $detail->diskon_id ?? 'null' }},
            diskon_nama: "{{ $detail->diskon->nama ?? '' }}",
            diskon_persen: {{ $detail->diskon->persen ?? 0 }},
            subtotal: {{ $detail->subtotal }},
            stok: {{ $detail->barang->stok + $detail->jml_barang }} // Add original stok plus current quantity
        });
        @endforeach
        
        console.log("Loaded cart items:", cartItems);
        
        // Update cart display initially
        updateCartDisplay();
        
        // Add refresh button event listener
        document.getElementById('refresh-cart').addEventListener('click', function() {
            console.log("Refreshing cart display...");
            // Add visual feedback for refresh
            const refreshIcon = this.querySelector('svg');
            refreshIcon.classList.add('animate-spin');
            
            // Refresh the cart display
            updateCartDisplay();
            
            // Remove animation after a short delay
            setTimeout(() => {
                refreshIcon.classList.remove('animate-spin');
            }, 500);
        });
        
        // Calculate subtotal when adding items
        function calculateSubtotal() {
            const barangSelect = document.getElementById('add_barang_id');
            const jumlahInput = document.getElementById('add_jml_barang');
            const diskonSelect = document.getElementById('add_diskon_id');
            const subtotalInput = document.getElementById('add_subtotal');
            
            if (!barangSelect.value || !jumlahInput.value) {
                subtotalInput.value = 0;
                return;
            }
            
            const selectedBarang = barangSelect.options[barangSelect.selectedIndex];
            const harga = parseInt(selectedBarang.dataset.harga);
            const jumlah = parseInt(jumlahInput.value);
            
            let diskonPersen = 0;
            if (diskonSelect.value) {
                const selectedDiskon = diskonSelect.options[diskonSelect.selectedIndex];
                diskonPersen = parseInt(selectedDiskon.dataset.persen);
            }
            
            let subtotal = harga * jumlah;
            if (diskonPersen > 0) {
                subtotal = subtotal - (subtotal * diskonPersen / 100);
            }
            
            subtotalInput.value = Math.round(subtotal);
        }
        
        // Calculate edit item subtotal
        function calculateEditSubtotal() {
            const jumlahInput = document.getElementById('edit-item-jumlah');
            const diskonSelect = document.getElementById('edit-item-diskon');
            const hargaSatuan = parseFloat(document.getElementById('edit-item-harga').value);
            
            if (!jumlahInput.value || isNaN(hargaSatuan)) {
                return;
            }
            
            const jumlah = parseInt(jumlahInput.value);
            
            let diskonPersen = 0;
            if (diskonSelect.value) {
                const selectedOption = diskonSelect.options[diskonSelect.selectedIndex];
                diskonPersen = parseInt(selectedOption.dataset.persen);
            }
            
            let subtotal = hargaSatuan * jumlah;
            if (diskonPersen > 0) {
                subtotal = subtotal - (subtotal * diskonPersen / 100);
            }
            
            document.getElementById('edit-item-subtotal').value = Math.round(subtotal);
        }
        
        // Function to check if add to cart button should be enabled
        function checkAddToCartButton() {
            const barangSelect = document.getElementById('add_barang_id');
            const addToCartBtn = document.getElementById('add_to_cart');
            
            if (barangSelect.value) {
                addToCartBtn.disabled = false;
            } else {
                addToCartBtn.disabled = true;
            }
        }
        
        // Add event listeners for calculating subtotal
        document.getElementById('add_barang_id').addEventListener('change', function() {
            calculateSubtotal();
            checkAddToCartButton();
        });
        document.getElementById('add_jml_barang').addEventListener('input', calculateSubtotal);
        document.getElementById('add_diskon_id').addEventListener('change', calculateSubtotal);
        
        // Add event listeners for edit modal
        document.getElementById('edit-item-jumlah').addEventListener('input', calculateEditSubtotal);
        document.getElementById('edit-item-diskon').addEventListener('change', calculateEditSubtotal);
        
        // Initial check for add to cart button
        checkAddToCartButton();
        
        // Add to cart button
        document.getElementById('add_to_cart').addEventListener('click', function() {
            const barangSelect = document.getElementById('add_barang_id');
            const jumlahInput = document.getElementById('add_jml_barang');
            const diskonSelect = document.getElementById('add_diskon_id');
            const subtotalInput = document.getElementById('add_subtotal');
            
            if (!barangSelect.value || parseInt(jumlahInput.value) < 1) {
                alert('Pilih barang dan masukkan jumlah yang valid');
                return;
            }
            
            const selectedBarang = barangSelect.options[barangSelect.selectedIndex];
            const barangId = barangSelect.value;
            const namaBarang = selectedBarang.dataset.nama;
            const jenis = selectedBarang.dataset.jenis;
            const satuan = selectedBarang.dataset.satuan;
            const hargaSatuan = parseInt(selectedBarang.dataset.harga);
            const jumlah = parseInt(jumlahInput.value);
            const stok = parseInt(selectedBarang.dataset.stok);
            
            // Check stock
            if (jumlah > stok) {
                alert(`Stok tidak mencukupi. Stok tersedia: ${stok}`);
                return;
            }
            
            let diskonId = null;
            let diskonNama = '';
            let diskonPersen = 0;
            
            if (diskonSelect.value) {
                const selectedDiskon = diskonSelect.options[diskonSelect.selectedIndex];
                diskonId = diskonSelect.value;
                diskonNama = selectedDiskon.dataset.nama;
                diskonPersen = selectedDiskon.dataset.persen;
            }
            
            const subtotal = parseInt(subtotalInput.value);
            
            // Add to cart array
            cartItems.push({
                barang_id: barangId,
                nama_barang: namaBarang,
                jenis: jenis,
                satuan: satuan,
                harga_satuan: hargaSatuan,
                jumlah: jumlah,
                diskon_id: diskonId,
                diskon_nama: diskonNama,
                diskon_persen: diskonPersen,
                subtotal: subtotal,
                stok: stok
            });
            
            // Update cart display
            updateCartDisplay();
            
            // Reset form
            barangSelect.value = '';
            jumlahInput.value = 1;
            diskonSelect.value = '';
            subtotalInput.value = 0;
            
            if (typeof tomSelect !== 'undefined') {
                tomSelect['add_barang_id'].clear();
                tomSelect['add_diskon_id'].clear();
            }
        });
        
        // Edit item in cart - called when edit button is clicked
        function editItem(index) {
            if (isNaN(index) || index < 0 || index >= cartItems.length) {
                console.error("Invalid item index:", index);
                return;
            }
            
            const item = cartItems[index];
            console.log("Editing item:", item);
            
            // Populate modal fields
            document.getElementById('edit-item-index').value = index;
            document.getElementById('edit-item-nama').value = item.nama_barang;
            document.getElementById('edit-item-jumlah').value = item.jumlah;
            document.getElementById('edit-item-subtotal').value = item.subtotal;
            document.getElementById('edit-item-barang-id').value = item.barang_id;
            document.getElementById('edit-item-harga').value = item.harga_satuan;
            document.getElementById('edit-item-stok').value = item.stok;
            
            // Set diskon in select
            const diskonSelect = document.getElementById('edit-item-diskon');
            if (item.diskon_id) {
                diskonSelect.value = item.diskon_id;
            } else {
                diskonSelect.value = '';
            }
            
            // Calculate subtotal
            calculateEditSubtotal();
        }
        
        // Update item in cart
        document.getElementById('update-item-btn').addEventListener('click', function() {
            const index = parseInt(document.getElementById('edit-item-index').value);
            const jumlah = parseInt(document.getElementById('edit-item-jumlah').value);
            const diskonSelect = document.getElementById('edit-item-diskon');
            const subtotal = parseInt(document.getElementById('edit-item-subtotal').value);
            const stok = parseInt(document.getElementById('edit-item-stok').value);
            
            if (isNaN(index) || isNaN(jumlah) || jumlah < 1) {
                alert('Masukkan jumlah yang valid');
                return;
            }
            
            if (index < 0 || index >= cartItems.length) {
                console.error("Invalid item index:", index);
                return;
            }
            
            // Check stock for the updated quantity
            if (jumlah > stok) {
                alert(`Stok tidak mencukupi. Stok tersedia: ${stok}`);
                return;
            }
            
            // Update item in cart
            cartItems[index].jumlah = jumlah;
            cartItems[index].subtotal = subtotal;
            
            if (diskonSelect.value) {
                const selectedOption = diskonSelect.options[diskonSelect.selectedIndex];
                cartItems[index].diskon_id = diskonSelect.value;
                cartItems[index].diskon_nama = selectedOption.dataset.nama;
                cartItems[index].diskon_persen = parseInt(selectedOption.dataset.persen);
            } else {
                cartItems[index].diskon_id = null;
                cartItems[index].diskon_nama = '';
                cartItems[index].diskon_persen = 0;
            }
            
            // Update cart display
            updateCartDisplay();
            
            // Close modal
            const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('edit-item-modal'));
            modal.hide();
        });
        
        // Update cart display
        function updateCartDisplay() {
            console.log("Updating cart display with items:", cartItems);
            
            // Update hidden input
            cartItemsInput.value = JSON.stringify(cartItems);
            
            // Show/hide empty cart message
            if (cartItems.length === 0) {
                emptyCartRow.style.display = 'table-row';
                submitBtn.disabled = true;
            } else {
                emptyCartRow.style.display = 'none';
                submitBtn.disabled = false;
            }
            
            // Clear existing items
            while (cartItemsContainer.children.length > 1) {
                cartItemsContainer.removeChild(cartItemsContainer.lastChild);
            }
            
            // Get button template
            const buttonTemplate = document.getElementById('button-template').innerHTML;
            
            // Add cart items to table
            let total = 0;
            cartItems.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = index % 2 === 0 ? 'bg-slate-50' : '';
                row.setAttribute('data-index', index);
                
                // Create cells for data
                const nameCell = document.createElement('td');
                nameCell.textContent = item.nama_barang;
                
                const jenisCell = document.createElement('td');
                jenisCell.textContent = item.jenis;
                
                const jumlahCell = document.createElement('td');
                jumlahCell.className = 'text-center';
                jumlahCell.textContent = item.jumlah;
                
                const satuanCell = document.createElement('td');
                satuanCell.textContent = item.satuan;
                
                const hargaCell = document.createElement('td');
                hargaCell.className = 'text-right';
                hargaCell.textContent = `Rp ${numberFormat(item.harga_satuan)},-`;
                
                const diskonCell = document.createElement('td');
                diskonCell.textContent = item.diskon_id ? `${item.diskon_nama} (${item.diskon_persen}%)` : 'Tidak ada';
                
                const subtotalCell = document.createElement('td');
                subtotalCell.className = 'text-right';
                subtotalCell.textContent = `Rp ${numberFormat(item.subtotal)},-`;
                
                // Create action cell
                const actionCell = document.createElement('td');
                actionCell.className = 'text-center relative';
                
                // Create button container for better alignment
                const buttonContainer = document.createElement('div');
                buttonContainer.className = 'flex items-center justify-center space-x-3';
                
                // Use HTML content approach for the edit button
                const editButton = document.createElement('button');
                editButton.type = 'button';
                editButton.className = 'btn btn-sm btn-warning p-2 inline-flex items-center justify-center rounded-md shadow-md hover:bg-warning/80 hover:shadow-lg transition-all duration-200 focus:ring-2 focus:ring-warning/50';
                editButton.setAttribute('data-tw-toggle', 'modal');
                editButton.setAttribute('data-tw-target', '#edit-item-modal');
                editButton.setAttribute('data-index', index);
                editButton.setAttribute('title', 'Edit');
                editButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="min-width: 16px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>';
                
                editButton.onclick = function() {
                    editItem(index);
                    return false;
                };
                
                // Use HTML content approach for the delete button
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = 'btn btn-sm btn-danger p-2 inline-flex items-center justify-center rounded-md shadow-md hover:bg-danger/80 hover:shadow-lg transition-all duration-200 focus:ring-2 focus:ring-danger/50';
                deleteButton.setAttribute('data-index', index);
                deleteButton.setAttribute('title', 'Hapus');
                deleteButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="min-width: 16px;"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>';
                
                deleteButton.onclick = function() {
                    if (confirm('Yakin ingin menghapus item ini dari keranjang?')) {
                        cartItems.splice(index, 1);
                        updateCartDisplay();
                    }
                    return false;
                };
                
                // Add buttons to button container
                buttonContainer.appendChild(editButton);
                buttonContainer.appendChild(deleteButton);
                
                // Add button container to action cell
                actionCell.appendChild(buttonContainer);
                
                // Append all cells to row
                row.appendChild(nameCell);
                row.appendChild(jenisCell);
                row.appendChild(jumlahCell);
                row.appendChild(satuanCell);
                row.appendChild(hargaCell);
                row.appendChild(diskonCell);
                row.appendChild(subtotalCell);
                row.appendChild(actionCell);
                
                cartItemsContainer.appendChild(row);
                total += item.subtotal;
            });
            
            // Update total
            document.getElementById('cart-total').textContent = `Rp ${numberFormat(total)},-`;
            
            // Initialize Lucide icons if available
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
        
        // Helper function to format numbers
        function numberFormat(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        // Initialize cart calculation
        calculateSubtotal();
    });
</script>
