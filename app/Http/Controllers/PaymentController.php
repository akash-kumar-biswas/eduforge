<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Enrollment;
use App\Services\SSLCommerzService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $sslcommerz;

    public function __construct(SSLCommerzService $sslcommerz)
    {
        $this->sslcommerz = $sslcommerz;
    }

    // Show payment history for logged-in student
    public function index()
    {
        // Check if student is logged in
        if (!session()->has('student_logged_in')) {
            return redirect()->route('student.login')->with('error', 'Please login to view payment history.');
        }

        $studentId = session('student_id');

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
        if (!session()->has('student_logged_in')) {
            return redirect()->route('student.login')->with('error', 'Please login to checkout.');
        }

        // Validate the request
        $request->validate([
            'payment_method' => 'required|in:bkash,nagad,rocket,upay',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'txnid' => 'required|string|size:4',
            'email' => 'nullable|email',
        ]);

        $studentId = session('student_id');

        $cartItems = Cart::with('course')->where('student_id', $studentId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $totalAmount = $cartItems->sum(fn($item) => $item->course->price);

        // Generate unique transaction ID
        $tranId = 'EDU-' . time() . '-' . Str::random(6);

        // Store cart items IDs for later use
        $cartItemIds = $cartItems->pluck('course_id')->toArray();

        // Prepare payment data for SSLCOMMERZ
        $paymentData = [
            'total_amount' => $totalAmount,
            'tran_id' => $tranId,
            'product_name' => 'Course Purchase - ' . count($cartItems) . ' courses',
            'cus_name' => $request->name,
            'cus_email' => $request->email ?? 'customer@eduforge.com',
            'cus_phone' => $request->mobile,
            'student_id' => $studentId,
            'payment_method' => $request->payment_method,
            'cart_items' => json_encode($cartItemIds),
        ];

        // Create a pending payment record
        $payment = Payment::create([
            'student_id' => $studentId,
            'method' => $request->payment_method,
            'status' => 0, // Pending
            'total_amount' => $totalAmount,
            'txnid' => $tranId,
        ]);

        // Store payment ID in session for callback
        session(['pending_payment_id' => $payment->id]);

        // Initialize payment with SSLCOMMERZ
        $response = $this->sslcommerz->initiatePayment($paymentData);

        if ($response['success']) {
            // Redirect to SSLCOMMERZ payment gateway
            return redirect($response['gateway_url']);
        }

        // If payment initialization fails, delete pending payment
        $payment->delete();

        return redirect()->route('cart.index')->with('error', 'Payment initialization failed: ' . $response['message']);
    }

    // Payment success callback
    public function paymentSuccess(Request $request)
    {
        // Basic payload
        Log::info('Payment Success Callback payload', $request->all());

        // Detailed meta for debugging
        $meta = [
            'method' => $request->method(),
            'remote_addr' => $request->server('REMOTE_ADDR'),
            'referer' => $request->header('referer'),
            'user_agent' => $request->header('user-agent'),
            'query' => $request->query(),
            'body' => $request->getContent(),
            'headers' => $request->headers->all(),
        ];
        Log::info('Payment Success Callback meta', $meta);

        $tranId = $request->input('tran_id');
        $valId = $request->input('val_id');

        // Validate payment with SSLCOMMERZ
        $validation = $this->sslcommerz->validatePayment($valId);

        // Log full validation result to help diagnose missing course data
        Log::info('SSLCOMMERZ validation result', is_array($validation) ? $validation : ['result' => $validation]);

        if (!$validation['success']) {
            return redirect()->route('cart.index')->with('error', 'Payment validation failed.');
        }

        $validatedData = $validation['data'];

        // Find the payment record
        $payment = Payment::where('txnid', $tranId)->first();

        if (!$payment) {
            return redirect()->route('cart.index')->with('error', 'Payment record not found.');
        }

        // Get the student
        $student = \App\Models\Student::find($payment->student_id);

        if (!$student) {
            return redirect()->route('cart.index')->with('error', 'Student not found.');
        }

        // Re-authenticate the student if not already logged in using session
        if (!session()->has('student_logged_in')) {
            // Set session for the student
            session([
                'student_logged_in' => true,
                'student_name' => $student->name,
                'student_id' => $student->id,
                'student_email' => $student->email,
            ]);
            session()->regenerate(); // Regenerate session ID for security
        }

        // Update payment status to completed
        $payment->update([
            'status' => 1, // Completed
        ]);

        // Get cart items
        $cartItems = Cart::with('course')->where('student_id', $payment->student_id)->get();

        // If cart is empty (session mismatch or gateway flow), try to extract course ids
        // from validated data (value_c) or request payload.
        $courseIds = [];

        if ($cartItems->isNotEmpty()) {
            $courseIds = $cartItems->pluck('course_id')->toArray();
        } else {
            Log::warning('Cart is empty for student_id: ' . $payment->student_id . '; attempting fallback to value_c');

            // value_c may be JSON array like "[1,2]" or comma separated string
            $valueC = $validatedData['value_c'] ?? $request->input('value_c') ?? $request->input('valueC') ?? null;
            if ($valueC) {
                // normalize
                $valueC = trim($valueC);
                // If it looks like JSON array
                if (str_starts_with($valueC, '[') && str_ends_with($valueC, ']')) {
                    $decoded = json_decode($valueC, true);
                    if (is_array($decoded)) {
                        $courseIds = array_map('intval', $decoded);
                    }
                } else {
                    // try comma separated
                    $parts = preg_split('/[,|;\s]+/', $valueC);
                    $courseIds = array_map('intval', array_filter($parts));
                }
            }
        }

        // Create PaymentItems and Enrollments based on courseIds
        Log::info('Payment processing - courseIds resolved', ['payment_id' => $payment->id, 'course_ids' => $courseIds]);

        $createdItems = 0;
        $createdEnrollments = 0;

        foreach ($courseIds as $courseId) {
            $course = \App\Models\Course::find($courseId);
            if (!$course) {
                Log::warning('Course id from payment not found', ['course_id' => $courseId, 'payment_id' => $payment->id]);
                continue;
            }

            $item = PaymentItem::create([
                'payment_id' => $payment->id,
                'course_id' => $course->id,
                'price' => $course->price,
            ]);
            $createdItems++;

            $enrollment = Enrollment::firstOrCreate([
                'student_id' => $payment->student_id,
                'course_id' => $course->id,
            ]);
            // If it was just created, increment
            if ($enrollment && $enrollment->wasRecentlyCreated) {
                $createdEnrollments++;
            }
        }

        Log::info('Payment processing completed', [
            'payment_id' => $payment->id,
            'created_payment_items' => $createdItems,
            'created_enrollments' => $createdEnrollments,
        ]);

        // Clear cart
        Cart::where('student_id', $payment->student_id)->delete();

        // Clear session
        session()->forget('pending_payment_id');

        // Determine whether the request is the browser redirect.
        // SSLCOMMERZ sometimes calls the success URL server-to-server (POST) and
        // also redirects the user's browser (GET). We only generate the one-time
        // token and redirect when this request appears to be from the browser.
        $isBrowserRedirect = $request->isMethod('get') || str_contains(strtolower($request->header('referer', '')), 'sslcommerz');

        if ($isBrowserRedirect) {
            // Generate a short-lived token so the browser can be logged-in securely
            // We use cache to avoid changing DB schema. Token valid for 10 minutes.
            $token = Str::random(64);
            Cache::put('payment_login_' . $token, $payment->student_id, now()->addMinutes(10));
            Log::info('Generated payment login token', ['token' => $token, 'student_id' => $payment->student_id]);

            // Save session
            session()->save();

            // Redirect the browser to a public route that consumes the token,
            // logs in the student for the browser session, and redirects to dashboard.
            return redirect()->route('payment.complete', ['token' => $token]);
        }

        Log::info('Payment processed via server callback; no browser redirect token generated', ['payment_id' => $payment->id, 'meta' => $meta]);

        // When called server-to-server, return a simple OK so the gateway knows we handled it.
        Log::info('Returning OK to gateway for server-to-server callback', ['payment_id' => $payment->id]);
        return response('OK', 200);
    }

    /**
     * Complete payment by consuming the temporary token and logging in the student for the browser.
     */
    public function completeWithToken(Request $request, $token = null)
    {
        Log::info('Entered payment.complete route', ['token' => $token, 'query' => $request->query()]);

        $studentId = null;

        if ($token) {
            $cacheKey = 'payment_login_' . $token;
            $studentId = Cache::pull($cacheKey); // pull ensures one-time use
            Log::info('Consuming payment login token', ['token' => $token, 'found_student_id' => $studentId]);
        }

        // If token missing or not found, try to use tran_id or value_a from query or POST body
        if (!$studentId) {
            $tranId = $request->query('tran_id') ?? $request->query('txnid') ?? $request->input('tran_id') ?? $request->input('txnid');
            $valueA = $request->query('value_a') ?? $request->query('valueA') ?? $request->input('value_a') ?? $request->input('valueA');
            Log::info('Token not found; trying fallback with tran_id/value_a', ['tran_id' => $tranId, 'value_a' => $valueA]);

            if ($valueA) {
                // value_a was set to student_id earlier when initiating payment
                $studentId = is_numeric($valueA) ? (int) $valueA : null;
            }

            if (!$studentId && $tranId) {
                // find recent completed payment with this txnid
                $payment = Payment::where('txnid', $tranId)->where('status', 1)->first();
                if ($payment) {
                    $studentId = $payment->student_id;
                }
            }
        }

        if (!$studentId) {
            Log::warning('Unable to determine student for payment.complete; redirecting to login', ['token' => $token, 'tran_id' => $request->query('tran_id')]);
            return redirect()->route('student.login')->with('error', 'Unable to complete login after payment. Please login to view your purchases.');
        }

        $student = \App\Models\Student::find($studentId);
        if (!$student) {
            Log::warning('Student id resolved but student not found', ['student_id' => $studentId]);
            return redirect()->route('student.login')->with('error', 'Student not found.');
        }

        // Log in the student for the browser session using session
        session([
            'student_logged_in' => true,
            'student_name' => $student->name,
            'student_id' => $student->id,
            'student_email' => $student->email,
        ]);
        $request->session()->regenerate();
        Log::info('Payment complete login performed', ['student_id' => $studentId, 'session_id' => $request->session()->getId()]);

        // Ensure payment items and enrollments exist in case the gateway only redirected the browser
        try {
            // Try to resolve a payment record for this flow
            $tranId = $request->query('tran_id') ?? $request->input('tran_id') ?? null;
            $payment = null;

            if ($tranId) {
                $payment = Payment::where('txnid', $tranId)->first();
            }

            // fallback: recent pending payment for this student
            if (!$payment) {
                $payment = Payment::where('student_id', $studentId)->where('status', 0)->latest()->first();
            }

            if ($payment) {
                // If payment already has items, nothing to do
                if ($payment->items()->exists()) {
                    Log::info('Payment already has items; skipping creation', ['payment_id' => $payment->id]);
                } else {
                    // Build course id list from cart or from request value_c
                    $cartItems = Cart::with('course')->where('student_id', $studentId)->get();
                    $courseIds = [];

                    if ($cartItems->isNotEmpty()) {
                        $courseIds = $cartItems->pluck('course_id')->toArray();
                    } else {
                        $valueC = $request->query('value_c') ?? $request->input('value_c') ?? $request->input('valueC') ?? null;
                        if ($valueC) {
                            $valueC = trim($valueC);
                            if (str_starts_with($valueC, '[') && str_ends_with($valueC, ']')) {
                                $decoded = json_decode($valueC, true);
                                if (is_array($decoded)) {
                                    $courseIds = array_map('intval', $decoded);
                                }
                            } else {
                                $parts = preg_split('/[,|;\s]+/', $valueC);
                                $courseIds = array_map('intval', array_filter($parts));
                            }
                        }
                    }

                    Log::info('Completing payment on browser-return; courseIds resolved', ['payment_id' => $payment->id, 'course_ids' => $courseIds]);

                    $createdItems = 0;
                    $createdEnrollments = 0;

                    foreach ($courseIds as $courseId) {
                        $course = \App\Models\Course::find($courseId);
                        if (!$course) {
                            Log::warning('Course id from payment not found during completeWithToken', ['course_id' => $courseId, 'payment_id' => $payment->id]);
                            continue;
                        }

                        $item = PaymentItem::firstOrCreate([
                            'payment_id' => $payment->id,
                            'course_id' => $course->id,
                        ], [
                            'price' => $course->price,
                        ]);

                        if ($item && $item->wasRecentlyCreated) {
                            $createdItems++;
                        }

                        $enrollment = Enrollment::firstOrCreate([
                            'student_id' => $payment->student_id,
                            'course_id' => $course->id,
                        ]);

                        if ($enrollment && $enrollment->wasRecentlyCreated) {
                            $createdEnrollments++;
                        }
                    }

                    // mark payment completed and cleanup cart + session key
                    $payment->update(['status' => 1]);
                    Cart::where('student_id', $payment->student_id)->delete();
                    session()->forget('pending_payment_id');

                    Log::info('Browser-return payment completion results', ['payment_id' => $payment->id, 'created_payment_items' => $createdItems, 'created_enrollments' => $createdEnrollments]);
                }
            } else {
                // If no payment record but the browser session still has the cart,
                // create a completed Payment and PaymentItems from the cart so the
                // student's dashboard reflects the purchase and the cart is cleared.
                $cartItems = Cart::with('course')->where('student_id', $studentId)->get();

                if ($cartItems->isNotEmpty()) {
                    try {
                        $totalAmount = $cartItems->sum(fn($it) => $it->course->price);
                        $tranId = $request->query('tran_id') ?? $request->input('tran_id') ?? ('EDU-' . time() . '-' . Str::random(6));

                        $newPayment = Payment::create([
                            'student_id' => $studentId,
                            'method' => $request->query('value_b') ?? $request->input('value_b') ?? 'unknown',
                            'status' => 1,
                            'total_amount' => $totalAmount,
                            'txnid' => $tranId,
                        ]);

                        $createdItems = 0;
                        $createdEnrollments = 0;

                        foreach ($cartItems as $cartItem) {
                            $course = $cartItem->course;
                            if (!$course)
                                continue;

                            $item = PaymentItem::firstOrCreate([
                                'payment_id' => $newPayment->id,
                                'course_id' => $course->id,
                            ], [
                                'price' => $course->price,
                            ]);

                            if ($item && $item->wasRecentlyCreated)
                                $createdItems++;

                            $enrollment = Enrollment::firstOrCreate([
                                'student_id' => $studentId,
                                'course_id' => $course->id,
                            ]);

                            if ($enrollment && $enrollment->wasRecentlyCreated)
                                $createdEnrollments++;
                        }

                        // Clear cart and session pending flag
                        Cart::where('student_id', $studentId)->delete();
                        session()->forget('pending_payment_id');

                        Log::info('Created payment from browser cart during completeWithToken', ['payment_id' => $newPayment->id, 'created_payment_items' => $createdItems, 'created_enrollments' => $createdEnrollments]);
                    } catch (\Exception $e) {
                        Log::error('Failed to create payment from browser cart', ['error' => $e->getMessage()]);
                    }
                } else {
                    Log::warning('No payment record found during completeWithToken; nothing to create', ['student_id' => $studentId]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error while completing payment on browser return', ['error' => $e->getMessage()]);
        }
        // Redirect to dashboard with success message
        return redirect()->route('student.dashboard')->with('success', 'Payment successful! You have enrolled in the courses.');
    }

    // Payment fail callback
    public function paymentFail(Request $request)
    {
        Log::info('Payment Failed Callback', $request->all());

        $tranId = $request->input('tran_id');

        // Find and delete the pending payment
        $payment = Payment::where('txnid', $tranId)->first();

        if ($payment) {
            // Re-authenticate the student if not already logged in using session
            if (!session()->has('student_logged_in')) {
                $student = \App\Models\Student::find($payment->student_id);
                if ($student) {
                    session([
                        'student_logged_in' => true,
                        'student_name' => $student->name,
                        'student_id' => $student->id,
                        'student_email' => $student->email,
                    ]);
                    session()->regenerate();
                    session()->save();
                }
            }

            if ($payment->status == 0) {
                $payment->delete();
            }
        }

        session()->forget('pending_payment_id');

        return redirect()->route('cart.index')->with('error', 'Payment failed. Please try again.');
    }

    // Payment cancel callback
    public function paymentCancel(Request $request)
    {
        Log::info('Payment Cancelled Callback', $request->all());

        $tranId = $request->input('tran_id');

        // Find and delete the pending payment
        $payment = Payment::where('txnid', $tranId)->first();

        if ($payment) {
            // Re-authenticate the student if not already logged in using session
            if (!session()->has('student_logged_in')) {
                $student = \App\Models\Student::find($payment->student_id);
                if ($student) {
                    session([
                        'student_logged_in' => true,
                        'student_name' => $student->name,
                        'student_id' => $student->id,
                        'student_email' => $student->email,
                    ]);
                    session()->regenerate();
                    session()->save();
                }
            }

            if ($payment->status == 0) {
                $payment->delete();
            }
        }

        session()->forget('pending_payment_id');

        return redirect()->route('cart.index')->with('warning', 'Payment was cancelled.');
    }

    // IPN (Instant Payment Notification) callback
    public function paymentIPN(Request $request)
    {
        Log::info('Payment IPN Callback', $request->all());

        $tranId = $request->input('tran_id');
        $status = $request->input('status');

        // Find the payment record
        $payment = Payment::where('txnid', $tranId)->first();

        if ($payment) {
            if ($status === 'VALID' || $status === 'VALIDATED') {
                $payment->update(['status' => 1]); // Completed
            } else {
                $payment->update(['status' => 2]); // Failed
            }
        }

        return response('IPN received', 200);
    }
}
