<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Check if remember me cookie exists and auto-login
        if (request()->cookie('student_remember_token')) {
            $rememberToken = request()->cookie('student_remember_token');
            $student = \App\Models\Student::where('remember_token', $rememberToken)->first();

            if ($student) {
                session([
                    'student_logged_in' => true,
                    'student_name' => $student->name,
                    'student_id' => $student->id,
                    'student_email' => $student->email,
                ]);
                return redirect()->route('student.dashboard');
            }
        }

        return view('student.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $student = \App\Models\Student::where('email', $credentials['email'])->first();

        if ($student && Hash::check($credentials['password'], $student->password)) {
            // Set session
            session([
                'student_logged_in' => true,
                'student_name' => $student->name,
                'student_id' => $student->id,
                'student_email' => $student->email,
            ]);

            // Handle Remember Me
            if ($request->has('remember')) {
                // Generate a unique remember token
                $rememberToken = bin2hex(random_bytes(32));

                // Save token to database
                $student->remember_token = $rememberToken;
                $student->save();

                // Set cookie for 30 days
                cookie()->queue('student_remember_token', $rememberToken, 60 * 24 * 30);
            }

            return redirect()->intended(route('student.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    public function dashboard()
    {
        $studentId = session('student_id');
        $student = \App\Models\Student::findOrFail($studentId);

        // Build the courses list from Enrollment records so we have authoritative
        // access to `is_completed` stored on the enrollments table.
        $enrollments = \App\Models\Enrollment::with(['course.instructor'])
            ->where('student_id', $student->id)
            ->get();

        $allCourses = $enrollments->map(function ($enrollment) {
            $course = $enrollment->course;
            // Attach a lightweight pivot object so the blade can read pivot->is_completed
            $course->pivot = (object) [
                'is_completed' => (bool) ($enrollment->is_completed ?? false),
                'created_at' => $enrollment->created_at,
            ];

            // Progress placeholder: completed -> 100, otherwise 0
            $course->progress = $course->pivot->is_completed ? 100 : 0;

            return $course;
        })->values();

        // Get enrolled courses count
        $enrolledCount = $allCourses->count();

        // Completed courses count: prefer authoritative students.complete_course
        $completedCount = (int) $student->complete_course;

        // Get purchase history - fetch payment_items grouped by payment_id
        $purchaseHistory = \App\Models\PaymentItem::with(['payment', 'course.instructor'])
            ->whereHas('payment', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })
            ->get()
            ->groupBy('payment_id')
            ->map(function ($items) {
                return (object) [
                    'payment_id' => $items->first()->payment_id,
                    'payment' => $items->first()->payment,
                    'items' => $items,
                    'total_price' => $items->sum('price'),
                    'total_courses' => $items->count(),
                    'created_at' => $items->first()->payment->created_at,
                    'txnid' => $items->first()->payment->txnid ?? 'N/A',
                ];
            })
            ->sortByDesc('created_at')
            ->values();

        return view('student.dashboard', compact('student', 'allCourses', 'enrolledCount', 'completedCount', 'purchaseHistory'));
    }

    public function profile()
    {
        $studentId = session('student_id');
        $student = \App\Models\Student::findOrFail($studentId);
        return view('student.profile', compact('student'));
    }

    public function editProfile()
    {
        $studentId = session('student_id');
        $student = \App\Models\Student::findOrFail($studentId);
        return view('student.edit-profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $studentId = session('student_id');
        $student = \App\Models\Student::findOrFail($studentId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'nationality' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update basic information
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->date_of_birth = $request->date_of_birth;
        $student->gender = $request->gender;
        $student->nationality = $request->nationality;
        $student->bio = $request->bio;
        $student->address = $request->address;
        $student->city = $request->city;
        $student->state = $request->state;
        $student->postcode = $request->postcode;
        $student->country = $request->country;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($student->image && file_exists(public_path('uploads/students/' . $student->image))) {
                unlink(public_path('uploads/students/' . $student->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/students'), $imageName);
            $student->image = $imageName;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }

    public function logout(Request $request)
    {
        // Get current student
        if (session('student_id')) {
            $student = \App\Models\Student::find(session('student_id'));
            if ($student) {
                // Clear remember token from database
                $student->remember_token = null;
                $student->save();
            }
        }

        // Clear session
        session()->forget(['student_logged_in', 'student_name', 'student_id', 'student_email']);

        // Clear remember me cookie
        cookie()->queue(cookie()->forget('student_remember_token'));

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }
}