<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View; // <— tambahkan
use Illuminate\Contracts\View\View as ViewContract; // <— tambahkan
use Mockery; // <— tambahkan

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
/** @test */
public function registration_form_can_be_displayed()
{
    // (opsional) biar error asli tidak ditelan handler
    $this->withoutExceptionHandling();

    // Middleware ShareErrorsFromSession memanggil View::share('errors', ...)
    \Illuminate\Support\Facades\View::shouldReceive('share')
        ->zeroOrMoreTimes()
        ->andReturnNull();

    // Mock view yang dirender
    $fakeView = \Mockery::mock(\Illuminate\Contracts\View\View::class);
    $fakeView->shouldReceive('render')->once()->andReturn('OK');

    // Jangan kunci argumen data/mergeData
    \Illuminate\Support\Facades\View::shouldReceive('make')
        ->once()
        ->withArgs(function ($view/*, $data = [], $mergeData = [] */) {
            return $view === 'user.register';
        })
        ->andReturn($fakeView);

    $response = $this->get('/register');

    $response->assertOk()
             ->assertSee('OK'); // konten dari fake render()
}



    /** @test */
    public function user_can_register_and_is_logged_in_and_redirected_home()
    {
        $payload = [
            'name'                  => 'Jane Doe',
            'email'                 => 'jane@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        $response = $this->post('/register', $payload);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'name'  => 'Jane Doe',
        ]);

        $user = User::where('email', 'jane@example.com')->first();
        $this->assertTrue(Hash::check('secret123', $user->password));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function email_must_be_unique()
    {
        User::factory()->create(['email' => 'dup@example.com']);

        $response = $this->from('/register')->post('/register', [
            'name'                  => 'John',
            'email'                 => 'dup@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /** @test */
    public function password_must_be_confirmed_and_min_8_chars()
    {
        $resp1 = $this->from('/register')->post('/register', [
            'name'                  => 'John',
            'email'                 => 'john@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'NOT_MATCH',
        ]);
        $resp1->assertRedirect('/register');
        $resp1->assertSessionHasErrors(['password']);
        $this->assertGuest();

        $resp2 = $this->from('/register')->post('/register', [
            'name'                  => 'John',
            'email'                 => 'john2@example.com',
            'password'              => 'short',
            'password_confirmation' => 'short',
        ]);
        $resp2->assertRedirect('/register');
        $resp2->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    /** @test */
    public function name_email_and_password_are_required_and_email_must_be_valid()
    {
        $resp = $this->from('/register')->post('/register', []);
        $resp->assertRedirect('/register');
        $resp->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest();

        $resp2 = $this->from('/register')->post('/register', [
            'name'                  => 'John',
            'email'                 => 'not-an-email',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);
        $resp2->assertRedirect('/register');
        $resp2->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }
}
