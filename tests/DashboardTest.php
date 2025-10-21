<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    /** @test */
    public function halaman_dashboard_dapat_dirender()
    {
        // Akses route dashboard
        $response = $this->get('/dashboard');

        // Pastikan statusnya 200 (OK)
        $response->assertStatus(200);

        // Pastikan view yang digunakan adalah 'admin.dashboard'
        $response->assertViewIs('admin.dashboard');

        // Pastikan teks utama ada di tampilan
        $response->assertSee('Dashboard');
        $response->assertSee('Total Reservasi');
    }
}
