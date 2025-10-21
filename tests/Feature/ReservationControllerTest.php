<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mockery;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dapat_menampilkan_halaman_reservasi()
    {
        $this->withoutExceptionHandling();

        $user = \App\Models\User::factory()->create(); // buat user baru
        $this->actingAs($user); // login sebagai user ini
        
        $response = $this->get(route('reservasi.index'));
        $response->assertStatus(200);
        $response->assertViewIs('reservasi.index');
        $response->assertViewHas(['treatments', 'doctors']);
    }

    /** @test */
    public function gagal_menyimpan_reservasi_jika_data_tidak_valid()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        $response = $this->postJson(route('reservasi.store'), []);
        $response->assertStatus(422); // Laravel validation error
    }

    /** @test */
    public function berhasil_menyimpan_reservasi_dengan_data_valid()
    {
        $this->actingAs(\App\Models\User::factory()->create());

        $doctor = Doctor::factory()->create(['status' => 'active']);
        $treatment = Treatment::factory()->create(['price' => 200000]);
        $schedule = Schedule::factory()->create([
            'doctor_id' => $doctor->id,
            'day_of_week' => Carbon::now()->format('l'),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        $payload = [
            'doctor_id' => $doctor->id,
            'treatment_id' => $treatment->id,
            'date' => Carbon::now()->format('Y-m-d'),
            'time' => '10:00',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0812345678',
        ];

        $response = $this->postJson(route('reservasi.store'), $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('reservations', [
            'customer_name' => 'Test User',
            'doctor_id' => $doctor->id,
            'treatment_id' => $treatment->id,
        ]);
    }

    /** @test */
    public function gagal_menyimpan_jika_jadwal_dokter_tidak_sesuai()
    {
        $this->actingAs(\App\Models\User::factory()->create());

        $doctor = Doctor::factory()->create(['status' => 'active']);
        $treatment = Treatment::factory()->create();

        $payload = [
            'doctor_id' => $doctor->id,
            'treatment_id' => $treatment->id,
            'date' => Carbon::now()->format('Y-m-d'),
            'time' => '23:00',
            'name' => 'User Test',
            'email' => 'user@test.com',
            'phone' => '0812345678',
        ];

        $response = $this->postJson(route('reservasi.store'), $payload);
        $response->assertJson(['success' => false]);
    }
}
