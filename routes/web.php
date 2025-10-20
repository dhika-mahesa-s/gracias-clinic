<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationHistoryController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reservations/create', [ReservationHistoryController::class, 'create'])->name('reservations.create');
Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'index'])->name('reservations.history');
Route::get('/reservations/{reservation}', [ReservationHistoryController::class, 'show'])->name('reservations.show');
Route::post('/reservations/{reservation}/cancel', [ReservationHistoryController::class, 'cancel'])->name('reservations.cancel');