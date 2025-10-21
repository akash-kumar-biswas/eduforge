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
        // FIRST: Prevent admin/student from accessing instructor panel
        // Check this BEFORE checking if instructor is logged in
        if (session()->has('admin_id')) {
            session()->forget('admin_id');
            return redirect()->route('admin.login')->with('error', 'Please use admin login to access admin panel.');
        }

        if (session()->has('student_logged_in')) {
            session()->forget(['student_logged_in', 'student_name', 'student_id', 'student_email']);
            return redirect()->route('student.login')->with('error', 'Please use student login to access student panel.');
        }

        // THEN: Check if instructor is logged in
        if (!$request->session()->get('instructor_logged_in')) {
            return redirect()->route('instructor.login');
        }

        // NEW: Check if accessing from outside instructor panel (except for login page)
        $referer = $request->headers->get('referer');
        $currentUrl = $request->url();
        $instructorBaseUrl = url('/instructor');
        $loginUrl = route('instructor.login');

        // If referer exists and is not from instructor panel or login page
        if ($referer && !str_starts_with($referer, $instructorBaseUrl) && $referer !== $loginUrl) {
            // Check if current URL is instructor panel (not login page)
            if (str_starts_with($currentUrl, $instructorBaseUrl) && $currentUrl !== $loginUrl) {
                session()->forget('instructor_logged_in');
                return redirect()->route('instructor.login')->with('error', 'Access denied. Please login again to access instructor panel.');
            }
        }

        return $next($request);
    }
}
