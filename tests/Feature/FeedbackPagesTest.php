<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedbackPagesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    // ==================== INDEX PAGE TESTS ====================

    /** @test */
    public function index_page_loads_successfully()
    {
        $response = $this->get(route('feedback.index'));

        $response->assertStatus(200);
        $response->assertViewIs('feedback.index');
        $response->assertSee('Gracias Clinic');
        $response->assertSee('Kelola Feedback');
    }

    /** @test */
    public function index_page_displays_feedback_data_in_table()
    {
        $feedback = Feedback::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'service_type' => 'Facial',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
            'message' => 'Great service!',
        ]);

        $response = $this->get(route('feedback.index'));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('john@example.com');
        $response->assertSee('Facial');
        $response->assertSee('4.6'); // Average rating
    }

    /** @test */
    public function index_page_shows_search_functionality()
    {
        $response = $this->get(route('feedback.index'));

        $response->assertStatus(200);
        $response->assertSee('Cari nama...');
        $response->assertSee('Filter Bintang');
        $response->assertSee('Cari');
    }

    /** @test */
    public function index_page_search_works_correctly()
    {
        $feedback1 = Feedback::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'service_type' => 'Facial',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
        ]);

        $feedback2 = Feedback::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '081234567891',
            'service_type' => 'Massage',
            'staff_rating' => 4,
            'professional_rating' => 4,
            'result_rating' => 4,
            'return_rating' => 4,
            'overall_rating' => 4,
        ]);

        $response = $this->get(route('feedback.index', ['search' => 'John']));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    }

    /** @test */
    public function index_page_filter_by_rating_works()
    {
        $highRating = Feedback::create([
            'name' => 'High Rating User',
            'email' => 'high@example.com',
            'phone' => '081234567892',
            'service_type' => 'Facial',
            'staff_rating' => 5,
            'professional_rating' => 5,
            'result_rating' => 5,
            'return_rating' => 5,
            'overall_rating' => 5,
        ]);

        $lowRating = Feedback::create([
            'name' => 'Low Rating User',
            'email' => 'low@example.com',
            'phone' => '081234567893',
            'service_type' => 'Massage',
            'staff_rating' => 2,
            'professional_rating' => 2,
            'result_rating' => 2,
            'return_rating' => 2,
            'overall_rating' => 2,
        ]);

        $response = $this->get(route('feedback.index', ['rating_filter' => 4]));

        $response->assertStatus(200);
        $response->assertSee('High Rating User');
        $response->assertDontSee('Low Rating User');
    }

    /** @test */
    public function index_page_shows_empty_state_when_no_feedback()
    {
        Feedback::query()->delete();

        $response = $this->get(route('feedback.index'));

        $response->assertStatus(200);
        $response->assertSee('Belum ada feedback');
        $response->assertSee('Tambah Feedback Pertama');
    }

    /** @test */
    public function index_page_shows_action_buttons_for_each_feedback()
    {
        $feedback = Feedback::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'service_type' => 'Facial',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
        ]);

        $response = $this->get(route('feedback.index'));

        $response->assertStatus(200);
        $response->assertSee('fa-eye'); // Detail button
        $response->assertSee('fa-trash'); // Delete button
    }

    /** @test */
    public function index_page_shows_pagination_when_has_multiple_pages()
    {
        // Create more feedbacks than per page limit (10)
        for ($i = 1; $i <= 15; $i++) {
            Feedback::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'phone' => '08123456789' . $i,
                'service_type' => 'Service ' . $i,
                'staff_rating' => 5,
                'professional_rating' => 4,
                'result_rating' => 5,
                'return_rating' => 4,
                'overall_rating' => 5,
            ]);
        }

        $response = $this->get(route('feedback.index'));

        $response->assertStatus(200);
        $response->assertSee('pagination'); // Check pagination exists
    }

    // ==================== CREATE PAGE TESTS ====================

    /** @test */
    public function create_page_loads_successfully()
    {
        $response = $this->get(route('feedback.create'));

        $response->assertStatus(200);
        $response->assertViewIs('feedback.create');
        $response->assertSee('Better Care Starts');
        $response->assertSee('with Your Words');
        $response->assertSee('Nama');
        $response->assertSee('Email');
        $response->assertSee('Kirim Feedback');
    }

    /** @test */
    public function create_page_has_all_required_form_fields()
    {
        $response = $this->get(route('feedback.create'));

        $response->assertStatus(200);
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="phone"', false);
        $response->assertSee('name="service_type"', false);
        $response->assertSee('name="staff_rating"', false);
        $response->assertSee('name="professional_rating"', false);
        $response->assertSee('name="result_rating"', false);
        $response->assertSee('name="return_rating"', false);
        $response->assertSee('name="overall_rating"', false);
        $response->assertSee('name="message"', false);
    }

    /** @test */
    public function create_page_has_star_rating_functionality()
    {
        $response = $this->get(route('feedback.create'));

        $response->assertStatus(200);
        $response->assertSee('rating-stars');
        $response->assertSee('fa-star');
        $response->assertSee('data-field');
    }

    // ==================== SHOW PAGE TESTS ====================

    /** @test */
    public function show_page_loads_successfully()
    {
        $feedback = Feedback::create([
            'name' => 'Show User',
            'email' => 'show@example.com',
            'phone' => '081234567894',
            'service_type' => 'Laser',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
            'message' => 'Test message for show page',
        ]);

        $response = $this->get(route('feedback.show', $feedback->id));

        $response->assertStatus(200);
        $response->assertViewIs('feedback.show');
        $response->assertViewHas('feedback');
        $response->assertSee('Show User');
        $response->assertSee('show@example.com');
        $response->assertSee('Laser');
        $response->assertSee('Test message for show page');
    }

    /** @test */
    public function show_page_displays_all_rating_details()
    {
        $feedback = Feedback::create([
            'name' => 'Rating User',
            'email' => 'rating@example.com',
            'phone' => '081234567895',
            'service_type' => 'Facial',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 3,
            'return_rating' => 2,
            'overall_rating' => 1,
        ]);

        $response = $this->get(route('feedback.show', $feedback->id));

        $response->assertStatus(200);
        $response->assertSee('5'); // staff_rating
        $response->assertSee('4'); // professional_rating
        $response->assertSee('3'); // result_rating
        $response->assertSee('2'); // return_rating
        $response->assertSee('1'); // overall_rating
        $response->assertSee('3.0'); // average rating
    }

    /** @test */
    public function show_page_has_action_buttons()
    {
        $feedback = Feedback::create([
            'name' => 'Action User',
            'email' => 'action@example.com',
            'phone' => '081234567896',
            'service_type' => 'Massage',
            'staff_rating' => 5,
            'professional_rating' => 5,
            'result_rating' => 5,
            'return_rating' => 5,
            'overall_rating' => 5,
        ]);

        $response = $this->get(route('feedback.show', $feedback->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Feedback');
        $response->assertSee('Hapus Feedback');
        $response->assertSee(route('feedback.edit', $feedback->id));
    }

    // ==================== EDIT PAGE TESTS ====================

    /** @test */
    public function edit_page_loads_successfully()
    {
        $feedback = Feedback::create([
            'name' => 'Edit User',
            'email' => 'edit@example.com',
            'phone' => '081234567897',
            'service_type' => 'Injection',
            'staff_rating' => 4,
            'professional_rating' => 4,
            'result_rating' => 4,
            'return_rating' => 4,
            'overall_rating' => 4,
            'message' => 'Original message',
        ]);

        $response = $this->get(route('feedback.edit', $feedback->id));

        $response->assertStatus(200);
        $response->assertViewIs('feedback.edit');
        $response->assertViewHas('feedback');
        $response->assertSee('Edit Feedback');
        $response->assertSee('Edit User');
        $response->assertSee('edit@example.com');
        $response->assertSee('Injection');
        $response->assertSee('Original message');
    }

    /** @test */
    public function edit_page_prefills_form_with_existing_data()
    {
        $feedback = Feedback::create([
            'name' => 'Prefill User',
            'email' => 'prefill@example.com',
            'phone' => '081234567898',
            'service_type' => 'Konsultasi',
            'staff_rating' => 3,
            'professional_rating' => 3,
            'result_rating' => 3,
            'return_rating' => 3,
            'overall_rating' => 3,
        ]);

        $response = $this->get(route('feedback.edit', $feedback->id));

        $response->assertStatus(200);
        $response->assertSee('value="Prefill User"', false);
        $response->assertSee('value="prefill@example.com"', false);
        $response->assertSee('value="081234567898"', false);
        $response->assertSee('Konsultasi');
    }

    /** @test */
    public function edit_page_shows_current_rating_summary()
    {
        $feedback = Feedback::create([
            'name' => 'Summary User',
            'email' => 'summary@example.com',
            'phone' => '081234567899',
            'service_type' => 'Facial',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 3,
            'return_rating' => 2,
            'overall_rating' => 1,
        ]);

        $response = $this->get(route('feedback.edit', $feedback->id));

        $response->assertStatus(200);
        $response->assertSee('Ringkasan Rating Saat Ini');
        $response->assertSee('5'); // staff_rating
        $response->assertSee('4'); // professional_rating
        $response->assertSee('3'); // result_rating
        $response->assertSee('2'); // return_rating
        $response->assertSee('1'); // overall_rating
        $response->assertSee('3.0'); // average
    }
}