<x-app-layout>
    <x-slot name="header">
        {{ __('Tambah Kategori Baru') }}
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="w-full">

            <div class="mb-4">
                <a href="{{ route('categories.index') }}"
                    class="text-blue-600 hover:text-blue-800 flex items-center gap-2 font-semibold text-sm transition w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.06)] rounded-xl border border-gray-100">

                <div class="p-5 border-b border-gray-100 bg-slate-50 flex items-center">
                    <h3 class="font-bold text-slate-700 uppercase tracking-wider text-sm">Form Input Kategori</h3>
                </div>

                <form action="{{ route('categories.store') }}" method="POST" class="px-6 pb-6 space-y-5">
                    @csrf

                    <div>
                        <label for="nama_kategori"
                            class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Nama
                            Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori"
                            placeholder="Contoh: Makanan, Gaji, Hobi..." value="{{ old('nama_kategori') }}"
                            class="w-full px-4 py-2.5 rounded-lg border-gray-200 focus:ring-blue-500 focus:border-blue-500 bg-white transition text-sm shadow-sm
                            @error('nama_kategori') border-rose-500 ring-rose-500 @enderror"
                            value="{{ old('nama_kategori') }}" required>
                        @error('nama_kategori')
                            <span class="text-rose-600 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Tipe</label>
                        <div class="flex flex-col gap-3">
                            <label
                                class="relative flex items-center p-3 border rounded-lg cursor-pointer hover:bg-emerald-50 transition border-gray-200 group">
                                <input type="radio" name="tipe" value="pemasukan"
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500" required>
                                <span
                                    class="ml-3 text-sm font-medium text-slate-700 group-hover:text-emerald-700">Pemasukan</span>
                            </label>

                            <label
                                class="relative flex items-center p-3 border rounded-lg cursor-pointer hover:bg-rose-50 transition border-gray-200 group">
                                <input type="radio" name="tipe" value="pengeluaran"
                                    class="w-4 h-4 text-rose-600 border-gray-300 focus:ring-rose-500" required>
                                <span
                                    class="ml-3 text-sm font-medium text-slate-700 group-hover:text-rose-700">Pengeluaran</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition duration-200 text-sm tracking-wide">
                            SIMPAN KATEGORI
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
