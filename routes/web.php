<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Customer\FaqController as CustomerFaqController;
use App\Http\Controllers\Admin\ReservationAdminController;
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

// ==========================
// LANDING PAGE
// ==========================
Route::get('/', function(){
    return view('landingpage');
    })->name('landingpage');

Route::get('/about', function () {
    return view('about');
})->name('about');

// ==========================
// AUTH ROUTES
// ==========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Register Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
// Password Reset Routes
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================
// TREATMENT ROUTES
// ==========================
Route::prefix('treatments')->group(function () {
    Route::get('/', [TreatmentController::class, 'index'])->name('treatments.index');
    Route::get('/{treatment}', [TreatmentController::class, 'show'])->name('treatments.show');
});
// Admin / Management
Route::prefix('admin/treatments')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/manage/list', [TreatmentController::class, 'manage'])->name('treatments.manage');
    Route::get('/manage/create', [TreatmentController::class, 'create'])->name('treatments.create');
    Route::post('/manage/store', [TreatmentController::class, 'store'])->name('treatments.store');
    Route::delete('/manage/{treatment}', [TreatmentController::class, 'destroy'])->name('treatments.destroy');
    Route::get('/manage/{treatment}/edit', [TreatmentController::class, 'edit'])->name('treatments.edit');
    Route::put('/manage/{treatment}',      [TreatmentController::class, 'update'])->name('treatments.update');
});

// ==========================
// RESERVATION ROUTES
// ==========================
Route::middleware(['auth'])->group(function () {
    Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/jadwal/{doctor}/{date}', [ReservationController::class, 'getSchedule']);
});
// Admin Reservation Management
Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/reservasi', [ReservationAdminController::class, 'index'])->name('reservasi.admin');
    Route::post('/reservasi/{id}/konfirmasi', [ReservationAdminController::class, 'konfirmasi'])->name('admin.reservasi.konfirmasi');
    Route::post('/reservasi/{id}/selesai', [ReservationAdminController::class, 'selesai'])->name('admin.reservasi.selesai');
    Route::post('/reservasi/{id}/batalkan', [ReservationAdminController::class, 'batalkan'])->name('admin.reservasi.batalkan');
});

require __DIR__ . '/auth.php';

// ==========================
// FEEDBACK (User Side)
// ==========================
Route::middleware(['auth'])->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/thankyou', [FeedbackController::class, 'thankyou'])->name('feedback.thankyou');
});
// ==========================
// FEEDBACK RESOURCE (CRUD)
// ==========================
Route::resource('feedback', FeedbackController::class);

// ==========================
// ADMIN FEEDBACK
// ==========================
Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::post('/feedback/{id}/toggle-visibility', [FeedbackController::class, 'toggleVisibility'])->name('admin.feedback.toggle');
});

// ==========================
// ADMIN FAQ
// ==========================
Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/faq', [AdminFaqController::class, 'index'])->name('admin.faq.index');
    Route::get('/faq/create', [AdminFaqController::class, 'create']);
    Route::post('/faq', [AdminFaqController::class, 'store']);
    Route::get('/faq/{id}/edit', [AdminFaqController::class, 'edit']);
    Route::put('/faq/{id}', [AdminFaqController::class, 'update']);
    Route::delete('/faq/{id}', [AdminFaqController::class, 'destroy']);
});

// ==========================
// CUSTOMER FAQ
// ==========================
Route::get('/faq', [CustomerFaqController::class, 'index'])->name('customer.faq.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/jadwal/{doctor}/{date}', [ReservationController::class, 'getSchedule']);
    Route::get('/reservasi/{code}/cetak', [ReservationController::class, 'cetakResi'])->name('reservasi.cetak');
});

Route::middleware(['auth'])->group(function () {
Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'index'])->name('reservations.history');
Route::get('/reservations/{reservation}', [ReservationHistoryController::class, 'show'])->name('reservations.show');
Route::post('/reservations/{reservation}/cancel', [ReservationHistoryController::class, 'cancel'])->name('reservations.cancel');
});

Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'adminIndex'])->name('admin.reservations.history');
});

// ==========================
// DASHBOARD ROUTES
// ==========================
Route::prefix('admin')->middleware(['auth', 'check.admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/download-report', [DashboardController::class, 'downloadReport'])->name('dashboard.downloadReport');
});





