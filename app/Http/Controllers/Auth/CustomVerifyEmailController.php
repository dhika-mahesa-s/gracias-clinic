<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class CustomVerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified via signed URL.
     */
    public function __invoke(Request $request, $id, $hash)
    {
        // Validasi signed URL
        if (!$request->hasValidSignature()) {
            abort(403, 'Link verifikasi tidak valid atau sudah kadaluarsa.');
        }

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Verifikasi hash email
        if (!hash_equals((string) $hash, sha1($user->email))) {
            abort(403, 'Link verifikasi tidak valid.');
        }

        // Jika sudah terverifikasi
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('info', 'Email Anda sudah terverifikasi sebelumnya. Silakan login.');
        }

        // Verifikasi email
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->route('login')
            ->with('success', 'Email Anda berhasil diverifikasi! Silakan login untuk melanjutkan.');
    }
}
