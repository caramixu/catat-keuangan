<section>
    <header class="mb-6">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Informasi Pribadi
        </h3>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <div x-data="{ photoPreview: null }"
            class="flex flex-col sm:flex-row items-center gap-6 p-5 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
            <div class="relative shrink-0">
                <template x-if="!photoPreview">
                    <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6366f1&color=fff' }}"
                        class="w-28 h-28 rounded-2xl object-cover border-4 border-white shadow-lg">
                </template>
                <template x-if="photoPreview">
                    <img :src="photoPreview"
                        class="w-28 h-28 rounded-2xl object-cover border-4 border-white shadow-lg">
                </template>
            </div>

            <div class="flex-1 text-center sm:text-left space-y-3">
                <label class="block text-sm font-bold text-slate-700">Foto Profil</label>
                <input type="file" name="profile_photo" accept="image/*"
                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">
                <p class="text-xs text-slate-400 font-medium">*Maksimal 2MB (JPG atau PNG)</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" value="Nama Lengkap" class="font-bold text-slate-700" />
                <input id="name" name="name" type="text"
                    class="mt-1 block w-full rounded-xl border-gray-200 focus:ring-indigo-500 shadow-sm"
                    value="{{ old('name', $user->name) }}" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" value="Alamat Email" class="font-bold text-slate-700" />
                <input id="email" name="email" type="email"
                    class="mt-1 block w-full rounded-xl border-gray-200 focus:ring-indigo-500 shadow-sm"
                    value="{{ old('email', $user->email) }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-95">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-emerald-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Berhasil disimpan.
                </p>
            @endif
        </div>
    </form>
</section>
