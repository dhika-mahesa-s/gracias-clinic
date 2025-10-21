<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Reservation;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        // create or get a test user (sesuaikan email jika sudah ada)
        $user = User::first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // doctors
        $dokterA = Doctor::first() ?? Doctor::create(['name' => 'dr. Ayu Putri', 'specialist' => 'Kecantikan']);
        $dokterB = Doctor::skip(1)->first() ?? Doctor::create(['name' => 'dr. Budi Santoso', 'specialist' => 'Dermatologi']);

        // treatments
        $t1 = Treatment::first() ?? Treatment::create(['name' => 'Facial Premium', 'price_range' => 'Rp 150.000 - 300.000']);
        $t2 = Treatment::skip(1)->first() ?? Treatment::create(['name' => 'Botox Mini', 'price_range' => 'Rp 1.200.000 - 2.000.000']);

        // make some reservations
        Reservation::create([
            'booking_id' => 'GRC-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'doctor_id' => $dokterA->id,
            'treatment_id' => $t1->id,
            'reservation_date' => Carbon::now()->subDays(10)->setTime(10, 0),
            'status' => 'Done',
            'notes' => 'Pelayanan baik'
        ]);

        Reservation::create([
            'booking_id' => 'GRC-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'doctor_id' => $dokterB->id,
            'treatment_id' => $t2->id,
            'reservation_date' => Carbon::now()->addDays(3)->setTime(14, 30),
            'status' => 'Pending',
            'notes' => 'Permintaan jadwal sore'
        ]);

        Reservation::create([
            'booking_id' => 'GRC-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'doctor_id' => $dokterA->id,
            'treatment_id' => $t2->id,
            'reservation_date' => Carbon::now()->subDays(2)->setTime(9, 0),
            'status' => 'Cancelled',
            'notes' => 'Dibatalkan oleh user'
        ]);
    }
}