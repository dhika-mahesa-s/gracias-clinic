<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total reservasi
        $totalReservations = Reservation::count();

        // Total pendapatan (status = completed)
        $totalRevenue = Reservation::where('status', 'completed')->sum('total_price');

        // Jumlah customer unik
        $uniqueCustomers = Reservation::distinct('customer_email')->count('customer_email');

        // Reservasi per bulan
        $reservationsByMonth = Reservation::select(
            DB::raw('MONTH(reservation_date) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Reservasi per status
        $reservationsByStatus = Reservation::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // Reservasi per treatment (pastikan tabel treatments ada)
        $reservationsByTreatment = Reservation::join('treatments', 'reservations.treatment_id', '=', 'treatments.id')
            ->select('treatments.name as treatment', DB::raw('COUNT(reservations.id) as total'))
            ->groupBy('treatments.name')
            ->get();

        return view('admin.dashboard', [
            'totalReservations' => $totalReservations,
            'totalRevenue' => $totalRevenue,
            'uniqueCustomers' => $uniqueCustomers,
            'reservationsByMonth' => $reservationsByMonth,
            'reservationsByStatus' => $reservationsByStatus,
            'reservationsByTreatment' => $reservationsByTreatment,
        ]);
    }
}