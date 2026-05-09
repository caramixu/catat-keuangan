<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Cari user berdasarkan email
        $user = \App\Models\User::where('email', $request->email)->first();

        // Jika email tidak ditemukan, lempar error ke kolom 'email'
        if (!$user) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['Email ini tidak terdaftar pada sistem kami.'],
            ]);
        }

        // 2. Jika email ada, cek apakah passwordnya benar
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            // Jika password salah, lempar error ke kolom 'password'
            throw \Illuminate\Validation\ValidationException::withMessages([
                'password' => ['Password yang Anda masukkan salah.'],
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
