<x-app-layout>
    <x-slot name="header">
        Info Aplikasi
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 w-full max-w-7xl0 mx-auto space-y-6">
        <div
            class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 md:p-9 flex flex-col items-center gap-8 transition-all hover:shadow-lg text-center">
            <div class="w-full max-w-xl flex items-center justify-center p-1  rounded-2xl">
                <img src="{{ asset('images/omj-logo.png') }}" alt="OMJ Logo" class="w-24 h-24 rounded-xl object-contain">
            </div>
            <div class="w-full max-w-xl flex items-center justify-center p-1  rounded-2xl">
                <img src="{{ asset('images/omj.png') }}" alt="OMJ Logo" class="w-72 h-auto rounded-xl object-contain">
            </div>

            <div class="max-w-3xl mx-auto">
                <div
                    class="inline-flex items-center justify-center gap-2 bg-blue-50 text-blue-700 px-4 py-1.5 rounded-full text-sm font-bold mb-4 border border-blue-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Versi 1.0.0 (Beta)
                </div>
                <p class="text-gray-600 leading-relaxed text-base md:text-lg">
                    OMJ adalah aplikasi pencatatan keuangan pribadi yang dirancang khusus untuk membantumu melacak
                    setiap arus kas. Dengan antarmuka yang simpel dan ramah pengguna, OMJ memastikan kamu memiliki
                    kendali penuh atas kondisi finansialmu setiap saat demi mencapai tujuan keuangan yang diimpikan.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8">
                <h3 class="text-xl font-black text-slate-800 mb-6 flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    Fitur Unggulan
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div
                            class="w-6 h-6 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 mt-0.5">
                            <span class="text-xs font-bold">1</span>
                        </div>
                        <p class="text-gray-600 text-base"><strong class="text-slate-800">Pencatatan Cepat:</strong>
                            Catat pemasukan dan pengeluaran secara <i>real-time</i> dengan mudah.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <div
                            class="w-6 h-6 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 mt-0.5">
                            <span class="text-xs font-bold">2</span>
                        </div>
                        <p class="text-gray-600 text-base"><strong class="text-slate-800">Manajemen Kategori:</strong>
                            Buat kategori transaksi tanpa batas sesuai kebutuhanmu.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <div
                            class="w-6 h-6 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 mt-0.5">
                            <span class="text-xs font-bold">3</span>
                        </div>
                        <p class="text-gray-600 text-base"><strong class="text-slate-800">Dashboard Interaktif:</strong>
                            Pantau saldo dompet dan transaksi terakhir dalam satu lirikan.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <div
                            class="w-6 h-6 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 mt-0.5">
                            <span class="text-xs font-bold">4</span>
                        </div>
                        <p class="text-gray-600 text-base"><strong class="text-slate-800">Laporan Detail:</strong>
                            Filter riwayat arus kas per bulan dan tahun dengan akurat.</p>
                    </li>
                </ul>
            </div>

            <div
                class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 flex flex-col">
                <h3 class="text-xl font-black text-slate-800 mb-6 flex items-center gap-3">
                    <div class="p-2 bg-rose-100 text-rose-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    Dibangun Menggunakan
                </h3>

                <div class="flex flex-wrap gap-3 mb-6">
                    <span
                        class="px-4 py-2 bg-red-50 text-red-600 border border-red-100 rounded-xl text-sm font-bold flex items-center gap-2">
                        Laravel 12
                    </span>
                    <span
                        class="px-4 py-2 bg-sky-50 text-sky-600 border border-sky-100 rounded-xl text-sm font-bold flex items-center gap-2">
                        VSCode
                    </span>
                    <span
                        class="px-4 py-2 bg-sky-50 text-sky-600 border border-sky-100 rounded-xl text-sm font-bold flex items-center gap-2">
                        Tailwind CSS
                    </span>
                    <span
                        class="px-4 py-2 bg-teal-50 text-teal-600 border border-teal-100 rounded-xl text-sm font-bold flex items-center gap-2">
                        Alpine.js
                    </span>
                    <span
                        class="px-4 py-2 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-xl text-sm font-bold flex items-center gap-2">
                        PostgreSQL
                    </span>
                </div>

                <div class="mt-auto bg-slate-50 p-5 rounded-2xl border border-slate-100">
                    <h4 class="text-sm font-bold text-slate-800 mb-1">Developer Note:</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Aplikasi ini dibuat dengan sepenuh hati ❤️
                    </p>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
