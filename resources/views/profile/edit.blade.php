<x-app-layout>
    <x-slot name="header">Pengaturan Akun</x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 w-full max-w-full mx-auto space-y-8">

        <div class="flex flex-col md:flex-row justify-between items-end border-b border-slate-200 pb-6 gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Manajemen Profil</h2>
                <p class="text-slate-500 font-medium">Kelola informasi data diri dan keamanan kata sandi Anda.</p>
            </div>
        </div>

        <div class="bg-white rounded-[1rem] shadow-sm border border-slate-100 overflow-hidden w-full">
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="p-8 md:p-12 space-y-6">

                    <div x-data="{ photoPreview: null }" class="flex flex-col md:flex-row items-center gap-8">
                        <div class="relative">
                            <template x-if="!photoPreview">
                                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6366f1&color=fff' }}"
                                    class="w-32 h-32 rounded-[2.5rem] object-cover border-4 border-slate-50 shadow-lg">
                            </template>
                            <template x-if="photoPreview">
                                <img :src="photoPreview"
                                    class="w-32 h-32 rounded-[2.5rem] object-cover border-4 border-slate-50 shadow-lg">
                            </template>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Foto Profil</h3>
                            <input type="file" name="profile_photo"
                                @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }"
                                class="text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer transition-all">
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 md:col-span-2">
                            <h3 class="text-lg font-bold text-slate-800">Informasi Dasar</h3>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Nama
                                Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all py-3">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Alamat
                                Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all py-3">
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2 md:col-span-3">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-slate-800">Keamanan</h3>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Password
                                Saat Ini</label>
                            <input type="password" name="current_password" placeholder="••••••••"
                                class="w-full rounded-2xl border-slate-200 @error('current_password') border-rose-500 focus:ring-rose-500/10 @else focus:ring-indigo-500/10 focus:border-indigo-500 @enderror transition-all py-3">
                            @error('current_password')
                                <p class="text-[10px] text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Password
                                Baru</label>
                            <input type="password" name="password" placeholder="Min. 8 Karakter"
                                class="w-full rounded-2xl border-slate-200 @error('password') border-rose-500 focus:ring-rose-500/10 @else focus:ring-indigo-500/10 focus:border-indigo-500 @enderror transition-all py-3">
                            @error('password')
                                <p class="text-[10px] text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password"
                                class="w-full rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all py-3">
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-xs text-slate-400 font-medium italic hidden md:block">*Pastikan data sudah benar</p>
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <a href="{{ route('dashboard') }}"
                            class="flex-1 md:flex-none text-center px-8 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition active:scale-95">
                            Batal
                        </a>

                        <button type="submit"
                            class="flex-1 md:flex-none px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-100 transition-all active:scale-95">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-rose-50/50 rounded-[1rem] border border-rose-100 overflow-hidden shadow-sm">
            <div class="p-8 md:p-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="shrink-0 rounded-2x1">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
