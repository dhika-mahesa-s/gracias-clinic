<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller; // WAJIB: Import Controller

class ReservationHistoryController extends Controller
{
    // app/Http/Controllers/ReservationHistoryController.php (HANYA FUNGSI INDEX DAN ADMININDEX)

    // ...

    /**
     * Menampilkan riwayat HANYA untuk customer yang sedang login.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $query = Reservation::where('user_id', Auth::id());

        // --- Logika Filter (Hanya contoh sederhana di sini) ---
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // ... (Tambahkan logika filter lain dari kode lama Anda di sini) ...
        // --- Akhir Logika Filter ---

        // >>> VARIABEL $reservations DIHILANGKAN, SEKARANG ADA LAGI <<<
        $reservations = $query->latest('reservation_date')->paginate(10);

        // Perhitungan Stats
        $baseQuery = Reservation::where('user_id', Auth::id());
        $stats = [
            'total' => $baseQuery->count(),
            'done' => $baseQuery->where('status', 'Selesai')->count(),
            'upcoming' => $baseQuery->whereIn('status', ['Pending', 'Dikonfirmasi'])->count(),
            'cancelled' => $baseQuery->where('status', 'Dibatalkan')->count(),
        ];

        return view('reservations.history', compact('reservations', 'stats'));
    }

    /**
     * Menampilkan SEMUA riwayat untuk Admin.
     */
    public function adminIndex(Request $request)
    {
        // Query untuk SEMUA reservasi
        $query = Reservation::query();

        // --- Logika Filter ---
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // ... (Tambahkan logika filter lain dari kode lama Anda di sini) ...
        // --- Akhir Logika Filter ---

        // >>> VARIABEL $reservations DIHILANGKAN, SEKARANG ADA LAGI <<<
        $reservations = $query->latest('reservation_date')->paginate(10);

        // Perhitungan Stats Admin
        $stats = [
            'total' => Reservation::count(),
            'done' => Reservation::where('status', 'Selesai')->count(),
            'upcoming' => Reservation::whereIn('status', ['Pending', 'Dikonfirmasi'])->count(),
            'cancelled' => Reservation::where('status', 'Dibatalkan')->count(),
        ];

        return view('admin.reservations.history', compact('reservations', 'stats'));
    }
    // ...
}
