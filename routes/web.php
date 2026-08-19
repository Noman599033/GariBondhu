<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [PublicController::class, 'search'])->name('search');
Route::get('/checkout', [PublicController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [PublicController::class, 'storeCheckout'])->name('checkout.store');
Route::view('/contact', 'public.contact')->name('contact');
Route::view('/services', 'public.services')->name('services');
Route::view('/locations', 'public.locations')->name('locations');
Route::view('/deals', 'public.deals')->name('deals');
Route::get('/checkout/success/{booking}', [PublicController::class, 'checkoutSuccess'])->name('checkout.success');

use App\Http\Controllers\Customer\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('api/search-cars', [\App\Http\Controllers\Api\BookingController::class, 'search'])->name('api.search.cars');

Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('dashboard', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('bookings', \App\Http\Controllers\Customer\BookingController::class)->only(['index', 'show']);
    Route::post('bookings/{booking}/payment', [\App\Http\Controllers\Customer\BookingController::class, 'storePayment'])->name('bookings.payment.store');

    Route::get('profile', [\App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('profile');
    Route::put('profile/info', [\App\Http\Controllers\Customer\ProfileController::class, 'updateInfo'])->name('profile.update.info');
    Route::put('profile/password', [\App\Http\Controllers\Customer\ProfileController::class, 'updatePassword'])->name('profile.update.password');

    Route::post('notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
});
