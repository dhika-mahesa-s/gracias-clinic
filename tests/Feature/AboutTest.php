<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutTest extends TestCase
{
    /** @test */
    public function halaman_about_dapat_dimuat_dengan_benar()
    {
        // Akses halaman about
        $response = $this->get(route('about'));

        // Pastikan status kode 200 (OK)
        $response->assertStatus(200);

        // Pastikan view yang dipakai adalah 'about'
        $response->assertViewIs('about');

        // Pastikan teks penting di dalam halaman muncul
        $response->assertSee('Tentang Kami');
        $response->assertSee('Gracias Aesthetic Clinic');
    }
}
