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
        return view('student.login'); // your blade
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::guard('student')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('student.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    public function dashboard()
    {
        $student = Auth::guard('student')->user();

        // Get all enrolled courses with instructor info
        $allCourses = \App\Models\Enrollment::with(['course.instructor'])
            ->where('student_id', $student->id)
            ->get()
            ->pluck('course')
            ->unique('id')
            ->values();

        // Calculate progress for each course (for now, using random percentage)
        $allCourses->each(function ($course) {
            $course->progress = rand(10, 95); // Replace with actual progress calculation
        });

        // Get enrolled courses count
        $enrolledCount = $allCourses->count();

        // Get completed courses count (courses with 100% progress)
        $completedCount = $allCourses->where('progress', 100)->count();

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
        $student = Auth::guard('student')->user();
        return view('student.profile', compact('student'));
    }

    public function editProfile()
    {
        $student = Auth::guard('student')->user();
        return view('student.edit-profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $student = Auth::guard('student')->user();

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
        Auth::guard('student')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }
}