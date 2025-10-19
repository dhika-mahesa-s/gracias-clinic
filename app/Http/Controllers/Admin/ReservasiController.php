<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservation::latest()->get();
        return view('admin.reservasi.index', compact('reservasi'));
    }

    public function create()
    {
        return view('admin.reservasi.create');
    }

    public function store(Request $request)
    {
        Reservation::create($request->all());
        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil ditambahkan!');
    }

    // ... bisa lanjut ke  edit, update, destroy
}
