<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'instructor.auth' => \App\Http\Middleware\InstructorAuth::class,
            'auth.student' => \App\Http\Middleware\StudentAuth::class,
        ]);

        // Configure where guests (unauthenticated users) should be redirected
        $middleware->redirectGuestsTo(function ($request) {
            // Check which guard should be used based on the URL
            if ($request->is('student/*')) {
                return route('student.login');
            }
            if ($request->is('admin/*')) {
                return route('admin.login');
            }
            if ($request->is('instructor/*')) {
                return route('instructor.login');
            }
            // Default redirect to student login
            return route('student.login');
        });

        // Configure where authenticated users should be redirected when accessing guest-only routes
        $middleware->redirectUsersTo(function () {
            // Check which session is active
            if (session()->has('student_logged_in')) {
                return route('student.dashboard');
            }
            if (session()->has('admin_id')) {
                return route('admin.dashboard');
            }
            if (session()->has('instructor_logged_in')) {
                return route('instructor.dashboard');
            }
            // Default to home
            return '/';
        });

        // Exclude SSLCOMMERZ callback routes from CSRF protection
        $middleware->validateCsrfTokens(except: [
            'payment/success',
            'payment/fail',
            'payment/cancel',
            'payment/ipn',
            'payment/complete',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
