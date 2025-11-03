<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Simpan URL asal (misal user klik "Reservasi" tapi belum login)
        if ($request->has('redirect')) {
            session(['url.intended' => $request->input('redirect')]);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Jika admin → langsung dashboard
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            // ✅ Prioritaskan URL intended
            if (session()->has('url.intended')) {
                $redirectUrl = session('url.intended');
                session()->forget('url.intended'); // hapus supaya tidak nyangkut
                return redirect()->to($redirectUrl);
            }

            // ✅ Fallback ke halaman utama
            return redirect('/');
        }

        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }
}
