<x-guest-layout>
    <div class="flex flex-col md:flex-row bg-white rounded-xl shadow-2xl overflow-hidden max-w-5xl w-full">

        <div class="hidden md:flex md:w-1/2 bg-gray-50 items-center justify-center">
            <img src="{{ asset('images/Guest-OMJ.png') }}" alt="Ilustrasi" class="w-full h-auto object-contain">
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12">
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-3 mb-1">
                    <img src="{{ asset('images/omj-logo.png') }}" alt="Logo" class="h-12 w-auto">

                    <h1 class="text-3xl font-extrabold tracking-tight flex items-center">
                        <span class="text-slate-900 uppercase">OH MY</span>
                        <span class="text-rose-500 uppercase ml-2">JAJAN</span>
                    </h1>
                </div>

                <p class="mt-5 text-gray-500 text-sm font-medium tracking-wide">Aplikasi Catat Keuanganmu</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="block mt-1 w-full rounded-2xl border-slate-200 shadow-sm transition-all py-3 
                        @error('email') border-rose-500 focus:ring-rose-500/10 @else focus:ring-indigo-500/10 focus:border-indigo-500 @enderror">

                    @error('email')
                        <p class="text-[10px] text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label
                        class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
                    <input id="password" type="password" name="password" required x-init="@if ($errors->has('password')) $el.focus() @endif"
                        class="block mt-1 w-full rounded-2xl border-slate-200 shadow-sm transition-all py-3 
                        @error('password') border-rose-500 focus:ring-rose-500/10 @else focus:ring-indigo-500/10 focus:border-indigo-500 @enderror">

                    @error('password')
                        <p class="text-[10px] text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="rounded border-gray-300 text-blue-600 shadow-sm">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('register') }}"
                        class="text-sm font-bold text-white border-2 border-gray-200 px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-600 transition">
                        DAFTAR AKUN
                    </a>
                    <button type="submit"
                        class="bg-blue-600 text-white font-bold text-sm px-6 py-2 rounded-lg hover:bg-blue-800 transition shadow-md">
                        LOG IN
                    </button>
                </div>

                <div class="mt-20 text-center">
                    <p class="text-xs text-gray-400 font-medium">
                        Copyright &copy; {{ date('Y') }} - <span class="text-rose-400 uppercase">Oh My Jajan -
                            Caramixu</span>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
