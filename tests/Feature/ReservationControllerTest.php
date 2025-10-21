<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Matikan semua side-effect yang sering memicu 500 di test
        Mail::fake();
        Notification::fake();
        Event::fake();     // jika controller mem-broadcast/event
        Queue::fake();     // jika ada job dispatch
    }

    /** @test */
    public function dapat_menampilkan_halaman_reservasi()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('reservasi.index'));
        $response->assertStatus(200);
        $response->assertViewIs('reservasi.index');
        $response->assertViewHas(['treatments', 'doctors']);
    }

    /** @test */
    public function gagal_menyimpan_reservasi_jika_data_tidak_valid()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('reservasi.store'), []);
        $response->assertStatus(422);
    }

    /** @test */
    public function berhasil_menyimpan_reservasi_dengan_data_valid()
    {
        // Kunci "sekarang" supaya day_of_week & jam konsisten
        Carbon::setTestNow(Carbon::create(2025, 10, 21, 10, 0, 0)); // Selasa, 10:00

        $user = User::factory()->create();
        $this->actingAs($user);

        $doctor    = Doctor::factory()->create(['status' => 'active']);
        $treatment = Treatment::factory()->create(['price' => 200000]);

        // day_of_week disamakan dengan hari ini (format 'l' → English day name)
        $schedule = Schedule::factory()->create([
            'doctor_id'   => $doctor->id,
            'day_of_week' => Carbon::now()->format('l'), // e.g. 'Tuesday'
            'start_time'  => '09:00:00',
            'end_time'    => '17:00:00',
            'quota'       => 10,
            'status'      => 'available',
        ]);

        $payload = [
            'doctor_id'    => $doctor->id,
            'treatment_id' => $treatment->id,
            'schedule_id'  => $schedule->id,
            'date'         => Carbon::now()->toDateString(), // 2025-10-21
            'time'         => '10:00',
            'name'         => 'Test User',
            'email'        => 'test@example.com',
            'phone'        => '0812345678',
        ];

        // (opsional saat debug) buka komentar ini untuk melihat exception sebenarnya
        // $this->withoutExceptionHandling();

        $response = $this->postJson(route('reservasi.store'), $payload);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        // Kolom nama pelanggan bisa 'customer_name' atau 'name' tergantung skema
        $nameColumn = Schema::hasColumn('reservations', 'customer_name') ? 'customer_name' : (Schema::hasColumn('reservations', 'name') ? 'name' : null);

        $expected = [
            'doctor_id'    => $doctor->id,
            'treatment_id' => $treatment->id,
            'schedule_id'  => $schedule->id,
            'user_id'      => $user->id,
        ];
        if ($nameColumn) {
            $expected[$nameColumn] = 'Test User';
        }

        $this->assertDatabaseHas('reservations', $expected);
    }

    /** @test */
    public function gagal_menyimpan_jika_jadwal_dokter_tidak_sesuai()
    {
        Carbon::setTestNow(Carbon::create(2025, 10, 21, 10, 0, 0)); // Selasa

        $this->actingAs(User::factory()->create());

        $doctor    = Doctor::factory()->create(['status' => 'active']);
        $treatment = Treatment::factory()->create();

        // Tidak membuat schedule yang cocok dengan jam 23:00 → harus gagal
        $payload = [
            'doctor_id'    => $doctor->id,
            'treatment_id' => $treatment->id,
            'date'         => Carbon::now()->toDateString(),
            'time'         => '23:00',
            'name'         => 'User Test',
            'email'        => 'user@test.com',
            'phone'        => '0812345678',
        ];

        $response = $this->postJson(route('reservasi.store'), $payload);

        $response->assertStatus(200)      // controller mengembalikan 200 + success:false (umum)
                 ->assertJson(['success' => false]);
    }
}