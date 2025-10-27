<?php

use Illuminate\Support\Facades\Route;

// Import SEMUA Controller yang digunakan
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Customer\FaqController as CustomerFaqController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\ReservationHistoryController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Pastikan Anda menjalankan 'php artisan route:clear' setelah mengedit file ini.
*/

// ==========================
// LANDING PAGE (GLOBAL)
// ==========================
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

// ==========================
// AUTH ROUTES (GLOBAL, Tanpa Middleware)
// ==========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // FIX: Agar bisa diakses dari navbar
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

// ==========================
// TREATMENTS (Publik & Admin)
// ==========================
Route::prefix('treatments')->group(function () {
    Route::get('/', [TreatmentController::class, 'index'])->name('treatments.index');
    Route::get('/{treatment}', [TreatmentController::class, 'show'])->name('treatments.show');

    // Admin / Management (Membutuhkan Auth/Role)
    Route::middleware(['auth', 'admin'])->group(function () { // Pindahkan middleware ke sini jika diperlukan
        Route::get('/manage/list', [TreatmentController::class, 'manage'])->name('treatments.manage');
        Route::get('/manage/create', [TreatmentController::class, 'create'])->name('treatments.create');
        Route::post('/manage/store', [TreatmentController::class, 'store'])->name('treatments.store');
        Route::delete('/manage/{treatment}', [TreatmentController::class, 'destroy'])->name('treatments.destroy');
        Route::get('/manage/{treatment}/edit', [TreatmentController::class, 'edit'])->name('treatments.edit');
        Route::put('/manage/{treatment}', [TreatmentController::class, 'update'])->name('treatments.update');
    });
});

// ==========================
// FEEDBACK & FAQ (Publik)
// ==========================
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/thankyou', [FeedbackController::class, 'thankyou'])->name('feedback.thankyou');
Route::resource('feedback', FeedbackController::class);
Route::get('/faq', [CustomerFaqController::class, 'index']); // Customer FAQ

// ==========================
// PROTECTED ADMIN ROUTES
// ==========================
// 👇 TAMBAHKAN 'admin' DI SINI 👇
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Admin Feedback
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::post('/feedback/{id}/toggle-visibility', [AdminFeedbackController::class, 'toggleVisibility'])->name('admin.feedback.toggle');

    // Admin FAQ
    Route::get('/faq', [AdminFaqController::class, 'index']);
    Route::get('/faq/create', [AdminFaqController::class, 'create']);
    Route::post('/faq', [AdminFaqController::class, 'store']);
    Route::get('/faq/{id}/edit', [AdminFaqController::class, 'edit']);
    Route::put('/faq/{id}', [AdminFaqController::class, 'update']);
    Route::delete('/faq/{id}', [AdminFaqController::class, 'destroy']);

    // Admin Reservasi (Konfirmasi)
    Route::get('/reservasi', [ReservationAdminController::class, 'index'])->name('reservasi.admin');
    Route::post('/reservasi/{id}/konfirmasi', [ReservationAdminController::class, 'konfirmasi'])->name('admin.reservasi.konfirmasi');

    // RIWAYAT RESERVASI (ADMIN) - Panggilan ke adminIndex
    Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'adminIndex'])->name('admin.reservations.history');
});

// ==========================
// PROTECTED CUSTOMER ROUTES
// ==========================
Route::middleware(['auth'])->group(function () {
    // Reservasi Baru
    Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/jadwal/{doctor}/{date}', [ReservationController::class, 'getSchedule']);

    // RIWAYAT RESERVASI (CUSTOMER) - Panggilan ke index
    Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'index'])->name('reservations.history');
    Route::get('/reservations/{reservation}', [ReservationHistoryController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{reservation}/cancel', [ReservationHistoryController::class, 'cancel'])->name('reservations.cancel');
});

// Route Uji Coba Sederhana (Biarkan di luar Auth)
Route::get('/test-riwayat', function () {
    return 'Route test works.';
});
