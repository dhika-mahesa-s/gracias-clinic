<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationAdminController extends Controller
{
    // ✅ Menampilkan semua reservasi untuk admin
    public function index()
    {
        $reservations = Reservation::with(['doctor', 'treatment', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    // ✅ Mengonfirmasi reservasi
    public function konfirmasi($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status === 'confirmed') {
            return back()->with('info', 'Reservasi sudah dikonfirmasi.');
        }

        $reservation->update(['status' => 'confirmed']);

        return back()->with('success', 'Reservasi berhasil dikonfirmasi.');
    }
}
