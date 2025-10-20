<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function halaman_index_menampilkan_daftar_faq()
    {
        Faq::factory()->create(['question' => 'Apa itu Gracias Clinic?', 'answer' => 'Klinik kecantikan terpercaya.']);
        
        $response = $this->get('/admin/faq');

        $response->assertStatus(200);
        $response->assertViewIs('admin.faq.index');
        $response->assertViewHas('faqs');
        $response->assertSee('Apa itu Gracias Clinic?');
    }

    /** @test */
    public function halaman_create_bisa_dibuka()
    {
        $response = $this->get('/admin/faq/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.faq.create');
    }

    /** @test */
    public function bisa_menyimpan_faq_baru_ke_database()
    {
        $data = [
            'question' => 'Apa jam operasionalnya?',
            'answer' => 'Buka setiap hari dari 09.00–17.00',
        ];

        $response = $this->post('/admin/faq', $data);

        $this->assertDatabaseHas('faqs', $data);
        $response->assertRedirect('/admin/faq');
    }

    /** @test */
    public function halaman_edit_bisa_dibuka_dengan_data_faq_yang_benar()
    {
        $faq = Faq::factory()->create();

        $response = $this->get("/admin/faq/{$faq->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.faq.edit');
        $response->assertViewHas('faq');
        $response->assertSee($faq->question);
    }

    /** @test */
    public function bisa_update_data_faq()
    {
        $faq = Faq::factory()->create();

        $updateData = [
            'question' => 'Pertanyaan diubah',
            'answer' => 'Jawaban diubah',
        ];

        $response = $this->put("/admin/faq/{$faq->id}", $updateData);

        $this->assertDatabaseHas('faqs', $updateData);
        $response->assertRedirect('/admin/faq');
    }

    /** @test */
    public function bisa_menghapus_faq()
    {
        $faq = Faq::factory()->create();

        $response = $this->delete("/admin/faq/{$faq->id}");

        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
        $response->assertRedirect('/admin/faq');
    }
}
