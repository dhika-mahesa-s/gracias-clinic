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
        $user = User::where('email', 'test@example.com')->first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $dokterA = Doctor::first() ?? Doctor::create(['name' => 'dr. Ayu Putri', 'specialist' => 'Kecantikan']);
        $dokterB = Doctor::skip(1)->first() ?? Doctor::create(['name' => 'dr. Budi Santoso', 'specialist' => 'Dermatologi']);

        $t1 = Treatment::first() ?? Treatment::create(['name' => 'Facial Premium', 'price' => 250000, 'duration' => 60]);
        $t2 = Treatment::skip(1)->first() ?? Treatment::create(['name' => 'Botox Mini', 'price' => 1200000, 'duration' => 45]);

        // 1. STATUS SELESAI (Mengisi Kartu Selesai)
        Reservation::create([
            'reservation_code' => 'GRC-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'doctor_id' => $dokterA->id,
            'treatment_id' => $t1->id,
            'reservation_date' => Carbon::now()->subDays(10),
            'reservation_time' => '10:00:00',
            'total_price' => $t1->price,
            'status' => 'Selesai',
            'notes' => 'Pelayanan baik'
        ]);

        // 2. STATUS DIKONFIRMASI (Mengisi Kartu Mendatang)
        Reservation::create([
            'reservation_code' => 'GRC-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'doctor_id' => $dokterB->id,
            'treatment_id' => $t2->id,
            'reservation_date' => Carbon::now()->addDays(5),
            'reservation_time' => '14:30:00',
            'total_price' => $t2->price,
            'status' => 'Dikonfirmasi',
            'notes' => 'Jadwal sudah dikonfirmasi admin'
        ]);

        // 3. STATUS PENDING
        Reservation::create([
            'reservation_code' => 'GRC-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'doctor_id' => $dokterA->id,
            'treatment_id' => $t1->id,
            'reservation_date' => Carbon::now()->addDays(1),
            'reservation_time' => '11:00:00',
            'total_price' => $t1->price,
            'status' => 'Pending',
            'notes' => 'Masih menunggu approval'
        ]);

        // 4. STATUS DIBATALKAN
        Reservation::create([
            'reservation_code' => 'GRC-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'doctor_id' => $dokterA->id,
            'treatment_id' => $t2->id,
            'reservation_date' => Carbon::now()->subDays(2),
            'reservation_time' => '09:00:00',
            'total_price' => $t2->price,
            'status' => 'Dibatalkan',
            'notes' => 'Dibatalkan oleh user'
        ]);
    }
}
