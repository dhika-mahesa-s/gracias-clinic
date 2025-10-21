<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationFactoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function reservation_factory_works_and_creates_relations()
    {
        $reservation = Reservation::factory()->create();

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'pending'
        ]);

        $this->assertNotNull($reservation->doctor);
        $this->assertNotNull($reservation->treatment);
        $this->assertNotNull($reservation->schedule);
        $this->assertNotNull($reservation->user);
    }
}
