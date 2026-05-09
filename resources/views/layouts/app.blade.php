<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OMJ - Catat Keuangan') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        input[type="date"].limit-date:invalid {
            cursor: not-allowed !important;
            border-color: #f43f5e !important;
            background-color: #fff1f2 !important;
        }

        input[type="date"].limit-date::-webkit-calendar-picker-indicator {
            cursor: pointer;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900 overflow-hidden" x-data="{ sidebarOpen: true, isFullscreen: false }"
    @fullscreenchange.window="isFullscreen = !!document.fullscreenElement">

    <div class="h-screen flex overflow-hidden">

        @include('layouts.navigation')

        <div class="flex-1 flex flex-col h-full overflow-y-auto overflow-x-hidden relative scroll-smooth">

            <header
                class="sticky top-0 bg-white h-16 shadow z-30 border-b border-gray-100 flex items-center justify-between px-4 sm:px-8 shrink-0">

                <div class="flex items-center gap-3 sm:gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-blue-600 focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <h2 class="font-bold text-lg sm:text-xl text-slate-800 leading-tight">
                        {{ $header ?? 'Halaman Tidak Diketahui' }}
                    </h2>
                </div>

                <div class="flex items-center gap-2 sm:gap-5">

                    <button
                        @click="!document.fullscreenElement ? document.documentElement.requestFullscreen() : document.exitFullscreen()"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-blue-600 focus:outline-none transition-colors"
                        title="Toggle Fullscreen">

                        <svg x-show="!isFullscreen" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>

                        <svg x-show="isFullscreen" style="display: none;" class="w-5 h-5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center gap-2 px-2 sm:px-3 py-1.5 border border-gray-200 rounded-full hover:bg-gray-50 transition">
                                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6366f1&color=fff' }}"
                                    class="w-8 h-8 rounded-full object-cover border border-slate-200">
                                <span
                                    class="hidden sm:block text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-4 w-4 text-gray-400 hidden sm:block" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-rose-600 font-medium">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <main class="flex-1 w-full">
                {{ $slot }}
            </main>

            <footer
                class="bg-white h-16 flex items-center justify-center px-4 sm:px-8 text-xs sm:text-sm text-gray-400 shrink-0 mt-auto">
                <div class="text-center">
                    Copyright &copy; {{ date('Y') }} - <span
                        class="font-semibold text-slate-600 uppercase tracking-tight">Oh My </span><span
                        class="text-rose-400 font-semibold">JAJAN</span> By CARAMIXU
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Notifikasi sukses (Toast) jika ada session success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    </script>
</body>

</html>
