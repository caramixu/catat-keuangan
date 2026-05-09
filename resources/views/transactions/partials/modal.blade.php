<div x-show="openModal" x-transition.opacity.duration.10ms class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" x-show="openModal" x-transition.opacity
        @click="openModal = false"></div>

    <div class="flex min-h-full items-center justify-center p-4" x-show="openModal" x-transition.scale.origin.bottom>
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden border border-gray-100">

            <!-- Header Modal Dinamis -->
            <div :class="modalType === 'pemasukan' ? 'bg-emerald-500' : 'bg-rose-500'"
                class="p-6 text-white flex justify-between items-center">
                <h3 class="text-xl font-bold"
                    x-text="'Catat ' + modalType.charAt(0).toUpperCase() + modalType.slice(1)"></h3>
                <button @click="openModal = false; imagePreview = null; $refs.proofInput.value = '';" type="button"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data"
                x-ref="transactionForm" class="p-6 pt-0 space-y-4 text-left">
                @csrf
                <input type="hidden" name="type" :value="modalType">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nominal (Rp)</label>
                    <input type="number" min="1" name="amount" required
                        class="w-full rounded-xl border-gray-200 focus:ring-blue-500 p-3 bg-gray-50 text-xl font-bold"
                        placeholder="0">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" required class="w-full rounded-xl border-gray-200 focus:ring-blue-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <!-- Hanya tampilkan kategori yang sesuai dengan tipe modal (hijau/merah) -->
                            <template x-if="modalType === '{{ $cat->tipe }}'">
                                <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                            </template>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="date" max="{{ date('Y-m-d') }}" required
                            class="w-full rounded-xl border-gray-200 focus:ring-blue-500 limit-date"
                            value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="2" required class="w-full rounded-xl border-gray-200 focus:ring-blue-500"
                        placeholder="Keterangan transaksi..."></textarea>
                </div>

                <div x-show="modalType === 'pengeluaran'" x-data="{ imagePreview: null }"
                    x-effect="if (!openModal) { imagePreview = null; if($refs.proofInput) $refs.proofInput.value = ''; }"
                    class="w-full mt-4">

                    <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Transaksi</label>

                    <div class="border border-gray-300 rounded-lg p-1 mb-4 bg-white">
                        <input type="file" name="proof" x-ref="proofInput" accept=".jpg,.png,image/jpeg,image/png"
                            @change="imagePreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null"
                            class="w-full text-sm text-gray-700 
                                   file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded 
                                   file:text-sm file:font-normal file:bg-gray-100 file:text-gray-700 
                                   hover:file:bg-gray-200 cursor-pointer">
                    </div>

                    <div
                        class="border border-gray-200 rounded-lg w-40 h-40 sm:w-48 sm:h-48 flex items-center justify-center bg-gray-50 overflow-hidden relative">

                        <div x-show="!imagePreview" class="text-center text-gray-400 flex flex-col items-center">
                            <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-xs font-bold tracking-widest uppercase">NO IMAGE</span>
                        </div>

                        <img x-show="imagePreview" :src="imagePreview" class="w-full h-full object-contain"
                            style="display: none;" alt="Preview Bukti Transaksi">
                    </div>

                    <div class="mt-4 text-xs text-gray-500 space-y-1">
                        <p>*Ukuran file yang bisa diunggah maksimal 2 Mb.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    {{-- Tombol Batal --}}
                    <button type="button" @click="openModal = false"
                        class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition text-sm">
                        Batal
                    </button>
                    {{-- Tombol Simpan --}}
                    <button type="submit"
                        :class="modalType === 'pemasukan' ? 'bg-emerald-500 hover:bg-emerald-600' :
                            'bg-rose-500 hover:bg-rose-600'"
                        class="px-6 py-2.5 text-white font-bold rounded-xl shadow-lg transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
