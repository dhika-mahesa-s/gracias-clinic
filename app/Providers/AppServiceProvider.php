<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    

public function boot(): void
{
    View::composer('*', function ($view) {
        $hasReservation = false;

        if (Auth::check()) {
            $hasReservation = Reservation::where('user_id', Auth::id())->exists();
        }

        $view->with('hasReservation', $hasReservation);
    });
}

}
