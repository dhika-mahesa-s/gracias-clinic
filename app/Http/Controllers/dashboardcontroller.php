<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; 
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReservasi = Reservation::count();
        $jumlahPelanggan = User::count();
        $pendapatan = Reservation::sum('harga');

        // Data untuk grafik
        $reservasiPerBulan = Reservation::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                            ->groupBy('bulan')
                            ->pluck('total', 'bulan');

        return view('admin.dashboard', compact(
            'totalReservasi', 
            'jumlahPelanggan', 
            'pendapatan', 
            'reservasiPerBulan'
        ));
    }
}
