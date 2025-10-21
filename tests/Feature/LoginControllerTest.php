<?php

namespace Tests\Unit\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Contracts\Session\Session as SessionContract;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View; // <— pakai Facade View, bukan bind container
use Illuminate\Validation\ValidationException;
use Mockery;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function show_login_form_returns_user_login_view()
    {
        // Mock hanya method make() via Facade View
        $mockView = Mockery::mock(ViewContract::class);

        View::shouldReceive('make')
            ->once()
            ->with('user.login', [], [])
            ->andReturn($mockView);

        $controller = new LoginController();

        $response = $controller->showLoginForm();

        $this->assertSame($mockView, $response);
    }

    /** @test */
    public function login_succeeds_with_valid_credentials_and_remember_true()
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'john@example.com', 'password' => 'secret'], true)
            ->andReturn(true);

        $session = Mockery::mock(SessionContract::class);
        $session->shouldReceive('regenerate')->once();

        $request = Request::create('/login', 'POST', [
            'email' => 'john@example.com',
            'password' => 'secret',
            'remember' => '1', // -> boolean(true)
        ]);
        $request->setLaravelSession($session);

        $controller = new LoginController();

        $response = $controller->login($request);

        $this->assertTrue(method_exists($response, 'getTargetUrl'));
        $this->assertEquals(url('/'), $response->getTargetUrl()); // redirect()->intended('/')
        $this->assertEquals(302, $response->getStatusCode());
    }

    /** @test */
    public function login_succeeds_with_valid_credentials_and_remember_false_by_default()
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'jane@example.com', 'password' => 'topsecret'], false)
            ->andReturn(true);

        $session = Mockery::mock(SessionContract::class);
        $session->shouldReceive('regenerate')->once();

        $request = Request::create('/login', 'POST', [
            'email' => 'jane@example.com',
            'password' => 'topsecret',
        ]);
        $request->setLaravelSession($session);

        $controller = new LoginController();

        $response = $controller->login($request);

        $this->assertEquals(url('/'), $response->getTargetUrl());
        $this->assertEquals(302, $response->getStatusCode());
    }

    /** @test */
    public function login_fails_with_incorrect_credentials_and_throws_validation_exception_on_email()
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'bad@example.com', 'password' => 'wrong'], false)
            ->andReturn(false);

        $request = Request::create('/login', 'POST', [
            'email' => 'bad@example.com',
            'password' => 'wrong',
        ]);

        $controller = new LoginController();

        try {
            $controller->login($request);
            $this->fail('Expected ValidationException not thrown.');
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $this->assertArrayHasKey('email', $errors);
            $this->assertSame('The provided credentials are incorrect.', $errors['email'][0]);
        }
    }

    /** @test */
    public function logout_logs_out_and_invalidates_session_and_redirects_home()
    {
        Auth::shouldReceive('logout')->once();

        $session = Mockery::mock(SessionContract::class);
        $session->shouldReceive('invalidate')->once();
        $session->shouldReceive('regenerateToken')->once();

        $request = Request::create('/logout', 'POST');
        $request->setLaravelSession($session);

        $controller = new LoginController();

        $response = $controller->logout($request);

        $this->assertTrue(method_exists($response, 'getTargetUrl'));
        $this->assertEquals(url('/'), $response->getTargetUrl());
        $this->assertEquals(302, $response->getStatusCode());
    }
}
