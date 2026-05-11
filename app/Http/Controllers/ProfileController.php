<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class ProfileController extends Controller
{
    private function cloudinaryInstance()
    {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey    = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');

        return new Cloudinary(
            "cloudinary://{$apiKey}:{$apiSecret}@{$cloudName}"
        );
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];

        // PERBAIKAN: Jika user mengisi password lama ATAU password baru, jalankan validasi ketat
        if ($request->filled('current_password') || $request->filled('password')) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['password'] = ['required', 'confirmed', 'min:8'];
        }

        // Jalankan validasi dengan pesan kustom agar lebih informatif
        $request->validate($rules, [
            'current_password.required' => 'Password lama wajib diisi untuk mengganti keamanan.',
            'current_password.current_password' => 'Password lama yang Anda masukkan salah.',
            'password.required' => 'Silakan masukkan password baru.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal 8 karakter.',
        ]);

        // Simpan data profil
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->remove_photo == '1' && $user->profile_photo) {
            $user->profile_photo = null;
        }

        if ($request->hasFile('profile_photo')) {
            $result = $this->cloudinaryInstance()->uploadApi()->upload(
                $request->file('profile_photo')->getRealPath(),
                ['folder' => 'profile_photos']
            );
            $user->profile_photo = $result['secure_url'];
        }

        // Hanya update password di database jika kolom password baru memang diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
