<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCustomerRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user login dan memiliki role 'user'
        if (Auth::check() && Auth::user()->role === 'customer') {
            return $next($request);
        }

        // Jika bukan user (misal admin atau belum login)
        abort(403, 'Unauthorized action.');
    }
}
