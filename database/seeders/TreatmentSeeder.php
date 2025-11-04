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
                'description' => 'Facial adalah perawatan dasar wajah untuk membersihkan pori-pori, mengangkat sel kulit mati, dan melembapkan kulit. Cocok untuk mengatasi kulit kusam, komedo, dan jerawat ringan. Hasilnya adalah kulit yang lebih bersih, halus, dan segar.',
                'price' => 200000,
                'duration' => 60,
                'image' => 'images/facial.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Peeling',
                'description' => 'Peeling adalah prosedur eksfoliasi menggunakan cairan kimia untuk mengangkat sel kulit mati. Dapat membantu mengatasi kulit kusam, bekas jerawat, dan warna kulit tidak merata. Setelah treatment, kulit tampak lebih cerah dan halus.',
                'price' => 300000,
                'duration' => 45,
                'image' => 'images/peeling.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Ultraformer',
                'description' => 'Ultraformer adalah perawatan non-bedah menggunakan teknologi HIFU (High-Intensity Focused Ultrasound) untuk mengencangkan kulit dan merangsang kolagen. Efektif untuk mengatasi kulit kendur dan garis halus, hasilnya kulit lebih kencang dan tirus.',
                'price' => 2500000,
                'duration' => 90,
                'image' => 'images/ultraformer.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Skinbooster',
                'description' => 'Skinbooster merupakan injeksi berisi asam hialuronat yang berfungsi meningkatkan kelembapan dan elastisitas kulit dari dalam. Cocok untuk kulit kering, kusam, dan bertekstur kasar. Hasilnya kulit lebih lembap, kenyal, dan glowing.',
                'price' => 1800000,
                'duration' => 60,
                'image' => 'images/skinbooster.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Botox',
                'description' => 'Botox adalah injeksi untuk merilekskan otot penyebab kerutan, terutama di dahi dan sekitar mata. Cocok bagi yang ingin mengurangi garis ekspresi dan tampak lebih muda. Hasilnya wajah terlihat lebih halus dan segar.',
                'price' => 2500000,
                'duration' => 45,
                'image' => 'images/botox.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Meso',
                'description' => 'Mesotherapy adalah teknik penyuntikan zat aktif seperti vitamin dan antioksidan ke lapisan tengah kulit untuk memperbaiki tekstur dan warna kulit. Cocok untuk kulit kusam, flek hitam, dan bekas jerawat. Hasilnya kulit lebih cerah dan sehat.',
                'price' => 500000,
                'duration' => 45,
                'image' => 'images/meso.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Dermapen',
                'description' => 'Dermapen adalah perawatan dengan alat microneedling yang menstimulasi kolagen dan elastin. Efektif untuk mengatasi bekas jerawat, pori besar, dan tanda penuaan dini. Hasilnya kulit lebih halus dan kencang.',
                'price' => 700000,
                'duration' => 60,
                'image' => 'images/dermapen.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Pico Laser',
                'description' => 'Pico Laser adalah teknologi laser berkecepatan tinggi untuk mengatasi pigmentasi, flek hitam, dan bekas jerawat tanpa merusak kulit sekitar. Setelah treatment, kulit tampak lebih cerah dan merata.',
                'price' => 1200000,
                'duration' => 45,
                'image' => 'images/picolaser.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Filler',
                'description' => 'Filler adalah prosedur injeksi untuk menambah volume di area wajah seperti pipi, dagu, dan bibir menggunakan asam hialuronat. Cocok untuk mempertegas kontur wajah. Hasilnya tampak alami dan lebih proporsional.',
                'price' => 2500000,
                'duration' => 45,
                'image' => 'images/filler.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Dynamic Pulsed Light (DPL)',
                'description' => 'DPL adalah perawatan berbasis cahaya untuk mengatasi kemerahan, flek, dan pori besar. Cocok untuk memperbaiki warna kulit tidak merata. Hasilnya kulit tampak lebih cerah dan halus.',
                'price' => 800000,
                'duration' => 40,
                'image' => 'images/dpl.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'name' => 'Radio Frequency Slimming',
                'description' => 'Radio Frequency Slimming menggunakan gelombang radio untuk memanaskan lapisan lemak di bawah kulit guna mempercepat pembakaran lemak dan mengencangkan kulit. Cocok untuk area wajah dan tubuh yang mulai kendur. Hasilnya kulit lebih kencang dan kontur tubuh lebih ideal.',
                'price' => 1000000,
                'duration' => 60,
                'image' => 'images/rfs.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
        ],
        );
        
    }
}
