<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition()
    {
        return [
            'doctor_id' => Doctor::factory(),
            'day_of_week' => $this->faker->randomElement([
                'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'
            ]),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'quota' => 10,
            'status' => 'available',
        ];
    }
}
