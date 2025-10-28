<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Faq; // ✅ tambahkan ini

class FaqFactory extends Factory
{
    // ✅ pastikan model-nya ditentukan
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence(6), // contoh: "Apa manfaat facial di Gracias?"
            'answer'   => $this->faker->paragraph(), // contoh jawaban random
        ];
    }
}
