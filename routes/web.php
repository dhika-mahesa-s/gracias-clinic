<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservasiController;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\RiwayatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('/reservasi', ReservasiController::class);
Route::resource('/treatment', TreatmentController::class);
Route::resource('/feedback', FeedbackController::class);
Route::resource('/faq', FaqController::class);
Route::resource('/riwayat', RiwayatController::class);
});

