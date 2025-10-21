<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'reservation_code' => strtoupper($this->faker->unique()->bothify('RES###??')),
            'user_id' => User::factory(),
            'doctor_id' => Doctor::factory(),
            'treatment_id' => Treatment::factory(),
            'schedule_id' => Schedule::factory(),
            'reservation_date' => Carbon::now()->format('Y-m-d'),
            'reservation_time' => '10:00:00',
            'total_price' => 200000,
            'status' => 'pending',
            'notes' => $this->faker->sentence,
            'customer_name' => $this->faker->name,
            'customer_email' => $this->faker->unique()->safeEmail,
            'customer_phone' => $this->faker->phoneNumber,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Reservation $reservation) {
            if (!$reservation->schedule_id) {
                $reservation->schedule_id = Schedule::factory()->create([
                    'doctor_id' => $reservation->doctor_id,
                    'day_of_week' => Carbon::parse($reservation->reservation_date)->format('l'),
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'quota' => 10,
                    'status' => 'available',
                ])->id;
                $reservation->save();
            }
        });
    }
}
