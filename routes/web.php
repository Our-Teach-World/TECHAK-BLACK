<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PhonePeController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Checkout routes
Route::get('/checkout/{service}', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout/{service}', [CheckoutController::class, 'process'])->name('checkout.process');

// PhonePe payment routes
Route::post('/payment/callback', [PhonePeController::class, 'callback'])->name('payment.callback');
Route::any('/payment/redirect', [PhonePeController::class, 'redirect'])->name('payment.redirect');
Route::get('/payment/success/{order}', [PhonePeController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PhonePeController::class, 'failed'])->name('payment.failed');
// (simulate route removed for production)

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');


// Auth routes (Laravel Breeze/UI)
require __DIR__.'/auth.php';
