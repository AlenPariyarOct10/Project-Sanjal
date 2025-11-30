<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredClientController;

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/

// Registration
Route::get('/client/register', [RegisteredClientController::class, 'showRegistrationForm'])->name('client.register.form');
Route::post('/client/register', [RegisteredClientController::class, 'register'])->name('client.register');
