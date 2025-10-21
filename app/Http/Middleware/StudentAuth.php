<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // FIRST: Prevent admin/instructor from accessing student panel
        // Check this BEFORE checking if student is logged in
        if (session()->has('admin_id')) {
            session()->forget('admin_id');
            return redirect()->route('admin.login')->with('error', 'Please use admin login to access admin panel.');
        }

        if (session()->has('instructor_logged_in')) {
            session()->forget('instructor_logged_in');
            return redirect()->route('instructor.login')->with('error', 'Please use instructor login to access instructor panel.');
        }

        // THEN: Check if student is logged in using session
        if (!session()->has('student_logged_in')) {
            return redirect()->route('student.login')->with('error', 'Please login to access student panel.');
        }

        // NEW: Check if accessing from outside student panel (except for login/register pages and homepage)
        $referer = $request->headers->get('referer');
        $currentUrl = $request->url();
        $studentBaseUrl = url('/student');
        $loginUrl = route('student.login');
        $registerUrl = route('student.register');
        $homeUrl = url('/');

        // If referer exists and is not from student panel, login, register, or homepage
        if (
            $referer &&
            !str_starts_with($referer, $studentBaseUrl) &&
            $referer !== $loginUrl &&
            $referer !== $registerUrl &&
            !str_starts_with($referer, $homeUrl)
        ) {
            // Check if current URL is student panel (not login/register page)
            if (
                str_starts_with($currentUrl, $studentBaseUrl) &&
                $currentUrl !== $loginUrl &&
                $currentUrl !== $registerUrl
            ) {
                session()->forget(['student_logged_in', 'student_name', 'student_id', 'student_email']);
                return redirect()->route('student.login')->with('error', 'Access denied. Please login again to access student panel.');
            }
        }

        return $next($request);
    }
}