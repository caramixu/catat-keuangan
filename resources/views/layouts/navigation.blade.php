<nav x-data="{ open: false }" :class="sidebarOpen ? 'ml-0' : '-ml-24 md:-ml-64'"
    class="w-24 md:w-64 h-screen bg-gradient-to-b from-blue-700 to-blue-900 text-white flex flex-col shadow-xl z-20 shrink-0 transition-[margin] duration-300 ease-in-out">
    <div
        class="p-2 md:p-6 h-16 flex items-center justify-center md:justify-start border-b border-white/10 bg-blue-800/50">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 md:gap-3 transition-transform duration-200">
            <img src="{{ asset('images/omj-logo.png') }}" class="h-8 md:h-10 w-auto bg-white rounded-md p-1" />

            <span class="hidden md:block">
                <img src="{{ asset('images/omj.png') }}" class="h-10 w-auto rounded-md" />
            </span>
        </a>
    </div>

    <div class="flex-1 px-2 md:px-4 space-y-2 py-6 overflow-y-auto">

        <a href="{{ route('dashboard') }}"
            class="flex flex-col md:flex-row items-center justify-center md:justify-start p-2 md:p-3 rounded-lg transition-all duration-200 
        {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-bold' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-6 h-6 md:w-5 md:h-5 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span
                class="text-[10px] md:text-sm uppercase md:capitalize whitespace-nowrap mt-1 md:mt-0 tracking-wider md:tracking-normal text-center">Dashboard</span>
        </a>

        <div x-data="{ open: {{ request()->routeIs('transactions.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex flex-col md:flex-row items-center justify-center md:justify-between p-2 md:p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('transactions.*') ? 'text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                <div class="flex flex-col md:flex-row items-center justify-center">
                    <svg class="w-6 h-6 md:w-5 md:h-5 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span
                        class="text-[10px] md:text-sm uppercase md:capitalize whitespace-nowrap mt-1 md:mt-0 tracking-wider md:tracking-normal text-center">Transaksi</span>
                </div>
                <svg :class="{ 'rotate-180': open }"
                    class="hidden md:block w-4 h-4 transition-transform duration-200 shrink-0" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition.origin.top class="md:ml-9 mt-1 space-y-1">
                <a href="{{ route('transactions.index', ['type' => 'pemasukan']) }}"
                    class="flex flex-col md:flex-row items-center justify-center md:justify-start p-2 {{ request()->fullUrlIs('*type=pemasukan*') ? 'text-white bg-white/20 font-bold' : 'text-blue-200 hover:text-white hover:bg-white/10' }} rounded-md transition-all duration-200 text-center">
                    <svg class="w-5 h-5 md:w-4 md:h-4 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span
                        class="text-[9px] md:text-sm uppercase md:capitalize whitespace-nowrap mt-1 md:mt-0">Pemasukan</span>
                </a>

                <a href="{{ route('transactions.index', ['type' => 'pengeluaran']) }}"
                    class="flex flex-col md:flex-row items-center justify-center md:justify-start p-2 {{ request()->fullUrlIs('*type=pengeluaran*') ? 'text-white bg-white/20 font-bold' : 'text-blue-200 hover:text-white hover:bg-white/10' }} rounded-md transition-all duration-200 text-center">
                    <svg class="w-5 h-5 md:w-4 md:h-4 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                    </svg>
                    <span
                        class="text-[9px] md:text-sm uppercase md:capitalize whitespace-nowrap mt-1 md:mt-0">Pengeluaran</span>
                </a>
            </div>
        </div>

        <a href="{{ route('categories.index') }}"
            class="flex flex-col md:flex-row items-center justify-center md:justify-start p-2 md:p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-white/10 text-white font-bold' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-6 h-6 md:w-5 md:h-5 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 7h.01M7 11h.01M7 15h.01M11 7h.01M11 11h.01M11 15h.01M15 7h.01M15 11h.01M15 15h.01" />
            </svg>
            <span
                class="text-[10px] md:text-sm uppercase md:capitalize whitespace-nowrap mt-1 md:mt-0 tracking-wider md:tracking-normal text-center">Referensi</span>
        </a>

        <a href="{{ route('reports.index') }}"
            class="flex flex-col md:flex-row items-center justify-center md:justify-start p-2 md:p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-white/10 text-white font-bold' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-6 h-6 md:w-5 md:h-5 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span
                class="text-[10px] md:text-sm uppercase md:capitalize whitespace-nowrap mt-1 md:mt-0 tracking-wider md:tracking-normal text-center">Laporan</span>
        </a>

        <a href="{{ route('info') }}"
            class="flex flex-col md:flex-row items-center justify-center md:justify-start p-2 md:p-3 rounded-lg transition-all duration-200 text-blue-100 hover:bg-white/10 hover:text-white">
            <svg class="w-6 h-6 md:w-5 md:h-5 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span
                class="text-[10px] md:text-sm uppercase md:capitalize whitespace-nowrap mt-1 md:mt-0 tracking-wider md:tracking-normal text-center">Info
                Aplikasi</span>
        </a>
    </div>
</nav>
