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
            ->paginate(10); // pakai paginate agar tidak berat

        return view('reservasi.admin', compact('reservations'));
    }

    // ✅ Mengonfirmasi reservasi
    public function konfirmasi($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status !== 'pending') {
            return back()->with('info', 'Reservasi tidak dapat dikonfirmasi lagi.');
        }

        $reservation->update(['status' => 'confirmed']);

        return back()->with('success', 'Reservasi berhasil dikonfirmasi.');
    }

    // ✅ Menandai reservasi sebagai selesai
    public function selesai($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status !== 'confirmed') {
            return back()->with('info', 'Reservasi hanya dapat ditandai selesai jika sudah dikonfirmasi.');
        }

        $reservation->update(['status' => 'completed']);

        return back()->with('success', 'Reservasi berhasil ditandai selesai.');
    }

    // ✅ Membatalkan reservasi
    public function batalkan($id)
    {
        $reservation = Reservation::findOrFail($id);

        if (in_array($reservation->status, ['completed', 'cancel'])) {
            return back()->with('info', 'Reservasi sudah selesai atau dibatalkan.');
        }

        $reservation->update(['status' => 'cancel']);

        return back()->with('error', 'Reservasi telah dibatalkan.');
    }
}
