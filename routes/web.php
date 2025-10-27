<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Customer\FaqController as CustomerFaqController;
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
// FEEDBACK & FAQ (Publik)
// ==========================
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/thankyou', [FeedbackController::class, 'thankyou'])->name('feedback.thankyou');
Route::resource('feedback', FeedbackController::class);
Route::get('/faq', [CustomerFaqController::class, 'index']); // Customer FAQ
//treatments
Route::prefix('treatments')->group(function () {
    Route::get('/list', [TreatmentController::class, 'index'])->name('treatments.index');
    Route::get('/{treatment}', [TreatmentController::class, 'show'])->name('treatments.show');
});

// ==========================
// AUTH (ALL ROUTES)
// ==========================

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // ✅ tambahkan route reservasi di sini
    Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/jadwal/{doctor}/{date}', [ReservationController::class, 'getSchedule']);
  
    // RIWAYAT RESERVASI (CUSTOMER) - Panggilan ke index
    Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'index'])->name('reservations.history');
    Route::get('/reservations/{reservation}', [ReservationHistoryController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{reservation}/cancel', [ReservationHistoryController::class, 'cancel'])->name('reservations.cancel');
    

    // Admin / Management (Membutuhkan Auth/Role)
    Route::middleware(['auth', 'admin'])->group(function () { // Pindahkan middleware ke sini jika diperlukan
        Route::get('/manage/list', [TreatmentController::class, 'manage'])->name('treatments.manage');
        Route::get('/manage/create', [TreatmentController::class, 'create'])->name('treatments.create');
        Route::post('/manage/store', [TreatmentController::class, 'store'])->name('treatments.store');
        Route::delete('/manage/{treatment}', [TreatmentController::class, 'destroy'])->name('treatments.destroy');
        Route::get('/manage/{treatment}/edit', [TreatmentController::class, 'edit'])->name('treatments.edit');
        Route::put('/manage/{treatment}', [TreatmentController::class, 'update'])->name('treatments.update');
        // ==========================
        // PROTECTED ADMIN ROUTES
        // ==========================
        Route::prefix('admin')->group(function () {
            // feedback routes
            Route::get('/feedback', [FeedbackController::class, 'index'])->name('admin.feedback.index');
            Route::post('/feedback/{id}/toggle-visibility', [FeedbackController::class, 'toggleVisibility'])->name('admin.feedback.toggle');
            // faq routes
            Route::get('/faq', [AdminFaqController::class, 'index']);
            Route::get('/faq/create', [AdminFaqController::class, 'create']);
            Route::post('/faq', [AdminFaqController::class, 'store']);
            Route::get('/faq/{id}/edit', [AdminFaqController::class, 'edit']);
            Route::put('/faq/{id}', [AdminFaqController::class, 'update']);
            Route::delete('/faq/{id}', [AdminFaqController::class, 'destroy']);
             // Admin Reservasi (Konfirmasi) routes
            Route::get('/reservasi', [ReservationAdminController::class, 'index'])->name('reservasi.admin');
            Route::post('/reservasi/{id}/konfirmasi', [ReservationAdminController::class, 'konfirmasi'])->name('admin.reservasi.konfirmasi');
            // RIWAYAT RESERVASI (ADMIN) - Panggilan ke adminIndex
            Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'adminIndex'])->name('admin.reservations.history');
            // ==========================
            // DASHBOARD ROUTES
            // ==========================
            Route::prefix('admin')->name('admin.')->group(function () {
                Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
                Route::get('/dashboard/download-report', [DashboardController::class, 'downloadReport'])->name('dashboard.downloadReport');
            });


        
        });
    
    });
});





