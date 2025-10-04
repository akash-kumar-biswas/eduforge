<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;

// ========================
// ADMIN PANEL ROUTES
// ========================

// Home page
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Admin Login Routes (Guest only)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Admin Resource Routes
    Route::resource('instructors', App\Http\Controllers\Admin\InstructorController::class);
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class);
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::resource('enrollments', App\Http\Controllers\Admin\EnrollmentController::class);
});