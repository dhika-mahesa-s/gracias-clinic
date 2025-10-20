<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'service_type' => $this->faker->randomElement(['Facial', 'Injection', 'Laser', 'Konsultasi', 'Massage', 'Lainnya']),
            'staff_rating' => $this->faker->numberBetween(1, 5),
            'professional_rating' => $this->faker->numberBetween(1, 5),
            'result_rating' => $this->faker->numberBetween(1, 5),
            'return_rating' => $this->faker->numberBetween(1, 5),
            'overall_rating' => $this->faker->numberBetween(1, 5),
            'message' => $this->faker->paragraph,
        ];
    }
}