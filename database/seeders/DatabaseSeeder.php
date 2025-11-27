<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ADMIN USER =====
        if (!User::Where('name','Admin Gracias')->exists()){
             User::create([
            'name' => 'Admin Gracias',
            'email' => 'admin@gracias.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // ===== CUSTOMER USERS =====
        User::factory()->count(3)->create([
            'role' => 'customer',
        ]);

        }
       


        // Jalankan seeder lain
        $this->call([
            TreatmentSeeder::class,
            DoctorSeeder::class,
            FaqSeeder::class,
            ScheduleSeeder::class
            // tambahkan seeder lain kalau ada
        ]);

        echo "✅ Seeder berhasil dijalankan. Akun admin: admin@gracias.com / admin123\n";
    }
}
