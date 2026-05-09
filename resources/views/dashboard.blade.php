<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 space-y-6">

        <div
            class="bg-white overflow-hidden shadow-[0_0_20px_rgba(0,0,0,0.07)] rounded-2xl flex flex-col md:flex-row items-center border border-gray-50 p-8 md:p-10 gap-8 md:gap-12">
            <div class="flex-1 w-full">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">
                    Selamat datang, <span class="text-rose-500">{{ Auth::user()->name }}</span> di OMJ!
                </h2>
                <p class="text-gray-600 mb-8 leading-relaxed block w-full">
                    Oh My Jajan (OMJ) membantu kamu mengelola setiap rupiah yang keluar dan masuk. Mulai catat
                    transaksi harianmu sekarang untuk masa depan finansial yang lebih tertata.
                </p>
                <div x-data="{ openModal: false, modalType: 'pemasukan', imagePreview: null }">
                    <div class="flex flex-wrap gap-4">
                        <button @click="openModal = true; modalType = 'pemasukan'" type="button"
                            class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-6 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.4)] transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Catat Pemasukan
                        </button>

                        <button @click="openModal = true; modalType = 'pengeluaran'" type="button"
                            class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-6 rounded-xl shadow-[0_0_15px_rgba(244,63,94,0.4)] transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                            Catat Pengeluaran
                        </button>
                    </div>

                    @include('transactions.partials.modal')
                </div>
            </div>

            <div class="shrink-0 flex justify-center md:justify-start">
                <img src="{{ asset('images/sapa.png') }}" alt="Dashboard Illustration"
                    class="h-48 w-auto object-contain">
            </div>
        </div>

        <h3 class="font-bold text-slate-800 uppercase tracking-wider text-sm mt-8">
            Ringkasan Keuangan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border-l-4 border-emerald-500 transform transition duration-200">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest text-emerald-600">Total Pemasukan
                </p>
                <p class="text-2xl font-black text-slate-900 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </p>
            </div>

            <div
                class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border-l-4 border-rose-500 transform transition duration-200">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest text-rose-600">Total Pengeluaran</p>
                <p class="text-2xl font-black text-slate-900 mt-1">Rp
                    {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </div>

            <div
                class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border-l-4 border-blue-500 transform transition duration-200">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest text-blue-600">Uang Dompet (Sisa)
                </p>
                <p class="text-2xl font-black text-slate-900 mt-1">Rp {{ number_format($uangDompet, 0, ',', '.') }}</p>
            </div>
        </div>

        <div
            class="mt-8 bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.06)] rounded-2xl border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-bold text-slate-800 uppercase tracking-wider text-lg"> Riwayat Transaksi </h3>
                <a href="{{ route('transactions.index', ['type' => 'pengeluaran']) }}"
                    class="text-blue-600 text-base font-semibold hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-sm uppercase tracking-widest font-bold">
                            <th class="px-6 py-5">Tanggal</th>
                            <th class="px-6 py-5">Kategori</th>
                            <th class="px-6 py-5">Keterangan</th>
                            <th class="px-6 py-5 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentTransactions as $trx)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-5 text-base text-slate-700 font-medium">
                                    {{ \Carbon\Carbon::parse($trx->date)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-6 py-5">
                                    @if ($trx->category)
                                        <span
                                            class="{{ $trx->category->tipe == 'pemasukan' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }} text-sm font-bold px-4 py-1.5 rounded-full">
                                            {{ $trx->category->nama_kategori }}
                                        </span>
                                    @else
                                        <span
                                            class="bg-gray-100 text-gray-800 text-sm font-bold px-4 py-1.5 rounded-full">
                                            Tidak Ada Kategori
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-base text-gray-600">
                                    {{ $trx->description }}
                                </td>
                                <td
                                    class="px-6 py-5 text-lg text-right font-black {{ ($trx->category?->tipe ?? 'pengeluaran') == 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ ($trx->category?->tipe ?? 'pengeluaran') == 'pemasukan' ? '+' : '-' }} Rp
                                    {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                    Belum ada transaksi terbaru. Ayo mulai mencatat!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
