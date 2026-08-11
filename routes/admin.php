<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware([\App\Http\Middleware\AdminAuthenticate::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('dashboard', function () {
        return view('admin.dashboard'); // Placeholder
    })->name('dashboard');

    Route::resource('cars', \App\Http\Controllers\Admin\CarController::class);
    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class);
    Route::patch('bookings/{booking}/payments/{payment}', [\App\Http\Controllers\Admin\BookingController::class, 'updatePayment'])->name('bookings.payments.update');

    Route::get('customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::resource('categories', \App\Http\Controllers\Admin\CarCategoryController::class)->except(['show']);
        Route::resource('pricing_rules', \App\Http\Controllers\Admin\PricingRuleController::class)->except(['show']);
    });

    Route::post('notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
});
