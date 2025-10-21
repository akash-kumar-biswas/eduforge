<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show all courses in student's cart
    public function index()
    {
        // Check if student is logged in
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to view your cart.');
        }

        $studentId = Auth::guard('student')->id();
        $cartItems = Cart::with('course')
            ->where('student_id', $studentId)
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    // Add a course to cart
    public function add(Request $request, $courseId)
    {
        // Check if student is logged in
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to add courses to cart.');
        }

        $studentId = Auth::guard('student')->id();
        $student = Auth::guard('student')->user();

        // Check if course exists
        $course = Course::find($courseId);
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found!');
        }

        // Check if student is already enrolled in this course
        $isEnrolled = $student->courses()->where('courses.id', $courseId)->exists();
        if ($isEnrolled) {
            return redirect()->back()->with('error', 'You are already enrolled in this course! Check your dashboard.');
        }

        // Use firstOrCreate to prevent race condition
        $cart = Cart::firstOrCreate(
            [
                'student_id' => $studentId,
                'course_id' => $courseId,
            ]
        );

        // Check if it was just created or already existed
        if ($cart->wasRecentlyCreated) {
            return redirect()->back()->with('success', 'Course added to cart!');
        } else {
            return redirect()->back()->with('info', 'Course is already in your cart!');
        }
    }

    // Remove a course from cart
    public function remove($id)
    {
        // Check if student is logged in
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to manage your cart.');
        }

        $studentId = Auth::guard('student')->id();

        $cartItem = Cart::where('id', $id)
            ->where('student_id', $studentId)
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->back()->with('success', 'Course removed from cart!');
    }

    // Clear entire cart
    public function clear()
    {
        // Check if student is logged in
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to manage your cart.');
        }

        $studentId = Auth::guard('student')->id();
        Cart::where('student_id', $studentId)->delete();

        return redirect()->back()->with('success', 'Cart cleared!');
    }
}