<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    /**
     * ✅ Optimized: Select only needed columns, eager load active discounts
     * ✅ Prioritas: Treatment yang dipilih ditampilkan paling atas
     */
    public function index(Request $request)
    {
        $preSelectedTreatmentId = $request->query('treatment_id');
        
        // Base query untuk treatments
        $treatmentsQuery = Treatment::select('treatments.id', 'name', 'price', 'duration', 'image')
                                    ->with(['discounts' => function($query) {
                                        $query->select('discounts.id', 'name', 'type', 'value', 'start_date', 'end_date', 'is_active')
                                              ->active();
                                    }]);
        
        // Jika ada treatment_id yang dipilih, urutkan agar treatment itu paling atas
        if ($preSelectedTreatmentId) {
            $treatments = $treatmentsQuery
                         ->orderByRaw("CASE WHEN treatments.id = ? THEN 0 ELSE 1 END", [$preSelectedTreatmentId])
                         ->orderBy('name', 'asc')
                         ->get();
        } else {
            // Default: urutkan berdasarkan nama
            $treatments = $treatmentsQuery->orderBy('name', 'asc')->get();
        }
                               
        $doctors = Doctor::select('id', 'name', 'photo')
                        ->where('status', 'active')
                        ->get();

        return view('reservasi.index', compact('treatments', 'doctors', 'preSelectedTreatmentId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id'    => 'required|exists:doctors,id',
            'treatment_id' => 'required|exists:treatments,id',
            'date'         => 'required|date|after_or_equal:today',
            'time'         => 'required|date_format:H:i',
            'name'         => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s.]+$/', // Hanya huruf, spasi, dan titik
            ],
            'email'        => [
                'required',
                'email:rfc,dns',
                'max:255',
            ],
            'phone'        => [
                'required',
                'string',
                'regex:/^(\+62|62|0)[0-9]{9,13}$/', // Format Indonesia: 08xxx atau +628xxx atau 628xxx
            ],
        ], [
            'name.regex' => 'Nama hanya boleh berisi huruf, spasi, dan titik.',
            'phone.regex' => 'Format nomor telepon tidak valid. Gunakan format: 08xxxxxxxxxx atau +628xxxxxxxxxx',
            'date.after_or_equal' => 'Tanggal reservasi tidak boleh di masa lalu.',
            'time.date_format' => 'Format waktu tidak valid.',
            'email.email' => 'Email tidak valid atau domain email tidak ditemukan.',
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

        // Ambil treatment dengan diskon
        $treatment = Treatment::with('discounts')->findOrFail($request->treatment_id);
        
        // Gunakan harga diskon jika ada
        $price = $treatment->hasActiveDiscount() 
                 ? $treatment->getDiscountedPrice() 
                 : $treatment->price;
        
        // Pastikan harga adalah angka
        $price = (float) $price;

        $code = 'GRS-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        $user = User::find(Auth::id());
        if (!$user->phone){
            $user->phone = $request->phone;
            $user->save();
        }
        
        // Sanitize user inputs before storing
        $sanitizedName = strip_tags($request->name);
        $sanitizedEmail = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $sanitizedPhone = preg_replace('/[^0-9+]/', '', $request->phone);
        
        Reservation::create([
            'reservation_code'  => $code,
            'user_id'           => Auth::id(),
            'doctor_id'         => $request->doctor_id,
            'treatment_id'      => $request->treatment_id,
            'schedule_id'       => $schedule->id,
            'reservation_date'  => $request->date,
            'reservation_time'  => $time,
            'total_price'       => $price,
            'customer_name'     => $sanitizedName,
            'customer_email'    => $sanitizedEmail,
            'customer_phone'    => $sanitizedPhone,
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

    public function cetakResi($code)
    {
        $reservasi = Reservation::with(['doctor', 'treatment'])
                                ->where('reservation_code', $code)
                                ->firstOrFail();

        $pdf = Pdf::loadView('reservasi.resi', compact('reservasi'))
            ->setPaper('a5', 'portrait');

        $filename = 'resi-' . $reservasi->reservation_code . '.pdf'; 

        return $pdf->download($filename);
    }
}
