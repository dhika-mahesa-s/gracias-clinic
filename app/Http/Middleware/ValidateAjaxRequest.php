<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateAjaxRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only validate AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            // Check if request has valid CSRF token
            if (!$request->hasHeader('X-CSRF-TOKEN')) {
                return response()->json([
                    'success' => false,
                    'message' => 'CSRF token missing.'
                ], 403);
            }
        }

        return $next($request);
    }
}
