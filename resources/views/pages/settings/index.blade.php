@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $storeSettings['store_name'] }} - Pengaturan Toko</title>
    <style>
        @keyframes progressBar {
            0% { width: 100%; }
            100% { width: 0%; }
        }
        
        .notification-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background-color: rgba(16, 185, 129, 0.6);
            width: 100%;
            animation: progressBar 5s linear;
        }
        
        .animate__animated {
            animation-duration: 0.5s;
        }
        
        .animate__fadeInDown {
            animation-name: fadeInDown;
        }
        
        .animate__fadeOutUp {
            animation-name: fadeOutUp;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        
        @keyframes fadeOutUp {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                transform: translate3d(0, -20px, 0);
            }
        }
    </style>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            <span class="text-primary">Pengaturan</span> Toko
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Store Settings -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Informasi Toko
                    </h2>
                </div>
                <div class="p-5">
                    @if(session('success'))
                        <div id="successNotification" class="alert-success-custom animate__animated animate__fadeInDown mb-6">
                            <div class="flex p-4 rounded-md bg-success/20 border-l-4 border-success overflow-hidden relative">
                                <div class="flex-none">
                                    <div class="bg-success text-white rounded-full p-2 mr-3">
                                        <i data-lucide="check" class="w-5 h-5"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-base text-success">Berhasil!</div>
                                    <div class="text-success/80 mt-1">{{ session('success') }}</div>
                                </div>
                                <button type="button" class="absolute top-2 right-2 text-success/60 hover:text-success" onclick="closeNotification()">
                                    <i data-lucide="x" class="w-5 h-5"></i>
                                </button>
                                <div class="notification-progress"></div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
                        @csrf
                        <div class="mt-3">
                            <x-base.form-label class="font-medium" for="store_name">
                                Nama Toko <span class="text-danger">*</span>
                            </x-base.form-label>
                            <div class="relative">
                                <div class="input-group">
                                    <x-base.form-input
                                        id="store_name"
                                        name="store_name"
                                        type="text"
                                        value="{{ old('store_name', $settings['store_name']) }}"
                                        placeholder="Masukkan nama toko"
                                        required
                                        class="form-control focus:border-primary"
                                        maxlength="50"
                                        autofocus
                                    />
                                </div>
                                <div class="flex justify-between mt-2 text-xs">
                                    <div class="form-help text-slate-500">
                                        Nama toko akan ditampilkan pada semua halaman aplikasi.
                                    </div>
                                    <div class="form-help text-primary">
                                        <span id="charCount">0</span>/50 karakter
                                    </div>
                                </div>
                            </div>
                            @error('store_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-5">
                            <x-base.form-label class="font-medium mb-3" for="store_icon">
                                Ikon Toko
                            </x-base.form-label>
                            <div class="border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4" id="dropzone">
                                <div class="flex flex-wrap px-4 w-full">
                                    <div id="imagePreview" class="w-full flex justify-center items-center mb-5 @if($settings['store_icon']) hidden @endif">
                                        <div class="text-center">
                                            <div class="mx-auto">
                                                <i data-lucide="image" class="w-12 h-12 text-slate-300"></i>
                                            </div>
                                            <div class="text-slate-500 dark:text-slate-400 mt-2">
                                                Belum ada ikon toko
                                            </div>
                                        </div>
                                    </div>
                                    <div id="currentImage" class="image-preview w-full flex justify-center items-center mb-5 @if(!$settings['store_icon']) hidden @endif">
                                        <div class="relative">
                                            <img 
                                                src="{{ $settings['store_icon'] ? Storage::disk('s3')->url($settings['store_icon']) : '' }}" 
                                                alt="Current Store Icon" 
                                                class="rounded-md max-h-32 max-w-[200px] object-contain"
                                            >
                                            <button type="button" id="removeImage" class="absolute top-0 right-0 -mr-2 -mt-2 w-5 h-5 rounded-full bg-danger text-white flex items-center justify-center">
                                                <i data-lucide="x" class="w-3 h-3"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="newImagePreview" class="w-full flex justify-center items-center mb-5 hidden">
                                        <div class="relative">
                                            <img src="" alt="New Store Icon" class="rounded-md max-h-32 max-w-[200px] object-contain">
                                            <button type="button" id="removeNewImage" class="absolute top-0 right-0 -mr-2 -mt-2 w-5 h-5 rounded-full bg-danger text-white flex items-center justify-center">
                                                <i data-lucide="x" class="w-3 h-3"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 pb-4 flex items-center cursor-pointer relative">
                                    <i data-lucide="upload-cloud" class="w-4 h-4 mr-2 text-primary"></i> 
                                    <span class="text-primary mr-1 font-medium">Upload file</span> atau tarik dan letakkan
                                    <input id="store_icon" type="file" name="store_icon" class="w-full h-full top-0 left-0 absolute opacity-0" accept="image/*">
                                    <input type="hidden" name="remove_icon" id="remove_icon" value="0">
                                </div>
                                @error('store_icon')
                                    <div class="text-danger mt-2 px-4">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-help mt-3">
                                Format file: JPG, PNG, GIF. Ukuran maksimal: 2MB. Rekomendasi: 200x200px.
                            </div>
                        </div>

                        <div class="flex justify-end mt-8 border-t border-slate-200/60 dark:border-darkmode-400 pt-5">
                            <x-base.button variant="outline-secondary" class="w-28 mr-1" id="resetBtn" type="button">
                                <i data-lucide="refresh-ccw" class="w-4 h-4 mr-2"></i> Reset
                            </x-base.button>
                            <x-base.button variant="primary" class="w-40 shadow-md" type="submit" id="saveBtn">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END: Store Settings -->
        </div>

        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Preview -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Pratinjau Logo Toko
                    </h2>
                </div>
                <div class="p-5">
                    <div class="flex flex-col items-center">
                        <div class="text-center mb-5">
                            <div class="text-base text-slate-500">Tampilan Logo di Header</div>
                        </div>
                        <div class="px-5 py-8 border rounded-md dark:border-darkmode-400 flex flex-col items-center justify-center w-full">
                            <div class="flex items-center bg-white p-5 rounded-md shadow-md">
                                <div id="previewIcon" class="w-12 h-12 mr-3 flex items-center justify-center">
                                    @if($settings['store_icon'])
                                        <img src="{{ Storage::disk('s3')->url($settings['store_icon']) }}" alt="{{ $settings['store_name'] }}" class="max-w-full max-h-full object-contain">
                                    @else
                                        <svg width="48px" height="48px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                            <g><defs><style>.cls-1{fill:#f19b5f;}.cls-2{fill:#ffce69;}.cls-3{fill:#6c2e7c;}</style></defs>
                                            <g id="Icons"><path class="cls-1" d="M18.6,23H5.4a3,3,0,0,1-2.98-3.37l.39-3.13.86-6.87A3.01,3.01,0,0,1,6.65,7h10.7a3.01,3.01,0,0,1,2.98,2.63l.86,6.87.39,3.13A3,3,0,0,1,18.6,23Z"></path>
                                            <path class="cls-2" d="M21.19,16.5A2.976,2.976,0,0,1,18.6,18H5.4a2.976,2.976,0,0,1-2.59-1.5l.86-6.87A3.01,3.01,0,0,1,6.65,7h10.7a3.01,3.01,0,0,1,2.98,2.63Z"></path></g>
                                            <g data-name="Layer 4" id="Layer_4"><path class="cls-3" d="M5.4,24H18.6a4,4,0,0,0,3.968-4.5l-1.25-10A4.005,4.005,0,0,0,17.352,6H17V5A5,5,0,0,0,7,5V6H6.648A4.005,4.005,0,0,0,2.68,9.5l-1.25,10A4,4,0,0,0,5.4,24ZM9,5a3,3,0,0,1,6,0V6H9ZM3.414,19.752l1.25-10A2,2,0,0,1,6.648,8H7v2a1,1,0,0,0,2,0V8h6v2a1,1,0,0,0,2,0V8h.352a2,2,0,0,1,1.984,1.752l1.25,10A2,2,0,0,1,18.6,22H5.4a2,2,0,0,1-1.984-2.248Z"></path></g></g>
                                        </svg>
                                    @endif
                                </div>
                                <span id="previewName" class="text-xl font-bold">{{ $settings['store_name'] }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-8 text-center">
                            <div class="text-base text-slate-500">Tampilan Logo pada Aplikasi</div>
                        </div>
                        <div class="mt-5 w-full flex flex-col items-center">
                            <!-- Top Menu Preview -->
                            <div class="w-full bg-slate-200 dark:bg-darkmode-400 rounded-md p-2 mb-5">
                                <div class="bg-white dark:bg-darkmode-600 rounded-md p-3 flex items-center">
                                    <div id="previewIconSmall" class="w-8 h-8 mr-2 flex items-center justify-center">
                                        @if($settings['store_icon'])
                                            <img src="{{ Storage::disk('s3')->url($settings['store_icon']) }}" alt="{{ $settings['store_name'] }}" class="max-w-full max-h-full object-contain">
                                        @else
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                <g><defs><style>.cls-1{fill:#f19b5f;}.cls-2{fill:#ffce69;}.cls-3{fill:#6c2e7c;}</style></defs>
                                                <g id="Icons"><path class="cls-1" d="M18.6,23H5.4a3,3,0,0,1-2.98-3.37l.39-3.13.86-6.87A3.01,3.01,0,0,1,6.65,7h10.7a3.01,3.01,0,0,1,2.98,2.63l.86,6.87.39,3.13A3,3,0,0,1,18.6,23Z"></path>
                                                <path class="cls-2" d="M21.19,16.5A2.976,2.976,0,0,1,18.6,18H5.4a2.976,2.976,0,0,1-2.59-1.5l.86-6.87A3.01,3.01,0,0,1,6.65,7h10.7a3.01,3.01,0,0,1,2.98,2.63Z"></path></g>
                                                <g data-name="Layer 4" id="Layer_4"><path class="cls-3" d="M5.4,24H18.6a4,4,0,0,0,3.968-4.5l-1.25-10A4.005,4.005,0,0,0,17.352,6H17V5A5,5,0,0,0,7,5V6H6.648A4.005,4.005,0,0,0,2.68,9.5l-1.25,10A4,4,0,0,0,5.4,24ZM9,5a3,3,0,0,1,6,0V6H9ZM3.414,19.752l1.25-10A2,2,0,0,1,6.648,8H7v2a1,1,0,0,0,2,0V8h6v2a1,1,0,0,0,2,0V8h.352a2,2,0,0,1,1.984,1.752l1.25,10A2,2,0,0,1,18.6,22H5.4a2,2,0,0,1-1.984-2.248Z"></path></g></g>
                                            </svg>
                                        @endif
                                    </div>
                                    <span id="previewNameSmall" class="text-base font-medium">{{ $settings['store_name'] }}</span>
                                    <div class="ml-auto flex space-x-2">
                                        <div class="w-8 h-5 bg-slate-200 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Preview -->
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for store name
        const storeNameInput = document.getElementById('store_name');
        const charCount = document.getElementById('charCount');
        const previewName = document.getElementById('previewName');
        const previewNameSmall = document.getElementById('previewNameSmall');
        
        // Set initial character count
        charCount.textContent = storeNameInput.value.length;
        
        // Update character count and preview on input
        storeNameInput.addEventListener('input', function() {
            charCount.textContent = this.value.length;
            previewName.textContent = this.value || 'Toko Budi';
            previewNameSmall.textContent = this.value || 'Toko Budi';
        });
        
        // File upload handling
        const fileInput = document.getElementById('store_icon');
        const dropzone = document.getElementById('dropzone');
        const imagePreview = document.getElementById('imagePreview');
        const currentImage = document.getElementById('currentImage');
        const newImagePreview = document.getElementById('newImagePreview');
        const newImage = newImagePreview.querySelector('img');
        const removeImageBtn = document.getElementById('removeImage');
        const removeNewImageBtn = document.getElementById('removeNewImage');
        const removeIconField = document.getElementById('remove_icon');
        const previewIcon = document.getElementById('previewIcon');
        const previewIconSmall = document.getElementById('previewIconSmall');
        
        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Check file size
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    return;
                }
                
                // Preview new image
                const reader = new FileReader();
                reader.onload = function(e) {
                    newImage.src = e.target.result;
                    
                    // Update all preview icons
                    updatePreviews(e.target.result);
                    
                    // Show new image preview, hide others
                    imagePreview.classList.add('hidden');
                    currentImage.classList.add('hidden');
                    newImagePreview.classList.remove('hidden');
                    removeIconField.value = '0';
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Handle drag and drop
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                this.classList.add('border-primary');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                this.classList.remove('border-primary');
            }, false);
        });
        
        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(event);
            }
        });
        
        // Remove current image
        removeImageBtn.addEventListener('click', function() {
            currentImage.classList.add('hidden');
            imagePreview.classList.remove('hidden');
            removeIconField.value = '1';
            
            // Update previews to default
            updatePreviews(null);
        });
        
        // Remove new image
        removeNewImageBtn.addEventListener('click', function() {
            newImagePreview.classList.add('hidden');
            fileInput.value = '';
            
            // If there's a current image, show it
            if ('{{ $settings["store_icon"] }}') {
                currentImage.classList.remove('hidden');
                updatePreviews('{{ Storage::disk('s3')->url($settings["store_icon"]) }}');
                removeIconField.value = '0';
            } else {
                imagePreview.classList.remove('hidden');
                updatePreviews(null);
            }
        });
        
        // Function to update all preview icons
        function updatePreviews(src) {
            const previewIcons = [previewIcon, previewIconSmall];
            
            previewIcons.forEach(preview => {
                // Clear existing content
                preview.innerHTML = '';
                
                if (src) {
                    // Create image element
                    const img = document.createElement('img');
                    img.src = src;
                    img.alt = storeNameInput.value || 'Toko Budi';
                    img.className = 'max-w-full max-h-full object-contain';
                    preview.appendChild(img);
                } else {
                    // Add default icon
                    preview.innerHTML = `
                        <svg width="${preview === previewIcon ? '48px' : '24px'}" height="${preview === previewIcon ? '48px' : '24px'}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                            <g><defs><style>.cls-1{fill:#f19b5f;}.cls-2{fill:#ffce69;}.cls-3{fill:#6c2e7c;}</style></defs>
                            <g id="Icons"><path class="cls-1" d="M18.6,23H5.4a3,3,0,0,1-2.98-3.37l.39-3.13.86-6.87A3.01,3.01,0,0,1,6.65,7h10.7a3.01,3.01,0,0,1,2.98,2.63l.86,6.87.39,3.13A3,3,0,0,1,18.6,23Z"></path>
                            <path class="cls-2" d="M21.19,16.5A2.976,2.976,0,0,1,18.6,18H5.4a2.976,2.976,0,0,1-2.59-1.5l.86-6.87A3.01,3.01,0,0,1,6.65,7h10.7a3.01,3.01,0,0,1,2.98,2.63Z"></path></g>
                            <g data-name="Layer 4" id="Layer_4"><path class="cls-3" d="M5.4,24H18.6a4,4,0,0,0,3.968-4.5l-1.25-10A4.005,4.005,0,0,0,17.352,6H17V5A5,5,0,0,0,7,5V6H6.648A4.005,4.005,0,0,0,2.68,9.5l-1.25,10A4,4,0,0,0,5.4,24ZM9,5a3,3,0,0,1,6,0V6H9ZM3.414,19.752l1.25-10A2,2,0,0,1,6.648,8H7v2a1,1,0,0,0,2,0V8h6v2a1,1,0,0,0,2,0V8h.352a2,2,0,0,1,1.984,1.752l1.25,10A2,2,0,0,1,18.6,22H5.4a2,2,0,0,1-1.984-2.248Z"></path></g></g>
                        </svg>
                    `;
                }
            });
        }
        
        // Reset button functionality
        document.getElementById('resetBtn').addEventListener('click', function() {
            // Reset store name to initial value and update preview
            storeNameInput.value = '{{ $settings["store_name"] }}';
            charCount.textContent = storeNameInput.value.length;
            previewName.textContent = storeNameInput.value;
            previewNameSmall.textContent = storeNameInput.value;
            
            // Reset file input
            fileInput.value = '';
            removeIconField.value = '0';
            
            // Reset image previews
            newImagePreview.classList.add('hidden');
            
            if ('{{ $settings["store_icon"] }}') {
                currentImage.classList.remove('hidden');
                imagePreview.classList.add('hidden');
                updatePreviews('{{ Storage::disk('s3')->url($settings["store_icon"]) }}');
            } else {
                imagePreview.classList.remove('hidden');
                currentImage.classList.add('hidden');
                updatePreviews(null);
            }
        });
        
        // Form submission
        const form = document.getElementById('settingsForm');
        const saveBtn = document.getElementById('saveBtn');
        
        form.addEventListener('submit', function(e) {
            // Disable button to prevent double submission
            saveBtn.disabled = true;
            saveBtn.classList.add('opacity-70', 'cursor-not-allowed');
            
            // Change button text to indicate loading
            saveBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';
        });
    });

    // Auto dismiss notification
    document.addEventListener('DOMContentLoaded', function() {
        const successNotification = document.getElementById('successNotification');
        if (successNotification) {
            // Auto dismiss after 5 seconds
            setTimeout(function() {
                closeNotification();
            }, 5000);
        }
    });
    
    // Close notification function
    function closeNotification() {
        const notification = document.getElementById('successNotification');
        notification.classList.remove('animate__fadeInDown');
        notification.classList.add('animate__fadeOutUp');
        
        // Remove from DOM after animation completes
        setTimeout(function() {
            notification.style.display = 'none';
        }, 500);
    }
</script>
@endpush 