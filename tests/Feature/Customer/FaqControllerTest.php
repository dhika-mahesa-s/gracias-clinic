<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqControllerTest extends TestCase
{
    use RefreshDatabase; // supaya database kosong setiap test dijalankan

    /** @test */
    public function halaman_faq_bisa_dibuka_dan_menampilkan_data()
    {
        // 1️⃣ buat data palsu di database
        Faq::create(['question' => 'Apa itu Gracias Clinic?', 'answer' => 'Klinik kecantikan terpercaya.']);
        Faq::create(['question' => 'Di mana lokasinya?', 'answer' => 'Di Pekanbaru.']);

        // 2️⃣ buka halaman /faq
        $response = $this->get('/faq');

        // 3️⃣ pastikan halaman muncul (status 200 = OK)
        $response->assertStatus(200);

        // 4️⃣ pastikan halaman pakai view customer.faq.index
        $response->assertViewIs('customer.faq.index');

        // 5️⃣ pastikan data FAQ dikirim ke view
        $response->assertViewHas('faqs');

        // 6️⃣ pastikan teks dari FAQ muncul di halaman
        $response->assertSee('Apa itu Gracias Clinic?');
        $response->assertSee('Di mana lokasinya?');
    }
}
