<x-app-layout>
    <x-slot name="header">
        Laporan Keuangan
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 w-full min-h-[calc(100vh-10rem)] flex flex-col space-y-6"
        x-data="{ activeTab: 'arus_kas' }">

        <div
            class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">

            <form action="{{ route('reports.index') }}" method="GET"
                class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">

                <div class="flex gap-3 w-full sm:w-auto">
                    <select name="month"
                        class="rounded-xl border-gray-300 text-sm font-medium focus:ring-blue-500 flex-1">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                {{ $month == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>

                    <select name="year"
                        class="rounded-xl border-gray-300 text-sm font-medium focus:ring-blue-500 flex-1">
                        @for ($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-md w-full sm:w-auto">
                    Lihat
                </button>
            </form>

            <div class="w-full md:w-auto">
                <a href="{{ route('reports.pdf', ['month' => $month, 'year' => $year]) }}" target="_blank"
                    class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-6 rounded-xl flex items-center justify-center gap-2 transition w-full md:w-auto shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Laporan
                </a>
            </div>
        </div>

        <div class="flex space-x-2 overflow-x-auto bg-slate-200/50 p-1.5 rounded-2xl">
            <button @click="activeTab = 'arus_kas'"
                :class="activeTab === 'arus_kas' ? 'bg-white shadow-sm text-blue-600 font-bold' :
                    'text-slate-600 font-medium hover:bg-white/50'"
                class="flex-1 py-2.5 px-4 rounded-xl text-sm transition-all whitespace-nowrap">
                Ringkasan Arus Kas
            </button>
            <button @click="activeTab = 'pemasukan'"
                :class="activeTab === 'pemasukan' ? 'bg-white shadow-sm text-emerald-600 font-bold' :
                    'text-slate-600 font-medium hover:bg-white/50'"
                class="flex-1 py-2.5 px-4 rounded-xl text-sm transition-all whitespace-nowrap">
                Laporan Pemasukan
            </button>
            <button @click="activeTab = 'pengeluaran'"
                :class="activeTab === 'pengeluaran' ? 'bg-white shadow-sm text-rose-600 font-bold' :
                    'text-slate-600 font-medium hover:bg-white/50'"
                class="flex-1 py-2.5 px-4 rounded-xl text-sm transition-all whitespace-nowrap">
                Laporan Pengeluaran
            </button>
        </div>

        <div x-show="activeTab === 'arus_kas'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 flex flex-col justify-center items-center text-center">
                    <div
                        class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Total Pemasukan</p>
                    <p class="text-3xl font-black text-emerald-600 mt-1">Rp
                        {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-rose-100 flex flex-col justify-center items-center text-center">
                    <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Total Pengeluaran</p>
                    <p class="text-3xl font-black text-rose-600 mt-1">Rp
                        {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border {{ $arusKas >= 0 ? 'border-blue-100' : 'border-rose-100' }} flex flex-col justify-center items-center text-center">
                    <div
                        class="w-12 h-12 {{ $arusKas >= 0 ? 'bg-blue-100 text-blue-600' : 'bg-rose-100 text-rose-600' }} rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                            </path>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Arus Kas Bersih</p>
                    <p class="text-3xl font-black {{ $arusKas >= 0 ? 'text-blue-600' : 'text-rose-600' }} mt-1">
                        {{ $arusKas < 0 ? '-' : '' }}Rp {{ number_format(abs($arusKas), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'pemasukan'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
            <div
                class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead
                            class="bg-emerald-50 text-emerald-800 text-sm uppercase tracking-widest font-bold border-b border-emerald-100">
                            <tr>
                                <th class="px-6 py-4 w-16 text-center">No</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Keterangan</th>
                                <th class="px-6 py-4 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pemasukan as $index => $trx)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-center text-gray-500 text-base font-medium">
                                        {{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-slate-700 font-medium text-base">
                                        {{ \Carbon\Carbon::parse($trx->date)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                                        {{ $trx->category->nama_kategori ?? 'Tanpa Kategori' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-base">{{ $trx->description }}</td>
                                    <td class="px-6 py-4 text-right text-lg font-black text-emerald-600">Rp
                                        {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400 font-medium">Tidak
                                        ada
                                        data pemasukan di bulan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-slate-50 border-t-2 border-emerald-200">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right font-bold text-slate-700 text-lg">Total
                                    Pemasukan:</td>
                                <td class="px-6 py-4 text-right font-black text-xl text-emerald-600">Rp
                                    {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'pengeluaran'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
            <div
                class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead
                            class="bg-rose-50 text-rose-800 text-sm uppercase tracking-widest font-bold border-b border-rose-100">
                            <tr>
                                <th class="px-6 py-4 w-16 text-center">No</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Keterangan</th>
                                <th class="px-6 py-4 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pengeluaran as $index => $trx)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-center text-gray-500 text-base font-medium">
                                        {{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-slate-700 font-medium text-base">
                                        {{ \Carbon\Carbon::parse($trx->date)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                                        {{ $trx->category->nama_kategori ?? 'Tanpa Kategori' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-base">{{ $trx->description }}</td>
                                    <td class="px-6 py-4 text-right text-lg font-black text-rose-600">Rp
                                        {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400 font-medium">Tidak
                                        ada data pengeluaran di bulan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-slate-50 border-t-2 border-rose-200">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right font-bold text-slate-700 text-lg">Total
                                    Pengeluaran:</td>
                                <td class="px-6 py-4 text-right font-black text-xl text-rose-600">Rp
                                    {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
