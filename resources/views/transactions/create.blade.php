<x-app-layout>
    <x-slot name="header">
        Catat {{ ucfirst($type) }}
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="{{ $type == 'pemasukan' ? 'bg-emerald-500' : 'bg-rose-500' }} p-6 text-white">
                    <h3 class="text-xl font-bold">Tambah Transaksi Baru</h3>
                    <p class="text-white/80 text-sm">Silakan isi detail {{ $type }} kamu di bawah ini.</p>
                </div>

                <form action="{{ route('transactions.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nominal (Rp)</label>
                            <input type="number" min="1" name="amount" required
                                class="w-full text-2xl font-black rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 p-4 bg-gray-50"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="category_id" required
                                class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal</label>
                            <input type="date" max="{{ date('Y-m-d') }}" name="date" value="{{ date('Y-m-d') }}"
                                required
                                class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Keterangan (Opsional)</label>
                            <textarea name="description" rows="3"
                                class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Contoh: Beli makan siang di warteg"></textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}"
                            class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Batal</a>
                        <button type="submit"
                            class="{{ $type == 'pemasukan' ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-rose-500 hover:bg-rose-600' }} text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
