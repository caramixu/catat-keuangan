<x-app-layout>
    <x-slot name="header">
        {{ __('Referensi Kategori') }}
    </x-slot>

    <div x-data="{
        openCategoryModal: {{ $errors->any() ? 'true' : 'false' }},
        openEditModal: false,
        editData: { id: '', nama_kategori: '', tipe: '' }
    }" class="py-6">
        @php
            function sortUrl($column, $currentSortBy, $currentSortOrder, $search, $perPage)
            {
                $order = $currentSortBy == $column && $currentSortOrder == 'asc' ? 'desc' : 'asc';
                return request()->fullUrlWithQuery([
                    'sort_by' => $column,
                    'sort_order' => $order,
                    'search' => $search,
                    'per_page' => $perPage,
                ]);
            }
        @endphp

        <div class="px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 shrink-0">
                <h2 class="text-2xl font-black text-slate-800"> Data Kategori</h2>
                <button @click="openCategoryModal = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition flex items-center gap-2 text-base w-full sm:w-auto md:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kategori
                </button>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.06)] rounded-xl border border-gray-100">
                <form method="GET" action="{{ route('categories.index') }}"
                    class="p-4 flex flex-col md:flex-row justify-between items-center border-b border-gray-100 gap-4">

                    <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                    <input type="hidden" name="sort_order" value="{{ $sortOrder }}">

                    <div class="flex items-center gap-2 text-gray-600 text-sm w-full md:w-auto">
                        <span>Tampilkan</span>
                        <select name="per_page" onchange="this.form.submit()"
                            class="border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 py-1 text-sm">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span>data</span>
                    </div>
                    {{-- Tombbol Cari --}}
                    {{-- <div class="flex items-center gap-2 text-gray-600 text-sm w-full md:w-auto">
                    <label for="search" class="font-medium">Cari:</label>
                    <input type="text" id="search" name="search" value="{{ $search }}"
                        placeholder="Tekan Enter..."
                        class="border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 py-1 px-3 text-sm w-full md:w-48 shadow-sm">
                </div> --}}
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-600 text-sm uppercase tracking-widest font-bold border-y border-gray-100">
                                {{-- Kolom No --}}
                                <th class="px-6 py-4 group">
                                    <a href="{{ sortUrl('id', $sortBy, $sortOrder, $search, $perPage) }}"
                                        class="flex items-center gap-1 hover:text-blue-600 transition">
                                        No
                                        <svg class="w-4 h-4 {{ $sortBy == 'id' ? 'text-blue-600' : 'text-gray-300 group-hover:text-blue-400' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $sortBy == 'id' && $sortOrder == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    </a>
                                </th>

                                {{-- Kolom Nama Kategori --}}
                                <th class="px-6 py-4 group">
                                    <a href="{{ sortUrl('nama_kategori', $sortBy, $sortOrder, $search, $perPage) }}"
                                        class="flex items-center gap-1 hover:text-blue-600 transition">
                                        Nama Kategori
                                        <svg class="w-4 h-4 {{ $sortBy == 'nama_kategori' ? 'text-blue-600' : 'text-gray-300 group-hover:text-blue-400' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $sortBy == 'nama_kategori' && $sortOrder == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    </a>
                                </th>

                                {{-- Kolom Tipe --}}
                                <th class="px-6 py-4 group">
                                    <a href="{{ sortUrl('tipe', $sortBy, $sortOrder, $search, $perPage) }}"
                                        class="flex items-center gap-1 hover:text-blue-600 transition">
                                        Tipe
                                        <svg class="w-4 h-4 {{ $sortBy == 'tipe' ? 'text-blue-600' : 'text-gray-300 group-hover:text-blue-400' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $sortBy == 'tipe' && $sortOrder == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    </a>
                                </th>

                                {{-- Kolom Deskripsi --}}
                                <th class="px-6 py-4 group"> Deskripsi </th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($categories as $index => $category)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4 text-base text-slate-700">
                                        {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 text-base font-semibold text-slate-800">
                                        {{ $category->nama_kategori }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($category->tipe == 'pemasukan')
                                            <span
                                                class="bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider">Pemasukan</span>
                                        @else
                                            <span
                                                class="bg-rose-100 text-rose-800 text-[10px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider">Pengeluaran</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 group">{{ $category->deskripsi ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <button type="button"
                                                @click="openEditModal = true; editData = { id: '{{ $category->id }}', nama_kategori: '{{ $category->nama_kategori }}', tipe: '{{ $category->tipe }}', deskripsi: '{{ $category->deskripsi }}' }"
                                                class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition"
                                                title="Edit">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button type="button" onclick="confirmDeleteCategory({{ $category->id }})"
                                                class="text-rose-600 hover:text-rose-900 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>

                                            <form id="delete-form-{{ $category->id }}"
                                                action="{{ route('categories.destroy', $category->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="page"
                                                    value="{{ $categories->currentPage() }}">
                                                <input type="hidden" name="per_page"
                                                    value="{{ $categories->perPage() }}">
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center h-full text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-base font-bold">Data kategori tidak ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($categories->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-slate-50 rounded-b-xl">
                        {{ $categories->appends(request()->query())->links() }}
                    </div>
                @endif

            </div>
        </div>

        <div x-show="openCategoryModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"
                @click="openCategoryModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">
                    <div class="bg-blue-600 p-6 text-white">
                        <h3 class="text-xl font-bold">Tambah Kategori Baru</h3>
                    </div>

                    <form action="{{ route('categories.store') }}" method="POST" x-ref="categoryForm"
                        class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-m font-medium text-gray-700 tracking-wider">Nama
                                Kategori</label>
                            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nama_kategori') border-rose-500 @enderror"
                                required>
                            @error('nama_kategori')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-m font-medium text-gray-700 tracking-wider">Tipe</label>
                            <select name="tipe"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-m font-medium text-gray-700 tracking-wider">Deskripsi
                                (Opsional)</label>
                            <textarea name="deskripsi" rows="2"
                                class="mt-1
                                block w-full rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" @click="openCategoryModal = false; $refs.categoryForm.reset()"
                                class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition">Batal</button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="openEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"
                @click="openEditModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">
                    <div class="bg-indigo-600 p-6 text-white">
                        <h3 class="text-xl font-bold">Edit Kategori</h3>
                    </div>

                    <form :action="`/categories/${editData.id}`" method="POST" class="p-6 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 tracking-wider">Nama
                                Kategori</label>
                            <input type="text" name="nama_kategori" x-model="editData.nama_kategori"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 tracking-wider">Tipe</label>
                            <select name="tipe" x-model="editData.tipe"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-m font-medium text-gray-700 tracking-wider">Deskripsi
                                (Opsional)</label>
                            <textarea name="deskripsi" rows="2" x-model="editData.deskripsi"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" @click="openEditModal = false"
                                class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition">Batal</button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDeleteCategory(id) {
                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: "Transaksi yang menggunakan kategori ini mungkin akan terpengaruh!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    border: 'none',
                    borderRadius: '1.25rem'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                })
            }

            // Notifikasi Sukses Tambah/Hapus
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    borderRadius: '1.25rem'
                });
            @endif
        </script>
</x-app-layout>
