<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;

        // 1️⃣ Total reservasi hari ini
        $reservationsToday = Reservation::whereDate('reservation_date', $today)->count();

        // 2️⃣ Total pendapatan bulan ini (status completed)
        $totalRevenue = Reservation::where('status', 'completed')
            ->whereMonth('reservation_date', $currentMonth)
            ->sum('total_price');

        // 3️⃣ Total pengunjung baru bulan ini
        $newVisitorsThisMonth = Reservation::select('customer_email')
            ->whereMonth('reservation_date', $currentMonth)
            ->groupBy('customer_email')
            ->get()
            ->count();

        // 4️⃣ Grafik: Reservasi per bulan
        $reservationsByMonth = Reservation::select(
            DB::raw('MONTH(reservation_date) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // 5️⃣ Grafik: Reservasi per status
        $reservationsByStatus = Reservation::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // 6️⃣ Grafik: Reservasi per treatment
        $reservationsByTreatment = Reservation::join('treatments', 'reservations.treatment_id', '=', 'treatments.id')
            ->select('treatments.name as treatment', DB::raw('COUNT(reservations.id) as total'))
            ->groupBy('treatments.name')
            ->get();

        // Kirim ke view
        return view('admin.dashboard', [
            'reservationsToday' => $reservationsToday,
            'totalRevenue' => $totalRevenue,
            'newVisitorsThisMonth' => $newVisitorsThisMonth,
            'reservationsByMonth' => $reservationsByMonth,
            'reservationsByStatus' => $reservationsByStatus,
            'reservationsByTreatment' => $reservationsByTreatment,
        ]);
    }

    // 🧾 Fungsi untuk generate & download laporan dalam bentuk PDF
    public function downloadReport()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;

        $reservationsToday = Reservation::whereDate('reservation_date', $today)->count();

        $totalRevenue = Reservation::where('status', 'completed')
            ->whereMonth('reservation_date', $currentMonth)
            ->sum('total_price');

        $newVisitorsThisMonth = Reservation::select('customer_email')
            ->whereMonth('reservation_date', $currentMonth)
            ->groupBy('customer_email')
            ->get()
            ->count();

        $reservationsByMonth = Reservation::select(
            DB::raw('MONTH(reservation_date) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $reservationsByStatus = Reservation::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        $reservationsByTreatment = Reservation::join('treatments', 'reservations.treatment_id', '=', 'treatments.id')
            ->select('treatments.name as treatment', DB::raw('COUNT(reservations.id) as total'))
            ->groupBy('treatments.name')
            ->get();

        // Buat PDF berdasarkan view laporan
        $pdf = Pdf::loadView('admin.laporan', [
            'reservationsToday' => $reservationsToday,
            'totalRevenue' => $totalRevenue,
            'newVisitorsThisMonth' => $newVisitorsThisMonth,
            'reservationsByMonth' => $reservationsByMonth,
            'reservationsByStatus' => $reservationsByStatus,
            'reservationsByTreatment' => $reservationsByTreatment,
        ]);

        // Download file PDF
        return $pdf->download('laporan-dashboard.pdf');
    }
}
