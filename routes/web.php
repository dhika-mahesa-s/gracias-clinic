<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ReservationHistoryController;
use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Customer\FaqController as CustomerFaqController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\DiscountController;

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
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

Route::get('/about', function () {
    return view('about');
})->name('about');

// ==========================
// AUTH ROUTES
// ==========================
Route::get('/auth/redirect', function (Request $request) {
    // Ambil redirect_to dari query parameter atau dari session url.intended
    $redirectTo = $request->get('redirect_to') ?? session('url.intended');
    
    // Simpan ke session jika ada
    if ($redirectTo) {
        session(['redirect_to' => $redirectTo]);
    }

    // Force regenerate session untuk Edge compatibility
    session()->regenerate();
    
    // Redirect ke Google OAuth
    return Socialite::driver('google')->redirect();
})->name('auth.redirect');

Route::get('/auth/callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(16)),
                'email_verified_at' => now(), // Auto-verify untuk Google OAuth
            ]);
        } else {
            // Jika user sudah ada tapi belum verified, auto-verify
            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = now();
                $user->save();
            }
        }

        Auth::login($user);
        
        // Regenerate session setelah login untuk keamanan
        session()->regenerate();

         // 🔹 Ambil redirect_to dari session (diset di /auth/redirect)
         if (session()->has('redirect_to')) {
            $redirectTo = session()->pull('redirect_to'); // hapus setelah digunakan
            return redirect($redirectTo)->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
        }

        return redirect('/')->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
    } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
        // Error spesifik untuk state mismatch (umum di Edge)
        return redirect('/login')
            ->with('error', 'Login gagal karena masalah session. Silakan coba lagi atau gunakan browser lain (Chrome/Firefox).');
    } catch (Exception $e) {
        // Tangani error cancel atau gagal autentikasi
        return redirect('/login')
            ->with('error', 'Login dengan Google dibatalkan atau gagal. Silakan coba lagi.');
    }
});

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
// RESERVATION ROUTES (dengan Rate Limiting)
// ==========================
Route::middleware(['auth', 'verified', 'check.customer'])->group(function () {
    Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
    
    // Rate limit: 5 reservations per minute per user (prevent spam)
    Route::middleware(['throttle:5,1'])->group(function () {
        Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    });
    
    Route::get('/reservasi/jadwal/{doctor}/{date}', [ReservationController::class, 'getSchedule']);
    Route::get('/reservasi/{code}/cetak', [ReservationController::class, 'cetakResi'])->name('reservasi.cetak');
});

// Admin Reservation Management (dengan Rate Limiting untuk aksi)
Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/reservasi', [ReservationAdminController::class, 'index'])->name('reservasi.admin');
    
    // Rate limit admin actions: 30 per minute (prevent accidental spam)
    Route::middleware(['throttle:30,1'])->group(function () {
        Route::post('/reservasi/{id}/konfirmasi', [ReservationAdminController::class, 'konfirmasi'])->name('admin.reservasi.konfirmasi');
        Route::post('/reservasi/{id}/selesai', [ReservationAdminController::class, 'selesai'])->name('admin.reservasi.selesai');
        Route::post('/reservasi/{id}/batalkan', [ReservationAdminController::class, 'batalkan'])->name('admin.reservasi.batalkan');
    });
});

require __DIR__ . '/auth.php';

// ==========================
// FEEDBACK (User Side - dengan Rate Limiting)
// ==========================
Route::middleware(['auth', 'verified', 'check.customer'])->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    
    // Rate limit: 3 feedback submissions per hour (prevent spam)
    Route::middleware(['throttle:3,60'])->group(function () {
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    });
    
    Route::get('/feedback/thankyou', [FeedbackController::class, 'thankyou'])->name('feedback.thankyou');
});

// ==========================
// ADMIN FEEDBACK (dengan Rate Limiting untuk toggle)
// ==========================
Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::get('/feedback/{id}', [AdminFeedbackController::class, 'show'])->name('admin.feedback.show');
    
    // Rate limit: 60 toggles per minute (AJAX endpoint)
    Route::middleware(['throttle:60,1'])->group(function () {
        Route::post('/feedback/{id}/toggle-visibility', [AdminFeedbackController::class, 'toggleVisibility'])->name('admin.feedback.toggle');
    });
});

// ==========================
// ADMIN FAQ
// ==========================
Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/faq', [AdminFaqController::class, 'index'])->name('admin.faq.index');
    Route::get('/faq/create', [AdminFaqController::class, 'create'])->name('admin.faq.create');
    Route::post('/faq', [AdminFaqController::class, 'store'])->name('admin.faq.store');
    Route::get('/faq/{id}/edit', [AdminFaqController::class, 'edit'])->name('admin.faq.edit');
    Route::put('/faq/{id}', [AdminFaqController::class, 'update'])->name('admin.faq.update');
    Route::delete('/faq/{id}', [AdminFaqController::class, 'destroy'])->name('admin.faq.destroy');
});

// ==========================
// CUSTOMER FAQ
// ==========================
Route::get('/faq', [CustomerFaqController::class, 'index'])->name('customer.faq.index');

Route::middleware(['auth', 'verified', 'check.customer'])->group(function () {
Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'index'])->name('reservations.history');
Route::get('/reservations/{reservation}', [ReservationHistoryController::class, 'show'])->name('reservations.show');
Route::post('/reservations/{reservation}/cancel', [ReservationHistoryController::class, 'cancelReservation'])->name('reservations.cancel');
});

Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/riwayat-reservasi', [ReservationHistoryController::class, 'adminIndex'])->name('admin.reservations.history');
    Route::get('/riwayat-reservasi/cetak', [ReservationHistoryController::class, 'printReport'])->name('admin.reservations.print');
    Route::resource('schedules', ScheduleController::class)->middleware('auth');
});

// ==========================
// DASHBOARD ROUTES
// ==========================
Route::prefix('admin')->middleware(['auth', 'check.admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/download-report', [DashboardController::class, 'downloadReport'])->name('dashboard.downloadReport');
});

// ==========================
// DISCOUNT MANAGEMENT ROUTES
// ==========================
Route::prefix('admin')->middleware(['auth', 'check.admin'])->name('admin.')->group(function () {
    Route::resource('discounts', DiscountController::class);
    Route::patch('discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])->name('discounts.toggle-status');
});
