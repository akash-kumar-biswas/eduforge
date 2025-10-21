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

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Set session for the new student
        session([
            'student_logged_in' => true,
            'student_name' => $student->name,
            'student_id' => $student->id,
            'student_email' => $student->email,
        ]);

        // Regenerate session for security
        $request->session()->regenerate();

        return redirect()->route('student.dashboard')->with('success', 'Welcome to EduForge! Your account has been created successfully.');
    }
}
