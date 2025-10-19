<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class RiwayatController extends Controller
{
    // Menampilkan halaman utama riwayat reservasi
    public function index()
    {
        $riwayat = Reservation::all();

        return view('admin.riwayat'); // nanti kita buat file view-nya
    }
}
