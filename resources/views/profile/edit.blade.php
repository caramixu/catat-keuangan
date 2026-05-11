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

                    <div x-data="{
                        photoPreview: '{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : '' }}',
                        removePhoto: false,
                        defaultAvatar: 'https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff',
                        showCropModal: false,
                        cropper: null,
                        openCropper(file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.showCropModal = true;
                                this.$nextTick(() => {
                                    const image = document.getElementById('cropperImage');
                                    image.src = e.target.result;
                                    if (this.cropper) this.cropper.destroy();
                                    this.cropper = new Cropper(image, {
                                        aspectRatio: 1,
                                        viewMode: 2,
                                        movable: true,
                                        zoomable: true,
                                        rotatable: true,
                                        scalable: true,
                                        cropBoxResizable: true,
                                    });
                                });
                            };
                            reader.readAsDataURL(file);
                        },
                        saveCrop() {
                            const canvas = this.cropper.getCroppedCanvas({ width: 400, height: 400 });
                            canvas.toBlob((blob) => {
                                const file = new File([blob], 'profile.jpg', { type: 'image/jpeg' });
                                const dt = new DataTransfer();
                                dt.items.add(file);
                                this.$refs.photoInput.files = dt.files;
                                this.photoPreview = canvas.toDataURL('image/jpeg');
                                this.removePhoto = false;
                                this.showCropModal = false;
                                this.cropper.destroy();
                            }, 'image/jpeg', 0.9);
                        }
                    }" class="flex flex-col md:flex-row items-center gap-8">

                        <input type="file" name="profile_photo" x-ref="photoInput" class="hidden"
                            accept=".jpg,.png,image/jpeg,image/png"
                            @change="if ($event.target.files[0]) openCropper($event.target.files[0])">
                        <input type="hidden" name="remove_photo" :value="removePhoto ? '1' : '0'">

                        {{-- Preview Foto --}}
                        <div class="relative">
                            <img :src="photoPreview || defaultAvatar"
                                class="w-32 h-32 rounded-[2.5rem] object-cover border-4 border-slate-50 shadow-lg">
                        </div>

                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-xl font-bold text-slate-800 mb-3">Foto Profil</h3>
                            <div class="flex gap-2 justify-center md:justify-start">
                                <button type="button" @click="$refs.photoInput.click()"
                                    class="px-4 py-2 bg-indigo-50 text-indigo-600 text-sm font-bold rounded-xl hover:bg-indigo-100 transition">
                                    Ubah Foto
                                </button>
                                <button type="button"
                                    @click="photoPreview = ''; removePhoto = true; $refs.photoInput.value = ''"
                                    class="px-4 py-2 bg-rose-50 text-rose-500 text-sm font-bold rounded-xl hover:bg-rose-100 transition">
                                    Hapus Foto
                                </button>
                            </div>
                        </div>

                        {{-- Modal Crop --}}
                        <div x-show="showCropModal" x-cloak
                            class="fixed inset-0 z-[200] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                    <h3 class="font-bold text-slate-800">Sesuaikan Foto</h3>
                                    <button type="button" @click="showCropModal = false; cropper.destroy()"
                                        class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- Area Cropper --}}
                                <div class="p-4 bg-gray-50">
                                    <div class="max-h-72 overflow-hidden flex items-center justify-center">
                                        <img id="cropperImage" class="max-w-full">
                                    </div>
                                </div>

                                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                                    <button type="button"
                                        @click="showCropModal = false; cropper.destroy(); $refs.photoInput.value = ''"
                                        class="px-5 py-2 bg-gray-100 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-200 transition">
                                        Batal
                                    </button>
                                    <button type="button" @click="saveCrop()"
                                        class="px-5 py-2 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition">
                                        Gunakan Foto
                                    </button>
                                </div>
                            </div>
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
