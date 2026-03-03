<?php

use App\Http\Controllers\Auth\RegisteredClientController;
use App\Http\Controllers\Client\Auth\ClientLoginController;
use App\Http\Controllers\Client\DashboardController;
use Illuminate\Support\Facades\Route;

/* |-------------------------------------------------------------------------- | Client Routes |-------------------------------------------------------------------------- */

// Registration
Route::get('/client/register', [RegisteredClientController::class , 'showRegistrationForm'])->name('client.register.form');
Route::post('/client/register', [RegisteredClientController::class , 'register'])->name('client.register');

// Login
Route::prefix('client')->name('client.')->group(function () {

    Route::middleware('guest:client,web')->group(function () {
            Route::get('/login', [ClientLoginController::class , 'showLoginForm'])->name('login');
            Route::post('/login', [ClientLoginController::class , 'login']);
        }
        );

        Route::middleware('auth:client,web')->group(function () {
            Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');
            Route::post('/logout', [ClientLoginController::class , 'logout'])->name('logout');

            // Projects CRUD
            Route::resource('projects', \App\Http\Controllers\Client\ProjectController::class);
            Route::get('/courses/{course_id}/subjects', [\App\Http\Controllers\Client\ProjectController::class , 'getSubjects'])->name('courses.subjects');

            // Teams CRUD
            Route::resource('teams', \App\Http\Controllers\Client\TeamController::class);

            // Team Members
            Route::post('teams/{team}/members', [\App\Http\Controllers\Client\TeamMemberController::class , 'store'])->name('teams.members.store');
            Route::delete('teams/{team}/members/{member}', [\App\Http\Controllers\Client\TeamMemberController::class , 'destroy'])->name('teams.members.destroy');

            // Team Invitations (for the invited user)
            Route::get('invitations', [\App\Http\Controllers\Client\TeamMemberController::class , 'invitations'])->name('invitations.index');
            Route::put('invitations/{invitation}', [\App\Http\Controllers\Client\TeamMemberController::class , 'updateStatus'])->name('invitations.update');
        }
        );
    });
