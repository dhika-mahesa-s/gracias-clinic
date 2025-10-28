<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $request->validate([
            'doctor_id'    => 'required|exists:doctors,id',
            'treatment_id' => 'required|exists:treatments,id',
            'date'         => 'required|date',
            'time'         => 'required',
            'name'         => 'required|string',
            'email'        => 'required|email',
            'phone'        => 'required|string',
        ]);

        // Pastikan time ke HH:mm:ss (kolom TIME MySQL)
        $time = strlen($request->time) === 5 ? $request->time . ':00' : $request->time;

        // Carbon::format('l') mengembalikan English day name (sesuai enum Monday..Sunday)
        $dayOfWeek = Carbon::parse($request->date)->format('l');

        // Cari schedule yang match HARI + JAM + status available
        $schedule = Schedule::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'available')
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->first();

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal dokter tidak ditemukan untuk waktu ini.'
            ]);
        }

        // (Opsional) Cek kuota: hitung booking di slot (dokter + tanggal + jam)
        $existing = Reservation::where('doctor_id', $request->doctor_id)
            ->where('schedule_id', $schedule->id)
            ->whereDate('reservation_date', $request->date)
            ->whereTime('reservation_time', $time)
            ->count();

        if ($existing >= $schedule->quota) {
            return response()->json([
                'success' => false,
                'message' => 'Slot sudah penuh untuk waktu ini.'
            ]);
        }

        // Ambil harga treatment tanpa load model penuh
        $price = Treatment::whereKey($request->treatment_id)->value('price') ?? 0;

        $code = 'GRS-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        Reservation::create([
            'reservation_code'  => $code,
            'user_id'           => Auth::id(),
            'doctor_id'         => $request->doctor_id,
            'treatment_id'      => $request->treatment_id,
            'schedule_id'       => $schedule->id,
            'reservation_date'  => $request->date,
            'reservation_time'  => $time,
            'total_price'       => $price,
            'customer_name'     => $request->name,
            'customer_email'     => $request->email,
            'customer_phone'     => $request->phone,
            'status'            => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'code'    => $code,
        ]);
    }

    // Dipakai oleh frontend: /reservasi/jadwal/{doctor_id}/{date}
    public function getSchedule($doctor_id, $date)
    {
        try {
            $dayOfWeek = Carbon::parse($date)->format('l'); // English
            $schedule = Schedule::where('doctor_id', $doctor_id)
                ->where('day_of_week', $dayOfWeek)
                ->where('status', 'available')
                ->first();

            if (!$schedule) {
                return response()->json(['available_slots' => []]);
            }

            // Generate slot per 60 menit dari start->end, lalu exclude yang sudah dibooking
            $start = Carbon::parse($schedule->start_time);
            $end   = Carbon::parse($schedule->end_time);

            $allSlots = [];
            while ($start->lessThan($end)) {
                $allSlots[] = $start->format('H:i:s');
                $start->addMinutes(60);
            }

            $booked = Reservation::where('doctor_id', $doctor_id)
                ->where('schedule_id', $schedule->id)
                ->whereDate('reservation_date', Carbon::parse($date)->toDateString())
                ->pluck('reservation_time')
                ->map(fn($t) => Carbon::parse($t)->format('H:i:s'))
                ->toArray();

            $available = array_values(array_diff($allSlots, $booked));

            // Frontend nyaman lihat "HH:mm"
            $available = array_map(fn($t) => substr($t, 0, 5), $available);

            return response()->json(['available_slots' => $available]);
        } catch (\Exception $e) {
            return response()->json(['available_slots' => [], 'error' => $e->getMessage()], 500);
        }
    }

    // Kalau tetap ingin endpoint alternatif ini, sinkronkan dengan skema kolom
    public function getAvailableSlots($doctorId, $date)
    {
        $tanggal = Carbon::parse($date)->toDateString();

        // Contoh slot statik
        $allSlots = ['09:00:00','10:00:00','11:00:00','13:00:00','14:00:00','15:00:00','16:00:00'];

        $booked = Reservation::where('doctor_id', $doctorId)
            ->whereDate('reservation_date', $tanggal)
            ->pluck('reservation_time')
            ->map(fn($t) => Carbon::parse($t)->format('H:i:s'))
            ->toArray();

        $available = array_values(array_diff($allSlots, $booked));

        // kirim sebagai "HH:mm" ke UI
        return response()->json([
            'available_slots' => array_map(fn($t) => substr($t, 0, 5), $available)
        ]);
    }

    public function cetakResi($code){
    $reservasi = Reservation::where('reservation_code', $code)->firstOrFail();

    $pdf = Pdf::loadView('reservasi.resi', compact('reservasi'))
        ->setPaper('a5', 'portrait');

    $filename = 'resi-' . $reservasi->reservation_code . '.pdf'; 

    return $pdf->download($filename);
}
}


