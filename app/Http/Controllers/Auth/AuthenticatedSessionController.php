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
    public function create(Request $request): View
    {
        // Simpan halaman sebelumnya (hanya jika bukan login/logout)
        if (
            !$request->session()->has('url.intended') &&
            $request->headers->get('referer') &&
            !str_contains($request->headers->get('referer'), '/login')
        ) {
            $request->session()->put('url.intended', $request->headers->get('referer'));
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    // Jika ada redirect_to dari form login (misal dari feedback.create)
    if ($request->filled('redirect_to')) {
        return redirect($request->input('redirect_to'))
            ->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
    }

    // Jika user adalah admin
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard')
            ->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
    }

    // Default: kembali ke landing page
    return redirect()->route('landingpage')
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
