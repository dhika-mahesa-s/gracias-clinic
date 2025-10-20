<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TreatmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(), // nullable di migration
            'price'       => $this->faker->randomFloat(2, 50000, 500000), // simpan 2 desimal
            'duration'    => $this->faker->numberBetween(15, 180),
            'image'       => null, // akan diisi saat test upload
        ];
    }
}
