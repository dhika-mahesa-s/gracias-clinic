<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;

Route::get('/tes', function () {
    return 'Route Berhasil!';
});

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
