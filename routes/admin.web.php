<?php

use App\Http\Controllers\Admin\AlgorithmController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\SystemInfoController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        Route::get('/algorithms', [AlgorithmController::class, 'index'])->name('algorithms.index');
        Route::post('/algorithms', [AlgorithmController::class, 'store'])->name('algorithms.store');
        Route::POST('/algorithms-data', [AlgorithmController::class, 'getDataForIndex'])->name('algorithms.data');


        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
        Route::POST('/projects-data', [ProjectController::class, 'getDataForIndex'])->name('projects.data');



        Route::get('/colleges', [CollegeController::class, 'index'])->name('colleges.index');
        Route::get('/colleges/{id}', [ProjectController::class, 'show'])->name('colleges.show');

        Route::get('/universities', [UniversityController::class, 'index'])->name('universities.index');
        Route::get('/universities/{slug}', [UniversityController::class, 'show'])->name('universities.show');
        Route::get('/universities/{id}/edit', [UniversityController::class, 'edit'])->name('universities.edit');
        Route::put('/universities/{id}', [UniversityController::class, 'update'])->name('universities.update');
        Route::post('/universities', [UniversityController::class, 'store'])->name('universities.store');
        Route::post('/universities-data', [UniversityController::class, 'data'])->name('universities.data');
        Route::delete('/universities/{id}', [UniversityController::class, 'softDelete'])->name('universities.destroy');

        Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
        Route::post('/tags-data', [TagController::class, 'data'])->name('tags.data');
        Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
        Route::get('/tags/{id}', [TagController::class, 'show'])->name('tags.show');
        Route::get('/tags/{id}/edit', [TagController::class, 'edit'])->name('tags.edit');
        Route::delete('/tags/{id}', [TagController::class, 'softDelete'])->name('tags.destroy');
        Route::put('/tags/{id}', [TagController::class, 'update'])->name('tags.update');


        /*
         * System Info
         * */
        Route::get('/system-infos', [SystemInfoController::class, 'index'])->name('system_infos.index');
        Route::get('/system-infos/{id}', [SystemInfoController::class, 'show'])->name('system_infos.show');
        Route::get('/system-infos/{id}/edit', [SystemInfoController::class, 'edit'])->name('system_infos.edit');
        Route::put('/system-infos/{id}', [SystemInfoController::class, 'update'])->name('system_infos.update');
        Route::post('/system-infos', [SystemInfoController::class, 'store'])->name('system_infos.store');
        Route::post('/system-infos-data', [SystemInfoController::class, 'data'])->name('system_infos.data');
        Route::delete('/system-infos/{id}', [SystemInfoController::class, 'softDelete'])->name('system_infos.destroy');
    });
});
