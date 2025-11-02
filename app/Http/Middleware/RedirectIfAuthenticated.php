<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // 🔹 Jika ada URL yang dituju sebelumnya (url.intended), arahkan ke sana dulu
                if (session()->has('url.intended')) {
                    return redirect()->intended();
                }

                $user = Auth::guard($guard)->user();

                // 🔹 Jika tidak ada intended, arahkan sesuai role
                if ($user->role === 'admin') {
                    return redirect('/admin/dashboard');
                }

                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
