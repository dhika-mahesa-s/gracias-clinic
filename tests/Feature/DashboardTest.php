<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Reservation;
use App\Models\Treatment;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Schedule;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function dashboard_page_can_be_loaded_successfully()
    {
        $user = User::factory()->create();

        // jika route admin dilindungi auth, aktifkan login user
        $this->actingAs($user);

        $doctor = Doctor::factory()->create();
        $treatment = Treatment::factory()->create();
        $schedule = Schedule::factory()->create([
            'doctor_id' => $doctor->id,
            'day_of_week' => Carbon::now()->format('l'),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'quota' => 10,
            'status' => 'available',
        ]);

        Reservation::factory()->create([
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'treatment_id' => $treatment->id,
            'schedule_id' => $schedule->id,
            'reservation_date' => Carbon::today(),
            'status' => 'completed',
            'total_price' => 150000,
        ]);

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHasAll([
            'reservationsToday',
            'totalRevenue',
            'newVisitorsThisMonth',
            'reservationsByMonth',
            'reservationsByStatus',
            'reservationsByTreatment',
        ]);
    }

    /** @test */
    public function it_calculates_dashboard_data_correctly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $doctor = Doctor::factory()->create();
        $treatment = Treatment::factory()->create();
        $schedule = Schedule::factory()->create([
            'doctor_id' => $doctor->id,
            'day_of_week' => Carbon::now()->format('l'),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'quota' => 10,
            'status' => 'available',
        ]);

        Reservation::factory()->create([
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'treatment_id' => $treatment->id,
            'schedule_id' => $schedule->id,
            'reservation_date' => Carbon::today(),
            'status' => 'completed',
            'total_price' => 200000,
            'customer_email' => 'client1@test.com',
        ]);

        Reservation::factory()->create([
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'treatment_id' => $treatment->id,
            'schedule_id' => $schedule->id,
            'reservation_date' => Carbon::now()->subDays(3),
            'status' => 'pending',
            'total_price' => 100000,
            'customer_email' => 'client2@test.com',
        ]);

        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);

        $data = $response->original->getData();

        $this->assertEquals(1, $data['reservationsToday']);
        $this->assertEquals(200000, $data['totalRevenue']);
        $this->assertEquals(2, $data['newVisitorsThisMonth']);
    }

    /** @test */
    public function it_can_generate_pdf_report_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $doctor = Doctor::factory()->create();
        $treatment = Treatment::factory()->create();
        $schedule = Schedule::factory()->create([
            'doctor_id' => $doctor->id,
            'day_of_week' => Carbon::now()->format('l'),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'quota' => 10,
            'status' => 'available',
        ]);

        Reservation::factory()->create([
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'treatment_id' => $treatment->id,
            'schedule_id' => $schedule->id,
            'reservation_date' => Carbon::today(),
            'status' => 'completed',
            'total_price' => 300000,
        ]);

        Pdf::shouldReceive('loadView')
            ->once()
            ->andReturnSelf();

        Pdf::shouldReceive('download')
            ->once()
            ->with('laporan-dashboard.pdf')
            ->andReturn(response('pdf content', 200));

        $response = $this->get(route('admin.dashboard.downloadReport'));
        $response->assertStatus(200);
    }
}