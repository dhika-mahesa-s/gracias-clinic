<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Schedule;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ADMIN USER =====
        User::create([
            'name' => 'Admin Gracias',
            'email' => 'admin@gracias.com',
            'password' => Hash::make('admin123'), // 🔐 default password
            'role' => 'admin',
        ]);

        // ===== CUSTOMER USERS =====
        User::factory()->count(3)->create([
            'role' => 'customer',
        ]);

        // ===== DOCTORS =====
        $doctors = [
            ['name' => 'dr. Siti Lestari', 'email' => 'siti@gracias.com', 'phone' => '0811111111'],
            ['name' => 'dr. Andi Saputra', 'email' => 'andi@gracias.com', 'phone' => '0812222222'],
            ['name' => 'dr. Rina Kurnia', 'email' => 'rina@gracias.com', 'phone' => '0813333333'],
        ];

        foreach ($doctors as $d) {
            Doctor::create([
                'name' => $d['name'],
                'email' => $d['email'],
                'phone' => $d['phone'],
                'status' => 'active',
            ]);
        }

        // ===== TREATMENTS =====
        $treatments = [
            ['name' => 'Facial Glow', 'description' => 'Perawatan wajah untuk mencerahkan kulit', 'price' => 250000, 'duration' => 60],
            ['name' => 'Laser Acne', 'description' => 'Perawatan laser untuk kulit berjerawat', 'price' => 400000, 'duration' => 45],
            ['name' => 'Hair Removal', 'description' => 'Perawatan laser untuk menghilangkan rambut halus', 'price' => 350000, 'duration' => 30],
        ];

        foreach ($treatments as $t) {
            Treatment::create($t);
        }

        // ===== SCHEDULES =====
        $days = ['Monday', 'Wednesday', 'Friday'];
        foreach (Doctor::all() as $doctor) {
            foreach ($days as $day) {
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $day,
                    'start_time' => '08:00',
                    'end_time' => '12:00',
                    'quota' => 5,
                    'status' => 'available',
                ]);
            }
        }

        echo "✅ Seeder berhasil dijalankan. Akun admin: admin@gracias.com / admin123\n";
    }
}
