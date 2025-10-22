<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstructorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if instructor is logged in
        if (!session()->has('instructor_logged_in')) {
            return redirect()->route('instructor.login')->with('error', 'Please login to access instructor panel.');
        }

        // Prevent admin from accessing instructor panel
        if (session()->has('admin_id')) {
            session()->forget('admin_id');
            return redirect()->route('admin.login')->with('error', 'Please use admin login to access admin panel.');
        }

        // Prevent student from accessing instructor panel
        if (session()->has('student_logged_in')) {
            session()->forget(['student_logged_in', 'student_name', 'student_id', 'student_email']);
            return redirect()->route('student.login')->with('error', 'Please use student login to access student panel.');
        }

        return $next($request);
    }
}
