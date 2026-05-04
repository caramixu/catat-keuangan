<x-guest-layout>
    <div class="bg-white p-8 md:p-10 rounded-2xl shadow-2xl w-full max-w-md">

        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-3 mb-1">
                <img src="{{ asset('images/omj-logo.png') }}" alt="Logo" class="h-10 w-auto">
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 uppercase">
                    OH MY <span class="text-rose-500">JAJAN</span>
                </h1>
            </div>
            <p class="mt-5 text-gray-500 text-sm font-medium">Buat akun baru untuk mulai mencatat</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block font-semibold text-sm text-gray-700 mb-1">Nama Lengkap</label>
                <input id="name"
                    class="block w-full border-gray-300 focus:border-rose-500 focus:ring-rose-500 rounded-lg shadow-sm"
                    type="text" name="name" :value="old('name')" required autofocus
                    placeholder="Masukkan nama..." />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">Email</label>
                <input id="email"
                    class="block w-full border-gray-300 focus:border-rose-500 focus:ring-rose-500 rounded-lg shadow-sm"
                    type="email" name="email" :value="old('email')" required placeholder="email@contoh.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div x-data="{ show: false }">
                <label for="password" class="block font-semibold text-sm text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input id="password"
                        class="block w-full border-gray-300 focus:border-rose-500 focus:ring-rose-500 rounded-lg shadow-sm pr-10"
                        :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                        placeholder="••••••••" />

                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-rose-500 focus:outline-none">
                        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.55-3.159m4.89-2.02A3.001 3.001 0 0115 12m-3 0a3.001 3.001 0 00-3-3m-1.5 6.5a3 3 0 00-3-3m0 0l-3-3m3 3l3 3" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div x-data="{ show: false }">
                <label for="password_confirmation" class="block font-semibold text-sm text-gray-700 mb-1">Konfirmasi
                    Password</label>
                <div class="relative">
                    <input id="password_confirmation"
                        class="block w-full border-gray-300 focus:border-rose-500 focus:ring-rose-500 rounded-lg shadow-sm pr-10"
                        :type="show ? 'text' : 'password'" name="password_confirmation" required
                        autocomplete="new-password" placeholder="••••••••" />

                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-rose-500 focus:outline-none">
                        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.55-3.159m4.89-2.02A3.001 3.001 0 0115 12m-3 0a3.001 3.001 0 00-3-3m-1.5 6.5a3 3 0 00-3-3m0 0l-3-3m3 3l3 3" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <div class="flex flex-col gap-3 mt-8">
                <button type="submit"
                    class="w-full bg-slate-900 text-white font-bold py-3 rounded-lg shadow-lg hover:bg-slate-800 transition uppercase tracking-widest text-sm">
                    Daftar Sekarang
                </button>

                <p class="text-center text-sm text-gray-600 mt-2">
                    Sudah punya akun?
                    <a class="text-rose-600 hover:text-rose-700 font-bold underline transition"
                        href="{{ route('login') }}">
                        Log in di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
