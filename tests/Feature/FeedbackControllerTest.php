<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedbackControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    // ==================== STORE METHOD TESTS ====================

    /** @test */
    public function user_can_create_new_feedback()
    {
        $feedbackData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'service_type' => 'Facial Treatment',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
            'message' => 'Excellent service!',
        ];

        $response = $this->post(route('feedback.store'), $feedbackData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Terima kasih sudah bersuara!');
        
        $this->assertDatabaseHas('feedbacks', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'service_type' => 'Facial Treatment',
        ]);
    }

    /** @test */
    public function feedback_creation_requires_name_email_and_ratings()
    {
        $response = $this->post(route('feedback.store'), []);

        $response->assertSessionHasErrors([
            'name', 
            'email', 
            'staff_rating',
            'professional_rating',
            'result_rating',
            'return_rating',
            'overall_rating'
        ]);
    }

    /** @test */
    public function feedback_creation_validates_email_format()
    {
        $response = $this->post(route('feedback.store'), [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function feedback_creation_validates_rating_range()
    {
        $response = $this->post(route('feedback.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'staff_rating' => 6, // Invalid - above max
            'professional_rating' => 0, // Invalid - below min
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
        ]);

        $response->assertSessionHasErrors(['staff_rating', 'professional_rating']);
    }

    // ==================== UPDATE METHOD TESTS ====================

    /** @test */
    public function user_can_update_feedback()
    {
        $feedback = Feedback::create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'phone' => '081234567891',
            'service_type' => 'Original Service',
            'staff_rating' => 3,
            'professional_rating' => 3,
            'result_rating' => 3,
            'return_rating' => 3,
            'overall_rating' => 3,
            'message' => 'Original message',
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '081234567899',
            'service_type' => 'Updated Service',
            'staff_rating' => 4,
            'professional_rating' => 4,
            'result_rating' => 4,
            'return_rating' => 4,
            'overall_rating' => 4,
            'message' => 'Updated message',
        ];

        $response = $this->put(route('feedback.update', $feedback->id), $updateData);

        $response->assertRedirect(route('feedback.index'));
        $response->assertSessionHas('success', 'Feedback berhasil diperbarui!');
        
        $this->assertDatabaseHas('feedbacks', [
            'id' => $feedback->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'service_type' => 'Updated Service',
        ]);
    }

    /** @test */
    public function update_requires_valid_data()
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

        $response = $this->put(route('feedback.update', $feedback->id), []);

        $response->assertSessionHasErrors([
            'name', 
            'email', 
            'staff_rating',
            'professional_rating',
            'result_rating',
            'return_rating',
            'overall_rating'
        ]);
    }

    // ==================== DESTROY METHOD TESTS ====================

    /** @test */
    public function user_can_delete_feedback()
    {
        $feedback = Feedback::create([
            'name' => 'Delete User',
            'email' => 'delete@example.com',
            'phone' => '081234567892',
            'service_type' => 'Hair Treatment',
            'staff_rating' => 5,
            'professional_rating' => 5,
            'result_rating' => 5,
            'return_rating' => 5,
            'overall_rating' => 5,
        ]);

        $response = $this->delete(route('feedback.destroy', $feedback->id));

        $response->assertRedirect(route('feedback.index'));
        $response->assertSessionHas('success', 'Feedback berhasil dihapus!');
        
        $this->assertDatabaseMissing('feedbacks', [
            'id' => $feedback->id
        ]);
    }

    /** @test */
    public function deleting_nonexistent_feedback_returns_404()
    {
        $response = $this->delete(route('feedback.destroy', 999));

        $response->assertStatus(404);
    }

    // ==================== CONTROLLER METHOD TESTS ====================

    /** @test */
    public function index_method_returns_paginated_feedbacks()
    {
        // Create 15 feedbacks
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
        $response->assertViewHas('feedbacks');
        
        $feedbacks = $response->viewData('feedbacks');
        $this->assertCount(10, $feedbacks); // Default pagination per page
    }

    /** @test */
    public function show_method_returns_correct_feedback()
    {
        $feedback = Feedback::create([
            'name' => 'Show Method User',
            'email' => 'showmethod@example.com',
            'phone' => '081234567893',
            'service_type' => 'Laser',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
        ]);

        $response = $this->get(route('feedback.show', $feedback->id));

        $response->assertStatus(200);
        $response->assertViewHas('feedback');
        
        $viewFeedback = $response->viewData('feedback');
        $this->assertEquals($feedback->id, $viewFeedback->id);
        $this->assertEquals('Show Method User', $viewFeedback->name);
    }

    /** @test */
    public function create_method_returns_create_view()
    {
        $response = $this->get(route('feedback.create'));

        $response->assertStatus(200);
        $response->assertViewIs('feedback.create');
    }

    /** @test */
    public function edit_method_returns_edit_view_with_feedback()
    {
        $feedback = Feedback::create([
            'name' => 'Edit Method User',
            'email' => 'editmethod@example.com',
            'phone' => '081234567894',
            'service_type' => 'Massage',
            'staff_rating' => 4,
            'professional_rating' => 4,
            'result_rating' => 4,
            'return_rating' => 4,
            'overall_rating' => 4,
        ]);

        $response = $this->get(route('feedback.edit', $feedback->id));

        $response->assertStatus(200);
        $response->assertViewIs('feedback.edit');
        $response->assertViewHas('feedback');
        
        $viewFeedback = $response->viewData('feedback');
        $this->assertEquals($feedback->id, $viewFeedback->id);
    }
}