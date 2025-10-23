<?php

namespace Tests\Unit\Http\Controllers\Auth;

use App\Http\Controllers\Auth\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Mockery;
use Tests\TestCase;

class PasswordResetControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function show_link_request_form_returns_forget_password_view()
    {
        $fakeView = Mockery::mock(ViewContract::class);
        View::shouldReceive('make')
            ->once()
            ->with('user.forget-password', [], [])
            ->andReturn($fakeView);

        $controller = new PasswordResetController();
        $response = $controller->showLinkRequestForm();

        $this->assertSame($fakeView, $response);
    }

    /** @test */
    public function send_reset_link_email_success_flashes_status_and_redirects_back()
    {
        // Mock broker: sukses kirim link
        Password::shouldReceive('sendResetLink')
            ->once()
            ->with(['email' => 'jane@example.com'])
            ->andReturn(Password::RESET_LINK_SENT);

        // Mock redirect()->back() -> RedirectResponse
        $redirectResponse = Mockery::mock(RedirectResponse::class);
        $redirectResponse->shouldReceive('with')
            ->once()
            ->with(Mockery::on(function ($data) {
                // Pastikan status diflash dengan terjemahan kunci status
                return isset($data['status']) && $data['status'] === __(Password::RESET_LINK_SENT);
            }))
            ->andReturnSelf();

        $redirector = Mockery::mock(Redirector::class);
        $redirector->shouldReceive('back')
            ->once()
            ->andReturn($redirectResponse);

        // Bind redirector ke container agar helper back() memakai mock ini
        $this->app->instance('redirect', $redirector);

        $request = Request::create('/forgot-password', 'POST', [
            'email' => 'jane@example.com',
        ]);

        $controller = new PasswordResetController();
        $response = $controller->sendResetLinkEmail($request);

        $this->assertSame($redirectResponse, $response);
    }

    /** @test */
    public function send_reset_link_email_failure_flashes_error_on_email_and_redirects_back()
    {
        // Mock broker: gagal (mis. email tidak terdaftar)
        Password::shouldReceive('sendResetLink')
            ->once()
            ->with(['email' => 'unknown@example.com'])
            ->andReturn(Password::INVALID_USER);

        $redirectResponse = Mockery::mock(RedirectResponse::class);
        $redirectResponse->shouldReceive('withErrors')
            ->once()
            ->with(Mockery::on(function ($errors) {
                return isset($errors['email']) && $errors['email'] === __(Password::INVALID_USER);
            }))
            ->andReturnSelf();

        $redirector = Mockery::mock(Redirector::class);
        $redirector->shouldReceive('back')
            ->once()
            ->andReturn($redirectResponse);
        $this->app->instance('redirect', $redirector);

        $request = Request::create('/forgot-password', 'POST', [
            'email' => 'unknown@example.com',
        ]);

        $controller = new PasswordResetController();
        $response = $controller->sendResetLinkEmail($request);

        $this->assertSame($redirectResponse, $response);
    }

    /** @test */
    public function send_reset_link_email_requires_valid_email()
    {
        $request = Request::create('/forgot-password', 'POST', [
            'email' => 'not-an-email',
        ]);

        $controller = new PasswordResetController();

        $this->expectException(ValidationException::class);
        $controller->sendResetLinkEmail($request);
    }

    /** @test */
    public function send_reset_link_email_requires_email_field()
    {
        $request = Request::create('/forgot-password', 'POST', []); // kosong

        $controller = new PasswordResetController();

        $this->expectException(ValidationException::class);
        $controller->sendResetLinkEmail($request);
    }
}
