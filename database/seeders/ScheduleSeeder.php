<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // ===== SCHEDULES =====
        $days = ['Tuesday', 'Wednesday', 'Thursday','Friday', 'Saturday', 'Sunday'];
        foreach (Doctor::all() as $doctor) {
            foreach ($days as $day) {
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $day,
                    'start_time' => '10:00',
                    'end_time' => '18:00',
                    'quota' => 5,
                    'status' => 'available',
                ]);
            }
        }
    }
}
