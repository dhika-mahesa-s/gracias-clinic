<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerifiedOrGoogleAuth
{
    /**
     * Handle an incoming request.
     * 
     * Middleware ini meng-handle:
     * 1. User dengan email verified (normal flow)
     * 2. User dengan Google OAuth (google_id terisi) - auto-pass
     * 3. User belum verified - redirect ke verification notice
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string|null $redirectToRoute = null): Response
    {
        $user = $request->user();

        // Jika user tidak login, redirect ke login (seharusnya sudah dihandle oleh auth middleware)
        if (! $user) {
            return redirect()->route('login');
        }

        // ✅ PASS: User sudah verified email
        if ($user->hasVerifiedEmail()) {
            return $next($request);
        }

        // ✅ PASS: User login dengan Google OAuth (google_id ada)
        if (! empty($user->google_id)) {
            // Auto-verify user jika belum verified tapi punya google_id
            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = now();
                $user->save();
                
                // Refresh auth user untuk memastikan perubahan ter-load
                $request->setUserResolver(fn () => $user->fresh());
            }
            
            return $next($request);
        }

        // ❌ BLOCK: User belum verified dan bukan Google OAuth
        // Jika user implements MustVerifyEmail, redirect ke verification notice
        if ($user instanceof MustVerifyEmail) {
            return redirect()->route(
                $redirectToRoute ?? 'verification.notice'
            );
        }

        // Fallback: allow access (untuk user yang tidak perlu verification)
        return $next($request);
    }
}
