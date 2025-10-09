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


//Start Admin

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

//End Admin



// For Instructor 

use App\Http\Controllers\InstructorController;
use App\Http\Controllers\InstructorAuthController;

// Instructor Login & Signup (Guest routes)
Route::get('/instructor/login', [InstructorAuthController::class, 'showLoginForm'])->name('instructor.login');
Route::post('/instructor/login', [InstructorAuthController::class, 'login'])->name('instructor.login.submit');
Route::get('/instructor/register', [InstructorAuthController::class, 'showRegisterForm'])->name('instructor.register');
Route::post('/instructor/register', [InstructorAuthController::class, 'register'])->name('instructor.register.submit');

// Instructor Protected Routes
Route::middleware('instructor.auth')->group(function () {
    Route::get('/instructor/logout', [InstructorAuthController::class, 'logout'])->name('instructor.logout');
    Route::get('/instructor/dashboard', [InstructorController::class, 'dashboard'])->name('instructor.dashboard');
    Route::get('/instructor/instructors', [InstructorController::class, 'instructorsList'])->name('instructor.instructors');
    Route::get('/instructor/enrollments', [InstructorController::class, 'enrollments'])->name('instructor.enrollments');

    // Profile routes
    Route::get('/instructor/profile', [InstructorController::class, 'profile'])->name('instructor.profile');
    Route::get('/instructor/profile/edit', [InstructorController::class, 'editProfile'])->name('instructor.profile.edit');
    Route::put('/instructor/profile/update', [InstructorController::class, 'updateProfile'])->name('instructor.profile.update');

    // Course management routes
    Route::get('/instructor/courses', [InstructorController::class, 'courses'])->name('instructor.courses');
    Route::get('/instructor/courses/create', [InstructorController::class, 'createCourse'])->name('instructor.courses.create');
    Route::post('/instructor/courses', [InstructorController::class, 'storeCourse'])->name('instructor.courses.store');
    Route::get('/instructor/courses/{id}/edit', [InstructorController::class, 'editCourse'])->name('instructor.courses.edit');
    Route::put('/instructor/courses/{id}', [InstructorController::class, 'updateCourse'])->name('instructor.courses.update');
    Route::delete('/instructor/courses/{id}', [InstructorController::class, 'destroyCourse'])->name('instructor.courses.destroy');
});

//End Instructor