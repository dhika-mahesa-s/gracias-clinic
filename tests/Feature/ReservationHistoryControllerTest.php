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
     * Pastikan elemen utama tampil di halaman customer (setelah login).
     */
    public function test_customer_history_has_main_sections_when_logged_in()
    {
        $response = $this->actingAs($this->customerUser)
            ->get(route('reservations.history'));

        $response->assertStatus(200);
        $response->assertSee('Total Reservasi');
        $response->assertSee('Selesai');
        $response->assertSee('Mendatang');
        $response->assertSee('Dibatalkan');
    }

    /**
     * Pastikan filter query di halaman customer tidak error (setelah login).
     */
    public function test_customer_history_filter_query_does_not_fail_when_logged_in()
    {
        $response = $this->actingAs($this->customerUser)
            ->get(route('reservations.history', ['status' => 'Selesai', 'search' => 'test'])); // Gunakan helper route

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
     * (Ini memerlukan middleware 'admin' atau cek role di controller/route)
     */
    public function test_admin_history_page_is_forbidden_for_customer()
    {
        // Asumsi middleware 'admin' akan return 403 Forbidden
        $response = $this->actingAs($this->customerUser)
            ->get(route('admin.reservations.history'));

        $response->assertStatus(403); // Atau 302 jika redirect ke halaman lain
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
     * Pastikan elemen utama tampil di halaman admin (setelah login admin).
     */
    public function test_admin_history_has_main_sections_when_logged_in_as_admin()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.reservations.history'));

        $response->assertStatus(200);
        $response->assertSee('Total Reservasi');
        $response->assertSee('Selesai');
        // ... (assertions lain jika perlu)
    }

    // Anda bisa menambahkan test lain di sini, misalnya:
    // - Test cancel reservation (sukses & gagal)
    // - Test show reservation detail (API endpoint)
    // - Test filter admin (memastikan data user lain muncul)
}