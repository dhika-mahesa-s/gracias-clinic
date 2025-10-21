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
        $query = Reservation::with(['doctor', 'treatment']);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', intval($request->user_id));
        } // else public -> show all

        // filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('tanggal', $request->date);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('booking_id', 'like', "%{$s}%")
                    ->orWhereHas('doctor', fn($q2) => $q2->where('name', 'like', "%{$s}%"))
                    ->orWhereHas('treatment', fn($q2) => $q2->where('name', 'like', "%{$s}%"));
            });
        }

        // paginate (no risk if Intelephense warns)
        $reservations = $query->orderByDesc('tanggal')->paginate(8);

        // Build stats safely (ensure keys always exist)
        $stats = [
            'total'     => 0,
            'done'      => 0,
            'upcoming'  => 0,
            'cancelled' => 0,
        ];

        // Determine which scope to use for stats
        if (Auth::check()) {
            $uid = Auth::id();
            $base = Reservation::where('user_id', $uid);
        } elseif ($request->filled('user_id')) {
            $uid = intval($request->user_id);
            $base = Reservation::where('user_id', $uid);
        } else {
            $base = Reservation::query();
        }

        // compute stats from $base
        $stats['total']     = (int) $base->count();
        $stats['done']      = (int) $base->where('status', 'Selesai')->count();
        $stats['upcoming']  = (int) $base->whereIn('status', ['Pending', 'Dikonfirmasi'])->count();
        $stats['cancelled'] = (int) $base->where('status', 'Dibatalkan')->count();

        return view('reservations.history', compact('reservations', 'stats'));
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
