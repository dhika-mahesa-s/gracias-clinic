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
    /**
     * ✅ Optimized Dashboard dengan reduced queries
     */
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        // ✅ Single query untuk stats dengan conditional aggregation
        $stats = Reservation::selectRaw('
            COUNT(CASE WHEN DATE(reservation_date) = ? THEN 1 END) as reservations_today,
            SUM(CASE WHEN status = "completed" AND MONTH(reservation_date) = ? THEN total_price ELSE 0 END) as total_revenue,
            COUNT(DISTINCT CASE WHEN MONTH(reservation_date) = ? THEN customer_email END) as visitors_count
        ', [$today, $currentMonth, $currentMonth])
        ->first();

        $reservationsToday = $stats->reservations_today;
        $totalRevenue = $stats->total_revenue;
        $newVisitorsThisMonth = $stats->visitors_count;

        // ✅ Optimized: Get all chart data in fewer queries
        $reservationsByMonth = Reservation::selectRaw('MONTH(reservation_date) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $reservationsByWeek = Reservation::selectRaw('WEEK(reservation_date, 1) as week, COUNT(*) as total')
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        $reservationsByDay = Reservation::selectRaw('DATE(reservation_date) as day, COUNT(*) as total')
            ->where('reservation_date', '>=', $thirtyDaysAgo)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $reservationsByStatus = Reservation::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // ✅ Optimized: Use join without loading full treatment model
        $reservationsByTreatment = Reservation::join('treatments', 'reservations.treatment_id', '=', 'treatments.id')
            ->selectRaw('treatments.name as treatment, COUNT(reservations.id) as total')
            ->groupBy('treatments.name')
            ->get();

        return view('admin.dashboard', compact(
            'reservationsToday',
            'totalRevenue', 
            'newVisitorsThisMonth',
            'reservationsByMonth',
            'reservationsByWeek',
            'reservationsByDay',
            'reservationsByStatus',
            'reservationsByTreatment'
        ));
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

        // Ganti di DashboardController@Index:
        $newVisitorsThisMonth = Reservation::whereMonth('reservation_date', $currentMonth)
        ->distinct('user_id')
        ->count('user_id');


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
        return $pdf->download('laporan-penjualan.pdf');
    }
}
