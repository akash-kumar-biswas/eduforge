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
        // FIRST: Prevent other users (instructor/student) from accessing admin panel
        // Check this BEFORE checking if admin is logged in
        if (session()->has('instructor_logged_in')) {
            session()->forget('instructor_logged_in');
            return redirect()->route('instructor.login')->with('error', 'Please use instructor login to access instructor panel.');
        }

        if (session()->has('student_logged_in')) {
            session()->forget(['student_logged_in', 'student_name', 'student_id', 'student_email']);
            return redirect()->route('student.login')->with('error', 'Please use student login to access student panel.');
        }

        // THEN: Check if admin is logged in
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Please login to access admin panel.');
        }

        // NEW: Check if accessing from outside admin panel (except for login page)
        $referer = $request->headers->get('referer');
        $currentUrl = $request->url();
        $adminBaseUrl = url('/admin');
        $loginUrl = route('admin.login');

        // If referer exists and is not from admin panel or login page
        if ($referer && !str_starts_with($referer, $adminBaseUrl) && $referer !== $loginUrl) {
            // Check if current URL is admin panel (not login page)
            if (str_starts_with($currentUrl, $adminBaseUrl) && $currentUrl !== $loginUrl) {
                session()->forget('admin_id');
                return redirect()->route('admin.login')->with('error', 'Access denied. Please login again to access admin panel.');
            }
        }

        return $next($request);
    }
}
