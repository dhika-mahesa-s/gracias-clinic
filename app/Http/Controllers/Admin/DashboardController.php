<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $total_reservasi = Reservation::count();
        $total_pelanggan = User::count();
        $pendapatan = Reservation::sum('total_bayar');

        return view('admin.dashboard', compact('total_reservasi', 'total_pelanggan', 'pendapatan'));
    }
}
