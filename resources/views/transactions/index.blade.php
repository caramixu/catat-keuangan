<x-app-layout>
    <x-slot name="header">
        Riwayat {{ ucfirst($type) }}
    </x-slot>

    <div x-data="{
        openModal: false,
        openDetailModal: false,
        detailImage: '',
        modalType: '{{ $type }}',
        imagePreview: null,
        editingTransactionCategoryId: ''
    }" class="py-6 px-4 sm:px-6 lg:px-8 w-full min-h-[calc(100vh-10rem)] flex flex-col">

        @php
            function sortUrl($column, $currentSortBy, $currentSortOrder, $type)
            {
                $order = $currentSortBy === $column && $currentSortOrder === 'asc' ? 'desc' : 'asc';
                return route('transactions.index', [
                    'type' => $type,
                    'sort_by' => $column,
                    'sort_order' => $order,
                    'per_page' => request('per_page', 10),
                ]);
            }
        @endphp

        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 shrink-0">
            <h2 class="text-2xl font-black text-slate-800">Data Transaksi {{ ucfirst($type) }}</h2>

            <button @click="openModal = true; imagePreview = null; $refs.transactionForm.reset()"
                class="w-full sm:w-auto {{ $type == 'pemasukan' ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-rose-500 hover:bg-rose-600' }} text-white font-bold py-2.5 px-6 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)] flex items-center justify-center gap-2 transition text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Catat {{ ucfirst($type) }}
            </button>
        </div>

        <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.06)] rounded-xl border border-gray-100">
            <form method="GET" action="{{ route('transactions.index') }}"
                class="p-4 flex flex-col md:flex-row justify-between items-center border-b border-gray-100 gap-4">

                <input type="hidden" name="type" value="{{ $type }}">

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
            </form>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left whitespace-nowrap">
                    <thead
                        class="bg-slate-50 text-slate-600 text-sm uppercase tracking-widest font-bold border-y border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-center w-16">No</th>

                            {{-- Kolom Tanggal --}}
                            <th class="px-6 py-4 group">
                                <a href="{{ sortUrl('date', $sortBy, $sortOrder, $perPage) }}"
                                    class="flex items-center gap-1 hover:text-blue-600 transition">
                                    TANGGAL
                                    <svg class="w-4 h-4 {{ $sortBy == 'date' ? 'text-blue-500' : 'text-gray-300 group-hover:text-blue-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $sortBy == 'date' && $sortOrder == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                    </svg>
                                </a>
                            </th>

                            <th class="px-6 py-4">KATEGORI</th>
                            <th class="px-6 py-4 max-w-xs">DESKRIPSI</th>

                            {{-- Kolom Jumlah --}}
                            <th class="px-6 py-4 group text-right">
                                <a href="{{ sortUrl('amount', $sortBy, $sortOrder, $perPage) }}"
                                    class="flex items-center justify-end gap-1 hover:text-blue-600 transition">
                                    JUMLAH
                                    <svg class="w-4 h-4 {{ $sortBy == 'amount' ? 'text-blue-500' : 'text-gray-300 group-hover:text-blue-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $sortBy == 'amount' && $sortOrder == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                    </svg>
                                </a>
                            </th>

                            <th class="px-6 py-4 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $index => $trx)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center text-gray-500 text-base font-medium">
                                    {{ $transactions->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 text-slate-700 font-medium text-base">
                                    {{ \Carbon\Carbon::parse($trx->date)->translatedFormat('d F Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="bg-slate-100 text-slate-600 text-sm font-bold px-3 py-1 rounded-full">
                                        {{ $trx->category->nama_kategori ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 max-w-xs truncate">
                                    {{ $trx->description }}
                                </td>

                                <td
                                    class="px-6 py-4 text-right text-xl font-black {{ $type == 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $type == 'pemasukan' ? '+' : '-' }} Rp
                                    {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4" x-data="{ openEditModal: false }">
                                    <div class="flex items-center justify-center gap-2">
                                        @if ($type == 'pengeluaran')
                                            <button @click=openDetailModal=true;
                                                detailImage = '{{ $trx->proof ? asset('storage/' . $trx->proof) : '' }}'; "
                                                class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg transition"
                                                title="Detail">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d=" M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            </button>
                                        @endif

                                        <button type="button"
                                            @click="openEditModal = true; 
                                                                    modalType = '{{ $trx->type == 'income' ? 'pemasukan' : 'pengeluaran' }}';
                                                                    editingTransactionCategoryId = '{{ $trx->category_id }}';"
                                            class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <button type="button" onclick="confirmDelete('{{ $trx->id }}')"
                                            class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <form id="delete-form-{{ $trx->id }}"
                                            action="{{ route('transactions.destroy', $trx->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="page"
                                                value="{{ $transactions->currentPage() }}">
                                            <input type="hidden" name="per_page"
                                                value="{{ request('per_page', 10) }}">
                                        </form>
                                    </div>

                                    <template x-teleport="body">
                                        <div x-show="openEditModal" x-data="{ editPreview: '{{ $trx->proof ? asset('storage/' . $trx->proof) : '' }}' }"
                                            class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-900/50 backdrop-blur-sm"
                                            style="display: none;">
                                            <div @click.away="openEditModal = false"
                                                class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden">
                                                <div
                                                    class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-slate-50">
                                                    <h3 class="text-lg font-bold text-slate-800">Edit
                                                        {{ ucfirst($type) }}</h3>
                                                    <button @click="openEditModal = false" type="button"
                                                        class="text-gray-400 hover:text-rose-500 transition">
                                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <form action="{{ route('transactions.update', $trx->id) }}"
                                                    method="POST" enctype="multipart/form-data"
                                                    x-ref="editForm{{ $trx->id }}"
                                                    class="p-6 space-y-4 text-left">
                                                    @csrf
                                                    @method('PUT')
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1 text-base">Tanggal</label>
                                                        <input type="date" name="date"
                                                            max="{{ date('Y-m-d') }}" required
                                                            class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 cursor-pointer invalid:cursor-not-allowed"
                                                            value="{{ \Carbon\Carbon::parse($trx->date)->format('Y-m-d') }}">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1 text-base">Kategori</label>
                                                        <select name="category_id" required
                                                            class="w-full rounded-xl border-gray-300 text-base">
                                                            @foreach ($categories as $cat)
                                                                <template x-if="modalType === '{{ $cat->tipe }}'">
                                                                    <option value="{{ $cat->id }}"
                                                                        :selected="editingTransactionCategoryId ==
                                                                            {{ $cat->id }}">
                                                                        {{ $cat->nama_kategori }}
                                                                    </option>
                                                                </template>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1 text-base">Deskripsi</label>
                                                        <textarea name="description" required rows="2" class="w-full rounded-xl border-gray-300 text-base">{{ $trx->description }}</textarea>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1 text-base">Nominal
                                                            (Rp)
                                                        </label>
                                                        <input type="number" name="amount"
                                                            value="{{ $trx->amount }}" required
                                                            class="w-full rounded-xl border-gray-300 text-base">
                                                    </div>
                                                    @if ($type == 'pengeluaran')
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2 text-base">Ubah
                                                                Bukti Transaksi</label>
                                                            <div
                                                                class="border border-gray-300 rounded-lg p-1 mb-4 bg-white">
                                                                <input type="file" name="proof"
                                                                    accept=".jpg,.png,image/jpeg,image/png"
                                                                    @change="editPreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : editPreview"
                                                                    class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded file:text-sm file:bg-gray-100 hover:file:bg-gray-200 cursor-pointer">
                                                            </div>

                                                            <div
                                                                class="mt-3 border border-gray-200 rounded-lg w-40 h-40 flex items-center justify-center bg-gray-50 overflow-hidden relative mx-auto">
                                                                <template x-if="editPreview">
                                                                    <img :src="editPreview"
                                                                        class="w-full h-full object-contain">
                                                                </template>
                                                                <template x-if="!editPreview">
                                                                    <span class="text-xs text-gray-400">NO IMAGE</span>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="flex justify-end gap-3 pt-4 border-t">
                                                        <button type="button"
                                                            @click="openEditModal = false; $refs['editForm' + {{ $trx->id }}].reset(); editPreview = '{{ $trx->proof ? asset('storage/' . $trx->proof) : '' }}'"
                                                            class="px-6 py-2 text-gray-600 bg-gray-100 rounded-xl text-base font-medium">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold text-base shadow-lg shadow-blue-200">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </template>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center h-full text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-base font-bold">Belum ada data {{ $type }}.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transactions->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-slate-50/50">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>

        @include('transactions.partials.modal')

        <div x-show="openDetailModal" class="fixed inset-0 z-[110] overflow-y-auto" x-cloak style="display: none;">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openDetailModal = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div
                    class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800">Bukti Transaksi</h3>
                        <button @click="openDetailModal = false" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-6 flex flex-col items-center">
                        <template x-if="detailImage">
                            <div class="w-full flex flex-col items-center">
                                <div
                                    class="border border-gray-200 rounded-2xl overflow-hidden bg-gray-50 shadow-inner">
                                    <img :src="detailImage" class="max-w-full max-h-[70vh] object-contain"
                                        alt="Bukti Transaksi">
                                </div>
                                <a :href="detailImage" download
                                    class="mt-4 inline-flex items-center text-base text-blue-600 hover:underline font-bold">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Unduh Gambar
                                </a>
                            </div>
                        </template>
                        <template x-if="!detailImage">
                            <div class="py-12 text-center text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-lg font-medium">Tidak ada bukti foto.</p>
                            </div>
                        </template>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 text-right">
                        <button @click="openDetailModal = false"
                            class="px-8 py-2 bg-gray-800 text-white rounded-xl font-bold hover:bg-gray-900 transition shadow-md">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Transaksi?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48', // Warna Rose
                cancelButtonColor: '#64748b', // Warna Slate
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mencari form berdasarkan ID unik yang dikirim oleh tombol
                    const form = document.getElementById('delete-form-' + id);
                    if (form) {
                        form.submit();
                    }
                }
            })
        }
    </script>

</x-app-layout>
