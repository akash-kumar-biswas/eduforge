<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // Show payment history for logged-in student
    public function index()
    {
        // Check if student is logged in
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to view payment history.');
        }

        $studentId = Auth::guard('student')->id();

        $payments = Payment::with('items.course')
            ->where('student_id', $studentId)
            ->latest()
            ->get();

        return view('payments.index', compact('payments'));
    }

    // Checkout all courses in cart
    public function checkout(Request $request)
    {
        // Check if student is logged in
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to checkout.');
        }

        $studentId = Auth::guard('student')->id();

        $cartItems = Cart::with('course')->where('student_id', $studentId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Start transaction
        DB::transaction(function () use ($cartItems, $studentId) {

            $totalAmount = $cartItems->sum(fn($item) => $item->course->price);

            // Create Payment record
            $payment = Payment::create([
                'student_id' => $studentId,
                'method' => 'manual',
                'status' => 1, // completed
                'total_amount' => $totalAmount,
            ]);

            // Create PaymentItems for each course and enrollments
            foreach ($cartItems as $item) {
                PaymentItem::create([
                    'payment_id' => $payment->id,
                    'course_id' => $item->course->id,
                    'price' => $item->course->price,
                ]);

                // Create enrollment for the student
                Enrollment::firstOrCreate([
                    'student_id' => $studentId,
                    'course_id' => $item->course->id,
                ]);
            }

            // Clear cart
            Cart::where('student_id', $studentId)->delete();
        });

        return redirect()->route('student.dashboard')->with('success', 'Checkout completed successfully! You have enrolled in the courses.');
    }
}