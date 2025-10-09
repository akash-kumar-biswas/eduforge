<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;

class InstructorAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        // Check if remember me cookie exists and auto-login
        if (request()->cookie('instructor_remember_token')) {
            $rememberToken = request()->cookie('instructor_remember_token');
            $instructor = Instructor::where('remember_token', $rememberToken)->first();

            if ($instructor) {
                session([
                    'instructor_logged_in' => true,
                    'instructor_name' => $instructor->name,
                    'instructor_id' => $instructor->id,
                    'instructor_email' => $instructor->email,
                ]);
                return redirect()->route('instructor.dashboard');
            }
        }

        return view('instructor.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $instructor = Instructor::where('email', $request->email)->first();

        if ($instructor && Hash::check($request->password, $instructor->password)) {
            // Set session
            session([
                'instructor_logged_in' => true,
                'instructor_name' => $instructor->name,
                'instructor_id' => $instructor->id,
                'instructor_email' => $instructor->email,
            ]);

            // Handle Remember Me
            if ($request->has('remember')) {
                // Generate a unique remember token
                $rememberToken = bin2hex(random_bytes(32));

                // Save token to database
                $instructor->remember_token = $rememberToken;
                $instructor->save();

                // Set cookie for 30 days
                cookie()->queue('instructor_remember_token', $rememberToken, 60 * 24 * 30);
            }

            return redirect()->route('instructor.dashboard');
        }

        return back()->with('error', 'Invalid email or password.')->withInput($request->only('email'));
    }

    // Logout
    public function logout()
    {
        // Get current instructor
        if (session('instructor_id')) {
            $instructor = Instructor::find(session('instructor_id'));
            if ($instructor) {
                // Clear remember token from database
                $instructor->remember_token = null;
                $instructor->save();
            }
        }

        // Clear session
        session()->forget(['instructor_logged_in', 'instructor_name', 'instructor_id', 'instructor_email']);

        // Clear remember me cookie
        cookie()->queue(cookie()->forget('instructor_remember_token'));

        return redirect()->route('instructor.login');
    }

    // Show signup form
    public function showRegisterForm()
    {
        return view('instructor.register');
    }

    // Handle signup
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $instructor = Instructor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto-login after registration
        session([
            'instructor_logged_in' => true,
            'instructor_name' => $instructor->name,
            'instructor_id' => $instructor->id,
        ]);

        return redirect()->route('instructor.dashboard');
    }
}
