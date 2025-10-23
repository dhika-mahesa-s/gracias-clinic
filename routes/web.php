<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Customer\FaqController as CustomerFaqController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\ReservationHistoryController;

// ==========================
// LANDING PAGE
// ==========================
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');
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


Route::prefix('treatments')->group(function () {
    Route::get('/', [TreatmentController::class, 'index'])->name('treatments.index');
    Route::get('/{treatment}', [TreatmentController::class, 'show'])->name('treatments.show');
    
    // Admin / Management
    Route::get('/manage/list', [TreatmentController::class, 'manage'])->name('treatments.manage');
    Route::get('/manage/create', [TreatmentController::class, 'create'])->name('treatments.create');
    Route::post('/manage/store', [TreatmentController::class, 'store'])->name('treatments.store');
    Route::delete('/manage/{treatment}', [TreatmentController::class, 'destroy'])->name('treatments.destroy');

      // NEW: edit & update
    Route::get('/manage/{treatment}/edit', [TreatmentController::class, 'edit'])->name('treatments.edit');
    Route::put('/manage/{treatment}',      [TreatmentController::class, 'update'])->name('treatments.update');
});

// ==========================
// AUTH ROUTES
// ==========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register Routes
use App\Http\Controllers\Auth\RegisterController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Password Reset Routes
use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');



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

// ==========================
// ADMIN FAQ
// ==========================
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

Route::middleware(['auth'])->group(function () {
    Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/jadwal/{doctor}/{date}', [ReservationController::class, 'getSchedule']);
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/reservasi', [ReservationAdminController::class, 'index'])->name('reservasi.admin');
    Route::post('/reservasi/{id}/konfirmasi', [ReservationAdminController::class, 'konfirmasi'])->name('admin.reservasi.konfirmasi');
});

Route::get('/reservations/create', [ReservationHistoryController::class, 'create'])->name('reservations.create');
Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'index'])->name('reservations.history');
Route::get('/reservations/{reservation}', [ReservationHistoryController::class, 'show'])->name('reservations.show');
Route::post('/reservations/{reservation}/cancel', [ReservationHistoryController::class, 'cancel'])->name('reservations.cancel');
