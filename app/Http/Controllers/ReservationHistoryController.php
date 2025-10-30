<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservationHistoryController extends Controller
{
    // Auth middleware diterapkan di route web.php

    /**
     * Menampilkan riwayat HANYA untuk customer yang sedang login.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        // FIX LINTER: Inisialisasi awal $query
        $query = Reservation::query();

        // Terapkan filter user_id secara langsung (untuk menghindari masalah 'where' di awal)
        $query->where('user_id', $userId)->with(['doctor', 'treatment']);

        // --- Logika Filter ---
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->input('date'));
        }
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reservation_code', 'like', "%{$search}%")
                    ->orWhereHas('doctor', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('treatment', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }
        // --- Akhir Logika Filter ---

        $reservations = $query->latest('reservation_date')->paginate(10)->appends($request->all());

        // Perhitungan Stats CUSTOMER (Mencari Status Huruf Kecil)
        $baseQuery = Reservation::where('user_id', $userId);

        $stats = [
            'total' => (int) $baseQuery->count(),
            'pending' => (int) $baseQuery->clone()->where('status', 'pending')->count(),
            'upcoming' => (int) $baseQuery->clone()->where('status', 'confirmed')->count(),
            'done' => (int) $baseQuery->clone()->where('status', 'completed')->count(),
            'cancelled' => (int) $baseQuery->clone()->where('status', 'dibatalkan')->count(),
        ];

        return view('reservations.history', compact('reservations', 'stats'));
    }

    /**
     * Menampilkan SEMUA riwayat untuk Admin.
     */
    public function adminIndex(Request $request)
    {
        // FIX LINTER: Inisialisasi awal $query
        $query = Reservation::query();

        $query->with(['doctor', 'treatment', 'user']);

        // --- Logika Filter Admin ---
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->input('date'));
        }
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reservation_code', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('doctor', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('treatment', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }
        // --- Akhir Logika Filter ---

        $reservations = $query->latest('reservation_date')->paginate(10)->appends($request->all());

        // Perhitungan Stats ADMIN
        $baseQuery = Reservation::query();
        $stats = [
            'total' => (int) $baseQuery->count(),
            'pending' => (int) $baseQuery->clone()->where('status', 'pending')->count(),
            'upcoming' => (int) $baseQuery->clone()->where('status', 'confirmed')->count(),
            'done' => (int) $baseQuery->clone()->where('status', 'completed')->count(),
            'cancelled' => (int) $baseQuery->clone()->where('status', 'dibatalkan')->count(),
        ];

        return view('admin.reservations.history', compact('reservations', 'stats'));
    }

    /**
     * Mencetak laporan berdasarkan filter yang sedang aktif (PDF).
     */
    public function printReport(Request $request)
    {
        $query = Reservation::query()->with(['doctor', 'treatment', 'user']);

        // --- Logika Filter (Sama dengan Admin Index) ---
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->input('date'));
        }
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reservation_code', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('doctor', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('treatment', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }
        // --- Akhir Logika Filter ---

        $reservations = $query->latest('reservation_date')->get();

        $pdf = Pdf::loadView('admin.reservations.historyreport', compact('reservations', 'request'))            ->setPaper('a4', 'landscape');

        $filename = 'laporan-reservasi-' . now()->format('YmdHis') . '.pdf';

        return $pdf->download($filename);
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('doctor', 'treatment', 'user');
        return response()->json($reservation);
    }

    public function cancel(Request $request, Reservation $reservation)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && $reservation->user_id !== Auth::id())) {
            return redirect()->back()->with('error', 'Tidak berhak membatalkan reservasi ini.');
        }
        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Reservasi tidak bisa dibatalkan.');
        }

        $reservation->status = 'dibatalkan';
        $reservation->save();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
