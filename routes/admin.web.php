<?php

use App\Http\Controllers\Admin\AlgorithmCategoryController;
use App\Http\Controllers\Admin\AlgorithmController;
use App\Http\Controllers\Admin\AlgorithmTagController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\SystemInfoController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;


// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
       Route::middleware('auth:admin')->group(function () {
                     Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');
                     Route::get('/users', [UserController::class , 'index'])->name('users.index');
                     Route::post('/users-data', [UserController::class , 'data'])->name('users.data');
                     Route::post('/users', [UserController::class , 'store'])->name('users.store');
                     Route::get('/users/{id}/edit', [UserController::class , 'edit'])->name('users.edit');
                     Route::put('/users/{id}', [UserController::class , 'update'])->name('users.update');
                     Route::delete('/users/{id}', [UserController::class , 'softDelete'])->name('users.destroy');

                     /*
        * Algorithms
        * */
                     Route::get('/algorithms', [AlgorithmController::class , 'index'])->name('algorithms.index');
                     Route::get('/algorithms/{slug}', [AlgorithmController::class , 'show'])->name('algorithms.show');
                     Route::get('/algorithms/{id}/edit', [AlgorithmController::class , 'edit'])->name('algorithms.edit');
                     Route::put('/algorithms/{id}', [AlgorithmController::class , 'update'])->name('algorithms.update');
                     Route::post('/algorithms', [AlgorithmController::class , 'store'])->name('algorithms.store');
                     Route::post('/algorithms-data', [AlgorithmController::class , 'data'])->name('algorithms.data');
                     Route::delete('/algorithms/{id}', [AlgorithmController::class , 'softDelete'])->name('algorithms.destroy');

                     /*
        * Algorithm Tags
        * */
                     Route::get('/algorithm-tags', [AlgorithmTagController::class , 'index'])->name('algorithm_tags.index');
                     Route::get('/algorithm-tags/{slug}', [AlgorithmTagController::class , 'show'])->name('algorithm_tags.show');
                     Route::get('/algorithm-tags/{id}/edit', [AlgorithmTagController::class , 'edit'])->name('algorithm_tags.edit');
                     Route::put('/algorithm-tags/{id}', [AlgorithmTagController::class , 'update'])->name('algorithm_tags.update');
                     Route::post('/algorithm-tags', [AlgorithmTagController::class , 'store'])->name('algorithm_tags.store');
                     Route::post('/algorithm-tags-data', [AlgorithmTagController::class , 'data'])->name('algorithm_tags.data');
                     Route::delete('/algorithm-tags/{id}', [AlgorithmTagController::class , 'softDelete'])->name('algorithm_tags.destroy');

                     /*
        * Algorithm Categories
        * */
                     Route::get('/algorithm-categories', [AlgorithmCategoryController::class , 'index'])->name('algorithm_categories.index');
                     Route::get('/algorithm-categories/{slug}', [AlgorithmCategoryController::class , 'show'])->name('algorithm_categories.show');
                     Route::get('/algorithm-categories/{id}/edit', [AlgorithmCategoryController::class , 'edit'])->name('algorithm_categories.edit');
                     Route::put('/algorithm-categories/{id}', [AlgorithmCategoryController::class , 'update'])->name('algorithm_categories.update');
                     Route::post('/algorithm-categories', [AlgorithmCategoryController::class , 'store'])->name('algorithm_categories.store');
                     Route::post('/algorithm-categories-data', [AlgorithmCategoryController::class , 'data'])->name('algorithm_categories.data');
                     Route::delete('/algorithm_categories/{id}', [AlgorithmCategoryController::class , 'softDelete'])->name('algorithm_categories.destroy');

                     /*
        * Courses
        * */
                     Route::get('/courses', [CourseController::class , 'index'])->name('courses.index');
                     Route::post('/courses-data', [CourseController::class , 'data'])->name('courses.data');
                     Route::post('/courses', [CourseController::class , 'store'])->name('courses.store');
                     Route::get('/courses/{id}/edit', [CourseController::class , 'edit'])->name('courses.edit');
                     Route::put('/courses/{id}', [CourseController::class , 'update'])->name('courses.update');
                     Route::delete('/courses/{id}', [CourseController::class , 'softDelete'])->name('courses.destroy');

                     /*
        * Subjects
        * */
                     Route::get('/subjects', [SubjectController::class , 'index'])->name('subjects.index');
                     Route::post('/subjects-data', [SubjectController::class , 'data'])->name('subjects.data');
                     Route::post('/subjects', [SubjectController::class , 'store'])->name('subjects.store');
                     Route::get('/subjects/{id}/edit', [SubjectController::class , 'edit'])->name('subjects.edit');
                     Route::put('/subjects/{id}', [SubjectController::class , 'update'])->name('subjects.update');
                     Route::delete('/subjects/{id}', [SubjectController::class , 'softDelete'])->name('subjects.destroy');

                     Route::get('/projects', [ProjectController::class , 'index'])->name('projects.index');
                     Route::get('/projects/{id}', [ProjectController::class , 'show'])->name('projects.show');
                     Route::POST('/projects-data', [ProjectController::class , 'getDataForIndex'])->name('projects.data');

                     Route::get('/colleges', [CollegeController::class , 'index'])->name('colleges.index');
                     Route::get('/colleges/{id}', [CollegeController::class , 'show'])->name('colleges.show');
                     Route::get('/colleges/{id}/edit', [CollegeController::class , 'edit'])->name('colleges.edit');
                     Route::put('/colleges/{id}', [CollegeController::class , 'update'])->name('colleges.update');
                     Route::post('/colleges', [CollegeController::class , 'store'])->name('colleges.store');
                     Route::post('/colleges-data', [CollegeController::class , 'data'])->name('colleges.data');
                     Route::delete('/colleges/{id}', [CollegeController::class , 'softDelete'])->name('colleges.destroy');

                     Route::get('/universities', [UniversityController::class , 'index'])->name('universities.index');
                     Route::get('/universities/{slug}', [UniversityController::class , 'show'])->name('universities.show');
                     Route::get('/universities/{id}/edit', [UniversityController::class , 'edit'])->name('universities.edit');
                     Route::put('/universities/{id}', [UniversityController::class , 'update'])->name('universities.update');
                     Route::post('/universities', [UniversityController::class , 'store'])->name('universities.store');
                     Route::post('/universities-data', [UniversityController::class , 'data'])->name('universities.data');
                     Route::delete('/universities/{id}', [UniversityController::class , 'softDelete'])->name('universities.destroy');

                     Route::get('/tags', [TagController::class , 'index'])->name('tags.index');
                     Route::post('/tags-data', [TagController::class , 'data'])->name('tags.data');
                     Route::post('/tags', [TagController::class , 'store'])->name('tags.store');
                     Route::get('/tags/{id}', [TagController::class , 'show'])->name('tags.show');
                     Route::get('/tags/{id}/edit', [TagController::class , 'edit'])->name('tags.edit');
                     Route::delete('/tags/{id}', [TagController::class , 'softDelete'])->name('tags.destroy');
                     Route::put('/tags/{id}', [TagController::class , 'update'])->name('tags.update');


                     /*
        * System Settings (Logo + Name)
        * */
                     Route::get('/system-settings', [SystemInfoController::class , 'settings'])->name('system_settings.index');
                     Route::post('/system-settings', [SystemInfoController::class , 'saveSettings'])->name('system_settings.save');

                     /*
        * System Info
        * */
                     Route::get('/system-infos', [SystemInfoController::class , 'index'])->name('system_infos.index');
                     Route::get('/system-infos/{id}', [SystemInfoController::class , 'show'])->name('system_infos.show');
                     Route::get('/system-infos/{id}/edit', [SystemInfoController::class , 'edit'])->name('system_infos.edit');
                     Route::put('/system-infos/{id}', [SystemInfoController::class , 'update'])->name('system_infos.update');
                     Route::post('/system-infos', [SystemInfoController::class , 'store'])->name('system_infos.store');
                     Route::post('/system-infos-data', [SystemInfoController::class , 'data'])->name('system_infos.data');
                     Route::delete('/system-infos/{id}', [SystemInfoController::class , 'softDelete'])->name('system_infos.destroy');

                     /*
        * Roles
        * */
                     Route::get('/roles', [RoleController::class , 'index'])->name('roles.index');
                     Route::post('/roles-data', [RoleController::class , 'data'])->name('roles.data');
                     Route::post('/roles', [RoleController::class , 'store'])->name('roles.store');
                     Route::get('/roles/{id}/edit', [RoleController::class , 'edit'])->name('roles.edit');
                     Route::put('/roles/{id}', [RoleController::class , 'update'])->name('roles.update');
                     Route::delete('/roles/{id}', [RoleController::class , 'softDelete'])->name('roles.destroy');
              }
              );
       });
