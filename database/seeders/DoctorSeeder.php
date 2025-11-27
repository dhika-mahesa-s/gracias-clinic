<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // ===== DOCTORS =====
        $doctors = [
            ['name' => 'dr. Jessica Natasia', 'email' => 'jessica@gracias.com', 'phone' => '0811111111'],
            ['name' => 'dr. Stella Verinda', 'email' => 'stella@gracias.com', 'phone' => '0812222222'],
        ];

        foreach ($doctors as $d) {
            Doctor::create([
                'name' => $d['name'],
                'email' => $d['email'],
                'phone' => $d['phone'],
                'status' => 'active',
            ]);
        }
    }
}
