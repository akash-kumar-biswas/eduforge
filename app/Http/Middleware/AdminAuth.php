<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if admin is logged in
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Please login to access admin panel.');
        }

        // Prevent instructor from accessing admin panel
        if (session()->has('instructor_logged_in')) {
            session()->forget('instructor_logged_in');
            return redirect()->route('instructor.login')->with('error', 'Please use instructor login to access instructor panel.');
        }

        // Prevent student from accessing admin panel
        if (session()->has('student_logged_in')) {
            session()->forget(['student_logged_in', 'student_name', 'student_id', 'student_email']);
            return redirect()->route('student.login')->with('error', 'Please use student login to access student panel.');
        }

        return $next($request);
    }
}
