<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_all_reservations()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $reservation = Reservation::factory()->create();

        $response = $this->get(route('reservasi.admin'));
        $response->assertStatus(200);
        $response->assertViewIs('reservasi.admin');
        $response->assertViewHas('reservations');
    }

    /** @test */
    public function admin_can_confirm_pending_reservation()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $reservation = Reservation::factory()->create(['status' => 'pending']);

        $response = $this->post(route('admin.reservasi.konfirmasi', $reservation->id));
        $response->assertRedirect();

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'confirmed'
        ]);
    }

    /** @test */
    public function admin_cannot_reconfirm_already_confirmed_reservation()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $reservation = Reservation::factory()->create(['status' => 'confirmed']);

        $response = $this->post(route('admin.reservasi.konfirmasi', $reservation->id));

        $response->assertSessionHas('info', 'Reservasi sudah dikonfirmasi.');
    }
}
