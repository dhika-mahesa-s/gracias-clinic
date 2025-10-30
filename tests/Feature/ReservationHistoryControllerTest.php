<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User; // Import User model
use App\Models\Reservation; // Import Reservation model (jika perlu membuat data)

class ReservationHistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $customerUser;
    protected $adminUser;

    /**
     * Setup method untuk membuat user sebelum setiap test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Buat user customer biasa
        $this->customerUser = User::factory()->create(['role' => 'customer']);
        // Buat user admin (asumsikan ada kolom 'role' di tabel users)
        $this->adminUser = User::factory()->create(['role' => 'admin']);

        // Menjalankan seeder Anda (opsional, tapi disarankan jika Anda punya data dummy)
        // $this->seed(\Database\Seeders\ReservationSeeder::class);
    }

    // ===================================
    // TEST UNTUK CUSTOMER VIEW (/riwayat-reservasi)
    // ===================================

    /**
     * Pastikan halaman riwayat customer TIDAK bisa diakses tanpa login (redirect ke login).
     */
    public function test_customer_history_page_redirects_if_not_logged_in()
    {
        $response = $this->get(route('reservations.history')); // Menggunakan nama route
        $response->assertStatus(302); // Status 302 = Redirect
        $response->assertRedirect(route('login')); // Harus redirect ke halaman login
    }

    /**
     * Pastikan halaman riwayat customer BISA diakses SETELAH login sebagai customer.
     */
    public function test_customer_history_page_is_accessible_when_logged_in()
    {
        $response = $this->actingAs($this->customerUser) // Simulasi login sebagai customer
            ->get(route('reservations.history'));

        $response->assertStatus(200);
        $response->assertSee('Riwayat Reservasi'); // Judul halaman customer
    }

    /**
     * Pastikan elemen utama (5 kartu stats) tampil di halaman customer (setelah login).
     */
    public function test_customer_history_has_main_sections_when_logged_in()
    {
        $response = $this->actingAs($this->customerUser)
            ->get(route('reservations.history'));

        $response->assertStatus(200);
        $response->assertSee('Total Reservasi');
        $response->assertSee('Pending'); // REVISI: Tambahkan cek 'Pending'
        $response->assertSee('Mendatang');
        $response->assertSee('Selesai');
        $response->assertSee('Dibatalkan');
    }

    /**
     * Pastikan filter query (dengan status huruf kecil) di halaman customer tidak error.
     */
    public function test_customer_history_filter_query_does_not_fail_when_logged_in()
    {
        $response = $this->actingAs($this->customerUser)
            // REVISI: Gunakan status huruf kecil sesuai <select>
            ->get(route('reservations.history', ['status' => 'completed', 'search' => 'test']));

        $response->assertStatus(200);
    }

    // ===================================
    // TEST UNTUK ADMIN VIEW (/admin/riwayat-reservasi)
    // ===================================

    /**
     * Pastikan halaman riwayat admin TIDAK bisa diakses tanpa login.
     */
    public function test_admin_history_page_redirects_if_not_logged_in()
    {
        $response = $this->get(route('admin.reservations.history'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /**
     * Pastikan halaman riwayat admin TIDAK bisa diakses oleh customer biasa.
     */
    public function test_admin_history_page_is_forbidden_for_customer()
    {
        // Asumsi middleware 'check.admin' (atau nama alias Anda) mengembalikan 403 Forbidden
        $response = $this->actingAs($this->customerUser)
            ->get(route('admin.reservations.history'));

        $response->assertStatus(403);
    }

    /**
     * Pastikan halaman riwayat admin BISA diakses oleh admin.
     */
    public function test_admin_history_page_is_accessible_for_admin()
    {
        $response = $this->actingAs($this->adminUser) // Simulasi login sebagai admin
            ->get(route('admin.reservations.history'));

        $response->assertStatus(200);
        $response->assertSee('Manajemen Reservasi'); // Judul halaman admin
    }

    /**
     * Pastikan elemen utama (5 kartu stats) tampil di halaman admin.
     */
    public function test_admin_history_has_main_sections_when_logged_in_as_admin()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.reservations.history'));

        $response->assertStatus(200);
        $response->assertSee('Total Reservasi');
        $response->assertSee('Pending'); // REVISI: Tambahkan cek 'Pending'
        $response->assertSee('Mendatang');
        $response->assertSee('Selesai');
        $response->assertSee('Dibatalkan');
    }
}
