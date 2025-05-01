@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $storeSettings['store_name'] }} - Tambah Transaksi Penjualan</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <h2 class="mr-auto text-lg font-medium uppercase">Tambah Transaksi Penjualan</h2>
        <div class="mt-4 flex w-full sm:mt-0 sm:w-auto">
            <x-base.button
                as="a"
                href="{{ route('transaksi.penjualan') }}"
                variant="warning"
                class="shadow-md mr-2"
            >
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="ArrowLeft"
                />
                Kembali
            </x-base.button>
        </div>
                </div>
                
    <div class="intro-y mt-5 grid grid-cols-12 gap-6">
        <!-- Barang Selection Form -->
        <div class="col-span-12 lg:col-span-4">
            <div class="box p-5">
                <div class="flex items-center mb-3">
                    <h3 class="text-base font-medium">Pilih Barang</h3>
                </div>
                <div class="border-t border-slate-200/60 pt-5">
                    <div class="mb-4">
                        <x-base.form-label for="barang_id">Barang</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="far fa-box text-slate-400"></i>
                            </div>
                            <x-base.form-select id="barang_id" class="form-select">
                                <option value="">Pilih Barang</option>
                                @foreach($barang as $b)
                                    <option value="{{ $b->id }}" 
                                        data-harga="{{ $b->detail ? $b->detail->harga_jual : 0 }}" 
                                        data-stok="{{ $b->stok }}"
                                        data-nama="{{ $b->nama }}"
                                        data-satuan="{{ $b->satuan ? $b->satuan->satuan : '' }}">
                                        {{ $b->nama }} - {{ $b->satuan ? $b->satuan->satuan : '' }} (Stok: {{ $b->stok }})
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div id="stok-info" class="mt-2 hidden items-center text-xs">
                            <span class="text-primary"></span>
            </div>
        </div>

                    <div class="mb-4">
                        <x-base.form-label for="jml_barang">Jumlah</x-base.form-label>
                        <div class="flex items-center">
                            <x-base.button
                                id="decrease-qty"
                                variant="secondary"
                                class="w-10 h-10 flex items-center justify-center"
                                type="button"
                            >
                                <x-base.lucide
                                    icon="Minus"
                                    class="h-4 w-4"
                                />
                            </x-base.button>
                            <x-base.form-input
                                id="jml_barang"
                                type="number"
                                placeholder="Jumlah"
                                min="1"
                                value="1"
                                class="mx-2 text-center form-control"
                            />
                            <x-base.button
                                id="increase-qty"
                                variant="secondary"
                                class="w-10 h-10 flex items-center justify-center"
                                type="button"
                            >
                                <x-base.lucide
                                    icon="Plus"
                                    class="h-4 w-4"
                                />
                            </x-base.button>
                                </div>
                    </div>

                    <div class="mb-4">
                        <x-base.form-label for="diskon_id">Diskon</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="far fa-tag text-slate-400"></i>
                            </div>
                            <x-base.form-select id="diskon_id" class="form-select">
                                <option value="">Pilih Diskon</option>
                                @foreach($diskon as $d)
                                    <option value="{{ $d->id }}" data-persen="{{ $d->persen }}" data-nama="{{ $d->nama }}">
                                        {{ $d->nama }} ({{ $d->persen }}%)
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-base.form-label for="harga_satuan">Harga Satuan</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="far fa-money-bill-alt text-slate-400"></i>
                            </div>
                            <x-base.form-input
                                id="harga_satuan"
                                type="text"
                                placeholder="Rp. 0"
                                readonly
                                class="form-control bg-slate-50"
                            />
                        </div>
                    </div>

                    <div class="rounded-lg bg-primary/5 p-4 mb-4">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-slate-600">Subtotal</div>
                            <div class="text-sm font-medium" id="item-subtotal">Rp 0</div>
                        </div>
                        <div id="item-diskon-container" class="hidden flex justify-between mt-2 items-center">
                            <div class="text-sm text-slate-600">Diskon <span id="item-diskon-label"></span></div>
                            <div class="text-sm font-medium text-danger" id="item-diskon-value">Rp 0</div>
                        </div>
                        <div class="flex justify-between mt-2 pt-2 border-t border-slate-200/60 items-center">
                            <div class="text-sm font-medium">Total Item</div>
                            <div class="text-sm font-medium text-success" id="item-total">Rp 0</div>
                        </div>
                    </div>

                    <x-base.button
                        id="add-to-cart"
                        variant="primary"
                        class="w-full flex items-center justify-center"
                        type="button"
                    >
                        <i class="fas fa-cart-plus mr-2"></i> Tambah ke Keranjang
                        </x-base.button>
                </div>
            </div>
        </div>

        <!-- Cart and Checkout Form -->
        <div class="col-span-12 lg:col-span-8">
            <form action="{{ route('transaksi.penjualan.store') }}" method="POST" id="penjualanForm">
                @csrf
                <div class="box p-5 mb-5">
                    <div class="flex items-center mb-5">
                        <div>
                            <h3 class="text-base font-medium">Keranjang Belanja</h3>
                            <p class="text-xs text-slate-500" id="cart-items-count">0 item dalam keranjang</p>
                        </div>
                        <div class="ml-auto">
                        <x-base.button
                                id="clear-cart"
                                variant="outline-danger"
                                class="btn-sm"
                                type="button"
                                data-tw-toggle="modal"
                                data-tw-target="#clear-cart-modal"
                            >
                                <i class="fas fa-trash-alt mr-1"></i> Kosongkan
                        </x-base.button>
                        </div>
                    </div>

                    <div id="cart-empty-message" class="text-center py-10">
                        <div class="mb-4">
                            <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 text-slate-300">
                                <i class="fas fa-shopping-cart text-3xl"></i>
                            </span>
                        </div>
                        <h4 class="text-slate-500 font-medium">Keranjang belanja kosong</h4>
                        <p class="text-xs text-slate-400 mt-1">Tambahkan barang ke keranjang untuk memulai transaksi</p>
                            </div>
                    
                    <div id="cart-items-container" class="hidden">
                        <div class="overflow-x-auto w-full">
                            <table class="table table-striped w-full">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap text-left">#</th>
                                        <th class="whitespace-nowrap text-left">Barang</th>
                                        <th class="whitespace-nowrap text-center">Jumlah</th>
                                        <th class="whitespace-nowrap text-center">Harga</th>
                                        <th class="whitespace-nowrap text-center">Diskon</th>
                                        <th class="whitespace-nowrap text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                    <!-- Cart items will be added here dynamically -->
                                </tbody>
                                <tfoot id="cart-summary" class="bg-slate-50 font-medium">
                                    <tr>
                                        <td colspan="5" class="text-right">Total Keranjang:</td>
                                        <td class="text-right text-primary" id="cart-total-row">Rp 0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box p-5">
                    <div class="flex items-center mb-3">
                        <h3 class="text-base font-medium">Informasi Transaksi</h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="tgl_transaksi">Tanggal Transaksi</x-base.form-label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="far fa-calendar text-slate-400"></i>
                                </div>
                                <x-base.form-input
                                    id="tgl_transaksi"
                                    name="tgl_transaksi"
                                    type="date"
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full form-control"
                                    required
                                />
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="pelanggan_id">Pelanggan</x-base.form-label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="far fa-user text-slate-400"></i>
                                </div>
                                <x-base.form-select name="pelanggan_id" id="pelanggan_id" class="form-select" required>
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach($pelanggan as $p)
                                        <option value="{{ $p->id }}" data-nama="{{ $p->nama }}">{{ $p->nama }}</option>
                                    @endforeach
                                </x-base.form-select>
                            </div>
                        </div>

                        <div class="col-span-12">
                            <x-base.form-label for="keterangan">Keterangan</x-base.form-label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="far fa-sticky-note text-slate-400"></i>
                                </div>
                                <x-base.form-textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan untuk transaksi ini..."></x-base.form-textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden field to store cart items data -->
                    <input type="hidden" id="cart_items" name="cart_items" value="[]">

                    <div class="mt-5 flex justify-between items-center p-4 rounded-lg bg-slate-50">
                        <div>
                            <div class="text-slate-500">Total Transaksi</div>
                            <div class="text-2xl font-bold text-primary" id="cart-total">Rp 0</div>
    </div>
                        <div class="flex items-center">
                <x-base.button
                                variant="outline-secondary"
                                class="mr-3"
                    type="button"
                                onclick="window.location.href='{{ route('transaksi.penjualan') }}'"
                >
                                <i class="far fa-times-circle mr-1"></i> Batal
                </x-base.button>
                <x-base.button
                                id="submitButton"
                    variant="primary"
                                type="submit"
                                disabled
                >
                                <i class="far fa-save mr-1"></i> Simpan Transaksi
                </x-base.button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Elements
            const barangSelect = document.getElementById('barang_id');
            const jumlahInput = document.getElementById('jml_barang');
            const diskonSelect = document.getElementById('diskon_id');
            const hargaSatuanInput = document.getElementById('harga_satuan');
            const itemSubtotal = document.getElementById('item-subtotal');
            const itemDiskonContainer = document.getElementById('item-diskon-container');
            const itemDiskonLabel = document.getElementById('item-diskon-label');
            const itemDiskonValue = document.getElementById('item-diskon-value');
            const itemTotal = document.getElementById('item-total');
            const stokInfo = document.getElementById('stok-info');
            const increaseBtn = document.getElementById('increase-qty');
            const decreaseBtn = document.getElementById('decrease-qty');
            const addToCartBtn = document.getElementById('add-to-cart');
            const clearCartBtn = document.getElementById('clear-cart');
            const cartItemsContainer = document.getElementById('cart-items-container');
            const cartEmptyMessage = document.getElementById('cart-empty-message');
            const cartItems = document.getElementById('cart-items');
            const cartItemsCount = document.getElementById('cart-items-count');
            const cartTotal = document.getElementById('cart-total');
            const cartTotalRow = document.getElementById('cart-total-row');
            const cartItemsInput = document.getElementById('cart_items');
            const pelangganSelect = document.getElementById('pelanggan_id');
            const submitButton = document.getElementById('submitButton');
            const penjualanForm = document.getElementById('penjualanForm');
            
            let currentHarga = 0;
            let currentStok = 0;
            let cart = [];
            
            // Format currency function
            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            }
            
            // Update quantity
            increaseBtn.addEventListener('click', function() {
                const current = parseInt(jumlahInput.value) || 0;
                if (current < currentStok) {
                    jumlahInput.value = current + 1;
                    jumlahInput.dispatchEvent(new Event('input'));
                }
            });
            
            decreaseBtn.addEventListener('click', function() {
                const current = parseInt(jumlahInput.value) || 0;
                if (current > 1) {
                    jumlahInput.value = current - 1;
                    jumlahInput.dispatchEvent(new Event('input'));
                }
            });
            
            // Calculate item price
            function calculateItemPrice() {
                const barangOption = barangSelect.options[barangSelect.selectedIndex];
                const diskonOption = diskonSelect.options[diskonSelect.selectedIndex];
                
                if (barangOption && barangOption.value) {
                    const harga = parseFloat(barangOption.dataset.harga) || 0;
                    const jumlah = parseInt(jumlahInput.value) || 0;
                    const stok = parseInt(barangOption.dataset.stok) || 0;
                    const satuan = barangOption.dataset.satuan;
                    
                    currentHarga = harga;
                    currentStok = stok;
                    
                    // Display stok info
                    stokInfo.querySelector('span:last-child').textContent = `Stok tersedia: ${stok} ${satuan}`;
                    stokInfo.classList.remove('hidden');
                    stokInfo.classList.add('flex');
                    
                    // Update quantity buttons
                    if (jumlah >= stok) {
                        increaseBtn.disabled = true;
                        increaseBtn.classList.add('opacity-50');
                    } else {
                        increaseBtn.disabled = false;
                        increaseBtn.classList.remove('opacity-50');
                    }
                    
                    if (jumlah <= 1) {
                        decreaseBtn.disabled = true;
                        decreaseBtn.classList.add('opacity-50');
                    } else {
                        decreaseBtn.disabled = false;
                        decreaseBtn.classList.remove('opacity-50');
                    }
                    
                    // Display harga satuan
                    hargaSatuanInput.value = formatRupiah(harga);
                    
                    let subtotal = harga * jumlah;
                    let diskonNilai = 0;
                    
                    // Calculate and display subtotal
                    itemSubtotal.textContent = formatRupiah(subtotal);
                    
                    // Apply discount if selected
                    if (diskonOption && diskonOption.value) {
                        const diskonPersen = parseFloat(diskonOption.dataset.persen) || 0;
                        
                        diskonNilai = (subtotal * diskonPersen) / 100;
                        
                        itemDiskonLabel.textContent = `(${diskonPersen}%)`;
                        itemDiskonValue.textContent = `- ${formatRupiah(diskonNilai)}`;
                        itemDiskonContainer.classList.remove('hidden');
                    } else {
                        itemDiskonContainer.classList.add('hidden');
                    }
                    
                    const total = subtotal - diskonNilai;
                    itemTotal.textContent = formatRupiah(total);
                    
                    // Enable/disable add to cart button
                    if (barangOption.value && jumlah > 0 && jumlah <= stok) {
                        addToCartBtn.disabled = false;
                        addToCartBtn.classList.remove('opacity-50');
                    } else {
                        addToCartBtn.disabled = true;
                        addToCartBtn.classList.add('opacity-50');
                    }
                } else {
                    hargaSatuanInput.value = formatRupiah(0);
                    itemSubtotal.textContent = formatRupiah(0);
                    itemTotal.textContent = formatRupiah(0);
                    itemDiskonContainer.classList.add('hidden');
                    stokInfo.classList.add('hidden');
                    stokInfo.classList.remove('flex');
                    addToCartBtn.disabled = true;
                    addToCartBtn.classList.add('opacity-50');
                }
            }
            
            // Add item to cart
            addToCartBtn.addEventListener('click', function() {
                const barangOption = barangSelect.options[barangSelect.selectedIndex];
                const diskonOption = diskonSelect.options[diskonSelect.selectedIndex];
                
                if (barangOption && barangOption.value) {
                    const barangId = barangOption.value;
                    const barangNama = barangOption.dataset.nama;
                    const satuan = barangOption.dataset.satuan;
                    const harga = parseFloat(barangOption.dataset.harga) || 0;
                    const jumlah = parseInt(jumlahInput.value) || 0;
                    const stok = parseInt(barangOption.dataset.stok) || 0;
                    
                    let diskonId = null;
                    let diskonNama = null;
                    let diskonPersen = 0;
                    let subtotal = harga * jumlah;
                    let diskonNilai = 0;
                    
                    if (diskonOption && diskonOption.value) {
                        diskonId = diskonOption.value;
                        diskonNama = diskonOption.dataset.nama;
                        diskonPersen = parseFloat(diskonOption.dataset.persen) || 0;
                        diskonNilai = (subtotal * diskonPersen) / 100;
                    }
                    
                    const total = subtotal - diskonNilai;
                    
                    // Check if the same item with same discount is already in cart
                    const existingItemIndex = cart.findIndex(item => 
                        item.barang_id === barangId && item.diskon_id === diskonId
                    );
                    
                    if (existingItemIndex !== -1) {
                        // Update existing item
                        const existingItem = cart[existingItemIndex];
                        const newQuantity = existingItem.jumlah + jumlah;
                        
                        // Check if new quantity exceeds stock
                        if (newQuantity > stok) {
                            alert(`Total jumlah barang (${newQuantity}) melebihi stok yang tersedia (${stok})!`);
                            return;
                        }
                        
                        // Update quantity and totals
                        existingItem.jumlah = newQuantity;
                        existingItem.subtotal = harga * newQuantity;
                        existingItem.diskon_nilai = (existingItem.subtotal * diskonPersen) / 100;
                        existingItem.total = existingItem.subtotal - existingItem.diskon_nilai;
                        
                        cart[existingItemIndex] = existingItem;
                    } else {
                        // Add new item to cart
                        cart.push({
                            barang_id: barangId,
                            barang_nama: barangNama,
                            satuan: satuan,
                            harga: harga,
                            jumlah: jumlah,
                            subtotal: subtotal,
                            diskon_id: diskonId,
                            diskon_nama: diskonNama,
                            diskon_persen: diskonPersen,
                            diskon_nilai: diskonNilai,
                            total: total
                        });
                    }
                    
                    // Update cart display
                    updateCartDisplay();
                    
                    // Reset selection
                    barangSelect.selectedIndex = 0;
                    jumlahInput.value = 1;
                    diskonSelect.selectedIndex = 0;
                    calculateItemPrice();
                }
            });
            
            // Helper to clear cart after confirmation modal
            window.clearCart = function() {
                cart = [];
                updateCartDisplay();
            };
            
            // Remove item from cart
            function removeFromCart(index) {
                cart.splice(index, 1);
                updateCartDisplay();
            }
            
            // Update cart display
            function updateCartDisplay() {
                // Update hidden input with cart data
                cartItemsInput.value = JSON.stringify(cart);
                
                // Update cart items count
                cartItemsCount.textContent = `${cart.length} item dalam keranjang`;
                
                // Show/hide cart elements
                if (cart.length > 0) {
                    cartItemsContainer.classList.remove('hidden');
                    cartEmptyMessage.classList.add('hidden');
                } else {
                    cartItemsContainer.classList.add('hidden');
                    cartEmptyMessage.classList.remove('hidden');
                }
                
                // Clear cart items
                cartItems.innerHTML = '';
                
                // Calculate cart total
                let cartTotalValue = 0;
                
                // Add cart items
                cart.forEach((item, index) => {
                    cartTotalValue += item.total;
                    
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="align-middle">${index + 1}</td>
                        <td class="align-middle">
                            <div class="font-medium">${item.barang_nama}</div>
                        </td>
                        <td class="text-center align-middle font-medium">
                            <div class="font-medium">
                                ${item.jumlah} ${item.satuan}
                </div>
                        </td>
                        <td class="text-center align-middle">${formatRupiah(item.harga)}</td>
                        <td class="text-center align-middle">${item.diskon_persen ? `${item.diskon_persen}%` : '-'}</td>
                        <td class="text-right align-middle font-medium">${formatRupiah(item.total)}</td>
                    `;
                    cartItems.appendChild(row);
                });
                
                // Update cart total displays
                cartTotal.textContent = formatRupiah(cartTotalValue);
                cartTotalRow.textContent = formatRupiah(cartTotalValue);
                
                // Enable/disable submit button
                const pelangganSelected = pelangganSelect.value !== '';
                
                if (cart.length > 0 && pelangganSelected) {
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50');
                } else {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50');
                }
            }
            
            // Event listeners
            barangSelect.addEventListener('change', calculateItemPrice);
            jumlahInput.addEventListener('input', calculateItemPrice);
            diskonSelect.addEventListener('change', calculateItemPrice);
            pelangganSelect.addEventListener('change', updateCartDisplay);
            
            // Form validation
            penjualanForm.addEventListener('submit', function(e) {
                if (cart.length === 0) {
                    e.preventDefault();
                    alert('Keranjang belanja kosong! Tambahkan minimal 1 barang.');
                    return false;
                }
                
                if (!pelangganSelect.value) {
                    e.preventDefault();
                    alert('Silakan pilih pelanggan terlebih dahulu!');
                    return false;
                }
            });
            
            // Initialize
            calculateItemPrice();
            updateCartDisplay();
            
            // Disable add to cart button initially
            addToCartBtn.disabled = true;
            addToCartBtn.classList.add('opacity-50');
        });
    </script>
    @endpush

    <!-- BEGIN: Clear Cart Confirmation Modal -->
    <x-base.dialog id="clear-cart-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-warning" icon="AlertTriangle" />
                <div class="mt-5 text-lg font-medium">Kosongkan Keranjang?</div>
                <div class="mt-2 text-slate-500">Apakah Anda yakin ingin mengosongkan keranjang?</div>
            </div>
            <div class="px-5 pb-8 text-center">
                <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                    Batal
                </x-base.button>
                <x-base.button class="w-24" data-tw-dismiss="modal" type="button" variant="danger" onclick="clearCart()">
                    Kosongkan
                </x-base.button>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Clear Cart Confirmation Modal -->
@endsection
