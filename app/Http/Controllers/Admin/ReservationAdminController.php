<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ReservationConfirmed;

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

        // 📧 Kirim email notifikasi ke customer dengan error handling
        try {
            Mail::to($reservation->customer_email)
                ->send(new ReservationConfirmed($reservation));
            
            // Log successful email
            Log::info('Reservation confirmation email sent', [
                'reservation_id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code,
                'customer_email' => $reservation->customer_email,
            ]);
            
            return back()->with('success', 'Reservasi berhasil dikonfirmasi dan email notifikasi telah dikirim ke customer.');
        } catch (\Exception $e) {
            // Log error untuk monitoring
            Log::error('Failed to send reservation confirmation email', [
                'reservation_id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code,
                'customer_email' => $reservation->customer_email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Jika email gagal, tetap konfirmasi berhasil tapi beri info
            return back()->with('warning', 'Reservasi berhasil dikonfirmasi, namun email notifikasi gagal dikirim. Tim teknis telah diberitahu.');
        }
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

        $reservation->update(['status' => 'cancelled']);

        return back()->with('error', 'Reservasi telah dibatalkan.');
    }
}
