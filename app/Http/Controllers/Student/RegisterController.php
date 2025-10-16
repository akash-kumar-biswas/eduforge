<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('student.register'); // your blade
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        \Log::info('Student registration attempt', ['email' => $request->email]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        \Log::info('Student created successfully', ['id' => $student->id, 'email' => $student->email]);

        // Login the student
        Auth::guard('student')->login($student, true); // true = remember

        // Regenerate session for security
        $request->session()->regenerate();

        // Save session explicitly
        $request->session()->save();

        // Detailed debug logging to help diagnose redirect/session issues
        $cookieName = config('session.cookie');
        $sessionId = $request->session()->getId();
        $cookieValue = $_COOKIE[$cookieName] ?? null;

        \Log::info('Student logged in', [
            'id' => $student->id,
            'authenticated' => Auth::guard('student')->check(),
            'session_id' => $sessionId,
            'cookie_name' => $cookieName,
            'cookie_value' => $cookieValue,
        ]);

        \Log::info('Redirecting to dashboard', ['route' => route('student.dashboard')]);

        return redirect()->route('student.dashboard')->with('success', 'Welcome to EduForge! Your account has been created successfully.');
    }
}
