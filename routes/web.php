<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;


Route::get('/', function () {
    return view('welcome');
});

// ==========================
// FEEDBACK (User Side)
// ==========================
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/thankyou', [FeedbackController::class, 'thankyou'])->name('feedback.thankyou');

// ==========================
// ADMIN FEEDBACK
// ==========================
Route::prefix('admin')->group(function () {
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::post('/feedback/{id}/toggle-visibility', [AdminFeedbackController::class, 'toggleVisibility'])->name('admin.feedback.toggle');
});

Route::resource('feedback', FeedbackController::class);

