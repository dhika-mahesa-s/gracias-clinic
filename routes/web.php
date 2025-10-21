<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Customer\FaqController as CustomerFaqController;


// ==========================
// LANDING PAGE
// ==========================
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ tambahkan route reservasi di sini
Route::middleware(['auth'])->group(function () {
    Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/jadwal/{doctor}/{date}', [ReservationController::class, 'getSchedule']);
});

require __DIR__.'/auth.php';
// ==========================
// FEEDBACK (User Side)
// ==========================
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/thankyou', [FeedbackController::class, 'thankyou'])->name('feedback.thankyou');

// ==========================
// FEEDBACK RESOURCE (CRUD)
// ==========================
Route::resource('feedback', FeedbackController::class);

// ==========================
// ADMIN FEEDBACK
// ==========================

Route::prefix('admin')->group(function () {
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::post('/feedback/{id}/toggle-visibility', [AdminFeedbackController::class, 'toggleVisibility'])->name('admin.feedback.toggle');
});

Route::prefix('admin')->group(function () {
    Route::get('/faq', [AdminFaqController::class, 'index']);
    Route::get('/faq/create', [AdminFaqController::class, 'create']);
    Route::post('/faq', [AdminFaqController::class, 'store']);
    Route::get('/faq/{id}/edit', [AdminFaqController::class, 'edit']);
    Route::put('/faq/{id}', [AdminFaqController::class, 'update']);
    Route::delete('/faq/{id}', [AdminFaqController::class, 'destroy']);
});

// ==========================
// CUSTOMER FAQ
// ==========================
Route::get('/faq', [CustomerFaqController::class, 'index']);

// Route untuk dashboard admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
