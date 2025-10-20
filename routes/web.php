<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Customer\FaqController as CustomerFaqController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\LoginController;

// ==========================
// LANDING PAGE
// ==========================
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

// ==========================
// AUTH ROUTES
// ==========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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
