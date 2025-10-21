<?php

namespace Database\Factories;

<<<<<<< HEAD
use App\Models\Treatment;
=======
>>>>>>> bcf6f902f91d5e798dd67a745a4bb970cf0fbe41
use Illuminate\Database\Eloquent\Factories\Factory;

class TreatmentFactory extends Factory
{
<<<<<<< HEAD
    protected $model = Treatment::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100000, 500000),
            'duration' => $this->faker->numberBetween(30, 120),
            'image' => null,
=======
    public function definition(): array
    {
        return [
            'name'        => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(), // nullable di migration
            'price'       => $this->faker->randomFloat(2, 50000, 500000), // simpan 2 desimal
            'duration'    => $this->faker->numberBetween(15, 180),
            'image'       => null, // akan diisi saat test upload
>>>>>>> bcf6f902f91d5e798dd67a745a4bb970cf0fbe41
        ];
    }
}
