<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email:rfc,dns',  // Validasi RFC + DNS MX record check
                'max:255', 
                'unique:'.User::class
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.email' => 'Format email tidak valid atau domain email tidak ditemukan. Pastikan menggunakan email yang aktif.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Trigger event untuk mengirim email verifikasi
        event(new Registered($user));

        // JANGAN login user dulu - biarkan mereka verify email dulu
        // Auth::login($user);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan cek email Anda untuk verifikasi, kemudian login.');
    }
}
