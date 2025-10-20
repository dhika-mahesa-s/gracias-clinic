<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\TreatmentController;

Route::get('/', fn() => redirect()->route('treatments.index'));

Route::prefix('treatments')->group(function () {
    Route::get('/', [TreatmentController::class, 'index'])->name('treatments.index');
    Route::get('/{treatment}', [TreatmentController::class, 'show'])->name('treatments.show');
    Route::get('/reservasi', fn() => view('reservasi'))->name('treatments.reservasi');

    // Admin / Management
    Route::get('/manage/list', [TreatmentController::class, 'manage'])->name('treatments.manage');
    Route::get('/manage/create', [TreatmentController::class, 'create'])->name('treatments.create');
    Route::post('/manage/store', [TreatmentController::class, 'store'])->name('treatments.store');
    Route::delete('/manage/{treatment}', [TreatmentController::class, 'destroy'])->name('treatments.destroy');

      // NEW: edit & update
    Route::get('/manage/{treatment}/edit', [TreatmentController::class, 'edit'])->name('treatments.edit');
    Route::put('/manage/{treatment}',      [TreatmentController::class, 'update'])->name('treatments.update');
});

Route::get('/', function () {
    return view('welcome');
});

