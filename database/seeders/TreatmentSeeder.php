<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('treatments')->insert([
            [
                'name' => 'Facial',
                'description' => 'Perawatan wajah dasar untuk membersihkan pori-pori, mengangkat sel kulit mati, dan memberikan efek segar serta lembap pada kulit.',
                'price' => 250000,
                'duration' => 60,
                'image' => 'facial.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Peeling',
                'description' => 'Perawatan eksfoliasi menggunakan bahan kimia lembut untuk mengangkat sel kulit mati dan mencerahkan kulit wajah.',
                'price' => 300000,
                'duration' => 45,
                'image' => 'peeling.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ultraformer',
                'description' => 'Perawatan non-bedah dengan teknologi HIFU untuk mengencangkan kulit, merangsang produksi kolagen, dan mengangkat area wajah yang kendur.',
                'price' => 1800000,
                'duration' => 90,
                'image' => 'ultraformer.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Skinbooster',
                'description' => 'Injeksi asam hialuronat yang melembapkan kulit dari dalam, meningkatkan elastisitas, dan memberikan tampilan glowing alami.',
                'price' => 1200000,
                'duration' => 60,
                'image' => 'skinbooster.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Botox',
                'description' => 'Injeksi yang berfungsi mengurangi kerutan halus di wajah dan membuat kulit tampak lebih kencang serta awet muda.',
                'price' => 2000000,
                'duration' => 45,
                'image' => 'botox.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Meso',
                'description' => 'Perawatan injeksi vitamin dan nutrisi ke lapisan dermis untuk mencerahkan, melembapkan, dan menutrisi kulit.',
                'price' => 800000,
                'duration' => 50,
                'image' => 'meso.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dermapen',
                'description' => 'Perawatan microneedling untuk merangsang regenerasi kulit, mengurangi bekas jerawat, dan memperbaiki tekstur kulit.',
                'price' => 1000000,
                'duration' => 75,
                'image' => 'dermapen.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pico Laser',
                'description' => 'Teknologi laser canggih untuk menghilangkan flek hitam, bekas jerawat, dan mencerahkan kulit secara merata.',
                'price' => 1500000,
                'duration' => 60,
                'image' => 'pico_laser.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Filler',
                'description' => 'Injeksi filler untuk menambah volume pada area tertentu seperti bibir, dagu, atau pipi agar tampak lebih proporsional.',
                'price' => 2200000,
                'duration' => 45,
                'image' => 'filler.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dynamic Pulsed Light (DPL)',
                'description' => 'Perawatan dengan cahaya berdenyut untuk meratakan warna kulit, mengatasi jerawat, dan mengurangi pigmentasi.',
                'price' => 700000,
                'duration' => 50,
                'image' => 'dpl.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Radio Frequency Slimming',
                'description' => 'Perawatan pelangsingan dan pengencangan kulit dengan teknologi gelombang radio untuk mengurangi lemak dan selulit.',
                'price' => 900000,
                'duration' => 75,
                'image' => 'rf_slimming.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
