<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Customer\FaqController as CustomerFaqController;

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

// Admin FAQ
Route::prefix('admin')->group(function () {
    Route::get('/faq', [AdminFaqController::class, 'index']);
    Route::get('/faq/create', [AdminFaqController::class, 'create']);
    Route::post('/faq', [AdminFaqController::class, 'store']);
    Route::get('/faq/{id}/edit', [AdminFaqController::class, 'edit']);
    Route::put('/faq/{id}', [AdminFaqController::class, 'update']);
    Route::delete('/faq/{id}', [AdminFaqController::class, 'destroy']);
});

// Customer FAQ
Route::get('/faq', [CustomerFaqController::class, 'index']);
