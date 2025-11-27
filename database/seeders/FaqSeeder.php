<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('faqs')->insert([
            [
                'question' => 'Apakah klinik ini memiliki dokter atau terapis berlisensi?',
                'answer' => 'Ya, seluruh tindakan medis dilakukan oleh dokter yang berpengalaman dan tersertifikasi, serta terapis profesional.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Kapan Jam operasional klinik?',
                'answer' => 'Selasa-Minggu (10.00am - 18.00pm)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah harus booking sebelum datang?',
                'answer' => 'Dianjurkan untuk melakukan reservasi terlebih dahulu agar mendapatkan jadwal sesuai keinginan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bagaimana cara melakukan booking?',
                'answer' => 'Login terlebih dahulu(Lakukan register jika belum memiliki akun) -> pergi ke halaman treatment -> klik tombol reservasi -> isi formulir pendaftaran -> cetak resi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'question' => 'Layanan apa saja yang tersedia?',
                'answer' => 'Facial, Peeling, Ultraformer, Skinbooster, botox dan berbagai layanan lainnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'question' => 'Berapa lama durasi setiap perawatan?',
                'answer' => 'Rata-rata 30–60 menit tergantung jenis layanan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'question' => 'Berapa lama hasil treatment terlihat?',
                'answer' => 'Hasil dapat terlihat dalam 1–2 kali treatment, namun berbeda untuk setiap individu tergantung kondisi kulit dan jenis layanan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah ada efek samping?',
                'answer' => 'Efek samping biasanya ringan dan sementara, seperti kemerahan atau sensitivity, dan akan dijelaskan sebelum tindakan dilakukan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Berapa harga treatment di Gracias Aesthetic?',
                'answer' => 'Harga bervariasi tergantung jenis perawatan. Silakan DM atau WhatsApp untuk detail harga dan promo terbaru.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apa metode pembayaran yang tersedia?',
                'answer' => 'Tunai, transfer bank, QRIS, dan metode pembayaran digital lainnya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah klinik menyediakan produk skincare?',
                'answer' => 'Ya. Terdapat rangkaian produk yang diformulasikan oleh dokter sesuai kebutuhan kulit pasien. Untuk informasi lebih lanjut silahkan kunjungi akun sosial media kami',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apa yang harus dilakukan setelah treatment?',
                'answer' => 'Dokter atau terapis akan memberikan instruksi aftercare sesuai jenis perawatan yang dilakukan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bolehkah memakai makeup setelah treatment?',
                'answer' => 'Untuk beberapa treatment, disarankan menunggu 24 jam. Petunjuk lengkap akan diberikan setelah tindakan. Informasi lebih lanjut bisa langsung hubungi dokter yang bersangkutan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bisakah konsultasi dilakukan secara online?',
                'answer' => 'Bisa, melalui DM Instagram atau WhatsApp, namun pemeriksaan langsung lebih akurat.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            

            
        ]);
    }
}
