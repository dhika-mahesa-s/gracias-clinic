<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $request->authenticate();
        
        $user = Auth::user();

        // Cek apakah email sudah diverifikasi (kecuali admin)
        if ($user->role !== 'admin' && is_null($user->email_verified_at)) {
            Auth::logout();
            
            return redirect()->route('login')
                ->withErrors(['email' => 'Email Anda belum diverifikasi. Silakan cek email Anda dan klik link verifikasi.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        // Jika user adalah admin
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
        }

        // Default: redirect ke intended URL atau landing page
        return redirect()->intended(route('landingpage'))
            ->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('logout_success', 'Anda telah keluar dari akun Anda.');
    }
}
