<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class , 'index'])->name('home');

Route::get('/projects', [ProjectController::class , 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class , 'show'])->name('projects.show');
Route::get('/projects/{slug}/download', [ProjectController::class , 'download'])->name('projects.download');
Route::post('/projects/{project}/like', [ProjectController::class , 'toggleLike'])->name('projects.like');
Route::get('/users/{user}', [\App\Http\Controllers\UserController::class , 'show'])->name('users.show');
Route::get('/colleges', [\App\Http\Controllers\CollegeController::class , 'index'])->name('colleges.index');
Route::get('/colleges/{college}', [\App\Http\Controllers\CollegeController::class , 'show'])->name('colleges.show');
Route::get('/teams/{team}', [TeamController::class , 'show'])->name('teams.show');

Route::get('/dashboard', function () {
    return redirect()->route('client.dashboard');
})->middleware(['auth:client,web'])->name('dashboard');

Route::middleware('auth:client,web')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

    // Comments
    Route::post('/projects/{project}/comments', [CommentController::class , 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class , 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class , 'destroy'])->name('comments.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.web.php';
require __DIR__ . '/client.web.php';
