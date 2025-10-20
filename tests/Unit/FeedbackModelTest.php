<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedbackModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function feedback_can_be_created_with_all_fields()
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
            'message' => 'Great service!',
        ]);

        $this->assertDatabaseHas('feedbacks', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'service_type' => 'Facial',
        ]);
    }

    /** @test */
    public function feedback_can_be_created_without_optional_fields()
    {
        $feedback = Feedback::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
        ]);

        $this->assertDatabaseHas('feedbacks', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->assertNull($feedback->phone);
        $this->assertNull($feedback->service_type);
        $this->assertNull($feedback->message);
    }

    /** @test */
    public function average_rating_is_calculated_correctly()
    {
        $feedback = Feedback::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 3,
            'return_rating' => 2,
            'overall_rating' => 1,
        ]);

        $expectedAverage = (5 + 4 + 3 + 2 + 1) / 5;
        
        $this->assertEquals($expectedAverage, $feedback->average_rating);
    }

    /** @test */
    public function feedback_has_correct_attributes()
    {
        $feedback = Feedback::create([
            'name' => 'Attribute User',
            'email' => 'attribute@example.com',
            'phone' => '081234567891',
            'service_type' => 'Injection',
            'staff_rating' => 5,
            'professional_rating' => 4,
            'result_rating' => 5,
            'return_rating' => 4,
            'overall_rating' => 5,
            'message' => 'Test message',
        ]);

        $this->assertEquals('Attribute User', $feedback->name);
        $this->assertEquals('attribute@example.com', $feedback->email);
        $this->assertEquals('081234567891', $feedback->phone);
        $this->assertEquals('Injection', $feedback->service_type);
        $this->assertEquals(5, $feedback->staff_rating);
        $this->assertEquals(4, $feedback->professional_rating);
        $this->assertEquals(5, $feedback->result_rating);
        $this->assertEquals(4, $feedback->return_rating);
        $this->assertEquals(5, $feedback->overall_rating);
        $this->assertEquals('Test message', $feedback->message);
    }
}