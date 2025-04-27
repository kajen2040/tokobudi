@extends('../../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Users</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium uppercase">Data Users</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center xl:flex-nowrap">
            <x-base.button
                class="mr-2 shadow-md text-white"
                variant="success"
                data-tw-toggle="modal"
                data-tw-target="#tambah-user-modal-preview"
            >
                TAMBAH
            </x-base.button>
            <div class="mx-auto hidden text-slate-500 xl:block">
                @if (session('success'))
                    <div class="text-green-600">{{ session('success') }}</div>
                @endif
            </div>
            <div class="mt-3 flex w-full items-center xl:mt-0 xl:w-auto">
                <form action="{{ route('users.index') }}" method="GET" class="relative w-56 text-slate-500">
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
                        <x-base.table.th class="whitespace-nowrap border-b-0 w-16">
                            No
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 w-60">
                            Nama
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Email
                        </x-base.table.th>
                        <!-- <x-base.table.th class="whitespace-nowrap border-b-0">
                            Role
                        </x-base.table.th> -->
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Tindakan
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($users as $key => $user)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 w-16"
                            >
                                {{ $users->firstItem() + $key }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 w-60"
                            >
                                {{ $user->name }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $user->email }}
                            </x-base.table.td>
                            <!-- <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $user->role }}
                            </x-base.table.td> -->
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">
                                    <a
                                        class="mr-3 flex items-center"
                                        href="#"
                                        data-tw-toggle="modal"
                                        data-tw-target="#edit-user-modal"
                                        onclick="openEditModal('{{ route('users.update', $user->id) }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')"
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
                                        onclick="openDeleteModal('{{ route('users.destroy', $user->id) }}')"
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
                @if ($users->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $users->url(1) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                    <x-base.pagination.link href="{{ $users->previousPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @endif

                @php
                    $start = max(1, $users->currentPage() - 2);
                    $end = min($start + 4, $users->lastPage());
                    $start = max(1, $end - 4);
                @endphp

                @if ($start > 1)
                    <x-base.pagination.link>...</x-base.pagination.link>
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    <x-base.pagination.link href="{{ $users->url($i) }}" :active="$i == $users->currentPage()">
                        {{ $i }}
                    </x-base.pagination.link>
                @endfor

                @if ($end < $users->lastPage())
                    <x-base.pagination.link>...</x-base.pagination.link>
                @endif

                @if ($users->hasMorePages())
                    <x-base.pagination.link href="{{ $users->nextPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                    <x-base.pagination.link href="{{ $users->url($users->lastPage()) }}">
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
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
            </div>
        </div>
        <!-- END: Pagination -->
    </div>

    <!-- BEGIN: Tambah User Modal -->
    <x-base.preview-component class="intro-y">
        <div class="p-5">
            <x-base.preview>
                <!-- BEGIN: Modal Content -->
                <x-base.dialog id="tambah-user-modal-preview" class="w-11/12 md:w-1/2 lg:w-1/3">
                    <x-base.dialog.panel>
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <x-base.dialog.title class="border-b border-slate-200/60">
                                <h2 class="mr-auto text-lg font-medium">
                                    Tambah User
                                </h2>
                            </x-base.dialog.title>
                       
                            <x-base.dialog.description class="p-5 grid grid-cols-12 gap-6">
                                <div class="col-span-12">
                                    <x-base.form-label for="name" class="text-base">Nama Lengkap</x-base.form-label>
                                    <x-base.form-input
                                        id="name"
                                        type="text"
                                        name="name"
                                        placeholder="Masukkan nama lengkap"
                                        value="{{ old('name') }}"
                                        class="@error('name') border-danger @enderror mt-2"
                                        required
                                    />
                                    @error('name')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-span-12">
                                    <x-base.form-label for="email" class="text-base">Email</x-base.form-label>
                                    <x-base.form-input
                                        id="email"
                                        type="email"
                                        name="email"
                                        placeholder="Masukkan email"
                                        value="{{ old('email') }}"
                                        class="@error('email') border-danger @enderror mt-2"
                                        required
                                    />
                                    @error('email')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-span-12">
                                    <x-base.form-label for="password" class="text-base">Password</x-base.form-label>
                                    <x-base.form-input
                                        id="password"
                                        type="password"
                                        name="password"
                                        placeholder="Masukkan password"
                                        class="@error('password') border-danger @enderror mt-2"
                                        required
                                    />
                                    @error('password')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-span-12">
                                    <x-base.form-label for="password_confirmation" class="text-base">Konfirmasi Password</x-base.form-label>
                                    <x-base.form-input
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        placeholder="Konfirmasi password"
                                        class="mt-2"
                                        required
                                    />
                                </div>
                            </x-base.dialog.description>

                            <x-base.dialog.footer class="border-t border-slate-200/60 p-5">
                                <div class="flex justify-end">
                                    <x-base.button
                                        class="mr-2 w-24"
                                        data-tw-dismiss="modal"
                                        type="button"
                                        variant="outline-secondary"
                                    >
                                        Batal
                                    </x-base.button>
                                    <x-base.button
                                        class="w-24"
                                        type="submit"
                                        variant="primary"
                                    >
                                        Simpan
                                    </x-base.button>
                                </div>
                            </x-base.dialog.footer>
                        </form>
                    </x-base.dialog.panel>
                </x-base.dialog>
                <!-- END: Modal Content -->
            </x-base.preview>
        </div>
    </x-base.preview-component>
    <!-- END: Tambah User Modal -->
    
    <!-- BEGIN: Edit User Modal -->
    <x-base.dialog id="edit-user-modal">
        <x-base.dialog.panel>
            <form id="edit-user-form" method="POST">
                @csrf
                @method('PUT')
                <x-base.dialog.title>
                    <h2 class="mr-auto text-base font-medium">Edit User</h2>
                </x-base.dialog.title>

                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="edit-name">Nama</x-base.form-label>
                        <x-base.form-input
                            id="edit-name"
                            type="text"
                            name="name"
                            placeholder="Masukkan nama"
                            required
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="edit-email">Email</x-base.form-label>
                        <x-base.form-input
                            id="edit-email"
                            type="email"
                            name="email"
                            placeholder="Masukkan email"
                            required
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="edit-password">Password (Kosongkan jika tidak ingin diubah)</x-base.form-label>
                        <x-base.form-input
                            id="edit-password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password baru"
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="edit-role">Role</x-base.form-label>
                        <x-base.form-select id="edit-role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </x-base.form-select>
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
    <!-- END: Edit User Modal -->

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
                    Apakah Anda yakin ingin menghapus data ini? <br />
                    Proses ini tidak dapat dibatalkan.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <x-base.button
                    class="mr-1 w-24"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Batal
                </x-base.button>
                <form id="delete-form" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
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
@endsection

@push('scripts')
<script>
    function openEditModal(url, name, email, role) {
        document.getElementById('edit-user-form').action = url;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-role').value = role;
    }

    function openDeleteModal(url) {
        document.getElementById('delete-form').action = url;
    }
</script>
@endpush