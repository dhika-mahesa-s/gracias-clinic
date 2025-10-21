<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationHistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * Pastikan halaman riwayat reservasi bisa diakses (public).
     */
    public function test_reservation_history_page_is_accessible()
    {
        $response = $this->get('/riwayat-reservasi');
        $response->assertStatus(200);
        $response->assertSee('Riwayat Reservasi');
    }

    /**
     * Pastikan elemen utama tampil di halaman (judul dan bagian statistik).
     */
    public function test_reservation_history_has_main_sections()
    {
        $response = $this->get('/riwayat-reservasi');

        $response->assertSee('Total Reservasi');
        $response->assertSee('Selesai');
        $response->assertSee('Dibatalkan');
        $response->assertSee('Mendatang');
    }

    /**
     * Pastikan halaman bisa diakses meskipun tidak login.
     */
    public function test_reservation_history_is_accessible_without_login()
    {
        $response = $this->get('/riwayat-reservasi');
        $response->assertStatus(200);
        $response->assertDontSee('Silakan login');
    }

    /**
     * Pastikan halaman bisa menerima filter query (tanpa error).
     */
    public function test_reservation_history_filter_query_does_not_fail()
    {
        $response = $this->get('/riwayat-reservasi?status=Selesai&date=2025-10-20&search=test');
        $response->assertStatus(200);
    }

    /**
     * Pastikan halaman tidak error meskipun database kosong.
     */
    public function test_reservation_history_handles_empty_database_gracefully()
    {
        $response = $this->get('/riwayat-reservasi');
        $response->assertStatus(200);
        $response->assertSee('Total Reservasi');
    }
}
