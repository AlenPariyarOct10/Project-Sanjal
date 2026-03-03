<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/* |-------------------------------------------------------------------------- | Admin Authentication Routes |-------------------------------------------------------------------------- */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
            Route::get('/login', [AdminLoginController::class , 'showLoginForm'])->name('login');
            Route::post('/login', [AdminLoginController::class , 'login']);
        }
        );

        Route::middleware('auth:admin')->group(function () {
            Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
            Route::post('/logout', [AdminLoginController::class , 'logout'])->name('logout');
        }
        );    });

/* |-------------------------------------------------------------------------- | Generic /login and /register → redirect to client equivalents | This removes the duplicate Breeze login page |-------------------------------------------------------------------------- */
Route::get('login', fn() => redirect()->route('client.login'))->name('login');
Route::get('register', fn() => redirect()->route('client.register.form'))->name('register');

/* |-------------------------------------------------------------------------- | Password Reset (client guard) |-------------------------------------------------------------------------- */
Route::middleware('guest:client,web')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class , 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class , 'store'])
        ->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class , 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class , 'store'])
        ->name('password.store');
});

/* |-------------------------------------------------------------------------- | Authenticated Routes (client/web guard) |-------------------------------------------------------------------------- */
Route::middleware('auth:client,web')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class , 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class , 'show'])
        ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class , 'store']);
    Route::put('password', [PasswordController::class , 'update'])->name('password.update');
});
