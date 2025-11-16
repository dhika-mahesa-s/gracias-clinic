<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    $query = Reservation::query();
    $query->where('user_id', $userId)->with(['doctor', 'treatment']);

    // --- Logika Filter ---
    if ($request->filled('status')) {
        // Validasi status hanya dari enum yang valid
        $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        if (in_array($request->status, $validStatuses)) {
            $query->where('status', $request->status);
        }
    }
    if ($request->filled('date')) {
        $query->whereDate('reservation_date', $request->input('date'));
    }
    if ($request->filled('search')) {
        // Sanitasi input search untuk prevent SQL injection & XSS
        $search = strip_tags($request->input('search'));
        $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
        $search = trim($search);
        
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('reservation_code', 'like', "%{$search}%")
                    ->orWhereHas('doctor', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('treatment', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }
    }
    // --- Akhir Logika Filter ---

    // Urutkan berdasarkan reservasi terbaru
    $reservations = $query
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends($request->all());

    // Stats - OPTIMIZED: Single query dengan groupBy instead of 4 separate queries
    $baseQuery = Reservation::where('user_id', $userId);
    
    $statusCounts = $baseQuery->clone()
        ->select('status', DB::raw('COUNT(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();
    
    $stats = [
        'total' => (int) $baseQuery->count(),
        'pending' => (int) ($statusCounts['pending'] ?? 0),
        'upcoming' => (int) ($statusCounts['confirmed'] ?? 0),
        'done' => (int) ($statusCounts['completed'] ?? 0),
        'cancelled' => (int) ($statusCounts['cancelled'] ?? 0),
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
            $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
            if (in_array($request->status, $validStatuses)) {
                $query->where('status', $request->status);
            }
        }
        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->input('date'));
        }
        if ($request->filled('search')) {
            // Sanitasi input search
            $search = strip_tags($request->input('search'));
            $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
            $search = trim($search);
            
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('reservation_code', 'like', "%{$search}%")
                        ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('doctor', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('treatment', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
                });
            }
        }
        // --- Akhir Logika Filter ---

        // Urutkan berdasarkan prioritas status, lalu tanggal & waktu reservasi
        // Priority: pending > confirmed > completed > cancelled
        $reservations = $query
            ->orderByRaw("FIELD(status, 'pending', 'confirmed', 'completed', 'cancelled')")
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->paginate(10)
            ->appends($request->all());

        // Perhitungan Stats ADMIN - OPTIMIZED
        $baseQuery = Reservation::query();
        
        $statusCounts = $baseQuery->clone()
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        $stats = [
            'total' => (int) $baseQuery->count(),
            'pending' => (int) ($statusCounts['pending'] ?? 0),
            'upcoming' => (int) ($statusCounts['confirmed'] ?? 0),
            'done' => (int) ($statusCounts['completed'] ?? 0),
            'cancelled' => (int) ($statusCounts['cancelled'] ?? 0),
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
            $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
            if (in_array($request->status, $validStatuses)) {
                $query->where('status', $request->status);
            }
        }
        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->input('date'));
        }
        if ($request->filled('search')) {
            // Sanitasi input search
            $search = strip_tags($request->input('search'));
            $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
            $search = trim($search);
            
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('reservation_code', 'like', "%{$search}%")
                        ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('doctor', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('treatment', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
                });
            }
        }
        // --- Akhir Logika Filter ---

        // Urutkan berdasarkan tanggal reservasi (terbaru dulu), lalu waktu reservasi
        $reservations = $query
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.reservations.historyreport', compact('reservations', 'request'))->setPaper('a4', 'landscape');

        $filename = 'laporan-reservasi-' . now()->format('YmdHis') . '.pdf';

        return $pdf->download($filename);
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('doctor', 'treatment', 'user');
        return response()->json($reservation);
    }

    /**
     * Cancel reservasi oleh customer (hanya jika status = pending)
     */
    public function cancelReservation(Reservation $reservation)
    {
        // Pastikan reservasi milik user yang login
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('reservations.history')
                ->with('error', 'Anda tidak memiliki akses untuk membatalkan reservasi ini.');
        }

        // Pastikan status masih pending
        if ($reservation->status !== 'pending') {
            return redirect()->route('reservations.history')
                ->with('error', 'Reservasi hanya dapat dibatalkan jika masih dalam status Pending.');
        }

        // Update status menjadi cancelled
        $reservation->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('reservations.history')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }
    
}
