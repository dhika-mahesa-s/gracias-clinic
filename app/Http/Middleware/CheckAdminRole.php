<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek jika user login DAN memiliki role 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Lanjutkan request jika admin
        }

        // Jika bukan admin, kembalikan error 403 Forbidden
        abort(403, 'Unauthorized action.');
    }
}