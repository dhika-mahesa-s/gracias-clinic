<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // data untuk grafik
        $totalReservasi = Reservasi::count();
        $pendapatan = Reservasi::sum('harga');
        $reservasiPerBulan = Reservasi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                                      ->groupBy('bulan')
                                      ->pluck('total', 'bulan');

        return view('admin.dashboard', compact('totalReservasi', 'pendapatan', 'reservasiPerBulan'));
    }
}
