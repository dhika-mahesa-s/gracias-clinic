<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class DashboardTest extends TestCase
{
    /** @test */
    public function halaman_dashboard_dapat_dirender_dengan_benar()
    {
        // 🔹 Buat user palsu dari factory
        $user = User::factory()->create();

        // 🔹 Login sebagai user tersebut
        $response = $this->actingAs($user)->get('/dashboard');

        // 🔹 Cek hasil respons
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertSee('Dashboard');
        $response->assertSee('Total Reservasi');
    }
}
