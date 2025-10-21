<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationHistoryController extends Controller
{
    // No auth middleware here (public view). Cancel action checks auth.
    // public function __construct() { $this->middleware('auth'); }

    public function create()
    {
        // nanti bisa arahkan ke form reservasi baru
        return view('reservations.create');
    }

    public function index(Request $request)
    {
        $query = Reservation::query();

        // Filter status (hanya jika diisi)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal (hanya jika valid)
        if ($request->filled('date')) {
            // GANTI 'reservation_date' DENGAN NAMA KOLOM TANGGAL ANDA YANG SEBENARNYA
            $query->whereDate('reservation_date', $request->input('date'));
        }

        // Filter pencarian (nama pasien atau dokter)
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                // Asumsi: relasi 'user' punya kolom 'name' (untuk pasien)
                $q->whereHas('user', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                })
                    // Asumsi: relasi 'doctor' punya kolom 'name' (untuk dokter)
                    ->orWhereHas('doctor', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $reservations = $query->latest()->get();

        return view('reservations.history', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('doctor', 'treatment', 'user');
        return response()->json($reservation);
    }

    public function cancel(Request $request, Reservation $reservation)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Silakan login untuk membatalkan reservasi.');
        }

        if ($reservation->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Tidak berhak membatalkan reservasi ini.');
        }

        if (!in_array($reservation->status, ['Pending', 'Dikonfirmasi'])) {
            return redirect()->back()->with('error', 'Reservasi tidak bisa dibatalkan.');
        }

        $reservation->status = 'Dibatalkan';
        $reservation->save();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
