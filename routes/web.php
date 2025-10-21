<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;

// ========================
// ADMIN PANEL ROUTES
// ========================


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



// Start Instructor 

use App\Http\Controllers\InstructorController;
use App\Http\Controllers\InstructorAuthController;
use App\Http\Controllers\InstructorApplicationController;

// Instructor Application Routes (Public)
Route::get('/instructor/apply', [InstructorApplicationController::class, 'showApplicationForm'])->name('instructor.apply');
Route::post('/instructor/apply', [InstructorApplicationController::class, 'submitApplication'])->name('instructor.apply.submit');

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


//start Student
use App\Http\Controllers\Student\LoginController;
use App\Http\Controllers\Student\RegisterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ContactController;

// Homepage
Route::get('/', function () {
    return view('home');
});

// About Page
Route::get('/about', function () {
    return view('about');
});

// Contact Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Courses (Public)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

// Student Routes
Route::prefix('student')->name('student.')->group(function () {

    // Guest routes (login/register) - only for GET routes
    Route::middleware('guest:student')->group(function () {
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    });

    // POST routes for registration and login (no guest middleware to allow immediate redirect after success)
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);

    // Authenticated student routes
    Route::middleware('auth.student')->group(function () {
        Route::get('dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('profile', [LoginController::class, 'profile'])->name('profile');
        Route::get('profile/edit', [LoginController::class, 'editProfile'])->name('profile.edit');
        Route::put('profile/update', [LoginController::class, 'updateProfile'])->name('profile.update');
        Route::get('courses/{course}', [StudentController::class, 'watchCourse'])->name('courses.watch');
        // Mark a course as completed for this student (AJAX)
        Route::post('courses/{course}/complete', [StudentController::class, 'completeCourseAjax'])->name('courses.complete');
    });
});

// Cart routes (Protected - Student Auth Required)
Route::middleware('auth.student')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{courseId}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Payment routes (Protected - Student Auth Required)
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
});

// SSLCOMMERZ Payment Callback Routes (accept both GET and POST)
Route::match(['get', 'post'], '/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::match(['get', 'post'], '/payment/fail', [PaymentController::class, 'paymentFail'])->name('payment.fail');
Route::match(['get', 'post'], '/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'paymentIPN'])->name('payment.ipn');

// Public route to complete login after payment (consumes one-time token)
// token is optional to support gateways that redirect without custom data.
// Also accept a trailing slash variant used by some gateways to avoid 404s
Route::match(['get', 'post'], '/payment/complete/', [PaymentController::class, 'completeWithToken']);
Route::match(['get', 'post'], '/payment/complete/{token?}', [PaymentController::class, 'completeWithToken'])->name('payment.complete');

//end Student