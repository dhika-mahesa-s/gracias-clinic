<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index()
    {
        $treatments = Treatment::all();
        $doctors = Doctor::where('status', 'active')->get();
        return view('reservasi.index', compact('treatments', 'doctors'));
    }

    public function store(Request $request)
    {
        // 🧩 Validasi input
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'treatment_id' => 'required|exists:treatments,id',
            'date' => 'required|date',
            'time' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        // 🔍 Ambil hari dari tanggal yang dipilih user
        $dayOfWeek = Carbon::parse($request->date)->format('l');

        // 🔎 Cari jadwal dokter yang cocok
        $schedule = Schedule::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('start_time', '<=', $request->time)
            ->where('end_time', '>=', $request->time)
            ->first();

        // ❌ Jika tidak ditemukan
        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal dokter tidak ditemukan untuk waktu ini.'
            ]);
        }

        // 🔢 Buat kode reservasi unik
        $code = 'GRS-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        // 💾 Simpan data reservasi
        $reservation = Reservation::create([
            'reservation_code' => $code,
            'user_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'treatment_id' => $request->treatment_id,
            'schedule_id' => $schedule->id,
            'reservation_date' => $request->date,
            'reservation_time' => $request->time,
            'total_price' => Treatment::find($request->treatment_id)->price,
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'status' => 'pending',
        ]);
        

        // ✅ Berhasil
        return response()->json([
            'success' => true,
            'code' => $code
        ]);
    }

    public function getSchedule($doctor_id, $date)
    {
    try {
        // Konversi tanggal ke nama hari dalam bahasa Inggris
        $dayOfWeek = Carbon::parse($date)->format('l'); // contoh: 'Wednesday'

        // Cari jadwal dokter berdasarkan hari itu
        $schedule = Schedule::where('doctor_id', $doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'available')
            ->first();

        if (!$schedule) {
            return response()->json(['available_slots' => []]);
        }

        // Buat slot waktu berdasarkan start_time dan end_time
        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);
        $slots = [];

        while ($start->lessThan($end)) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(60); // interval 1 jam
        }

        return response()->json(['available_slots' => $slots]);
    } catch (\Exception $e) {
        return response()->json(['available_slots' => [], 'error' => $e->getMessage()], 500);
    }
    }   
    public function getAvailableSlots($doctorId, $date)
    {
    $tanggal = Carbon::parse($date)->format('Y-m-d');

    // Misalnya dokter bekerja jam 09:00–16:00 dengan jeda 1 jam
    $allSlots = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];

    // Ambil jadwal yang sudah dipesan untuk dokter dan tanggal ini
    $booked = Reservation::where('doctor_id', $doctorId)
        ->whereDate('date', $tanggal)
        ->pluck('time')
        ->toArray();

    // Filter slot yang masih tersedia
    $available = array_values(array_diff($allSlots, $booked));

    return response()->json([
        'available_slots' => $available
    ]);
    }

}

