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
        // Check if student is logged in
        if (!session()->has('student_logged_in')) {
            return redirect()->route('student.login')->with('error', 'Please login to access student panel.');
        }

        // Prevent admin from accessing student panel
        if (session()->has('admin_id')) {
            session()->forget('admin_id');
            return redirect()->route('admin.login')->with('error', 'Please use admin login to access admin panel.');
        }

        // Prevent instructor from accessing student panel
        if (session()->has('instructor_logged_in')) {
            session()->forget('instructor_logged_in');
            return redirect()->route('instructor.login')->with('error', 'Please use instructor login to access instructor panel.');
        }

        return $next($request);
    }
}