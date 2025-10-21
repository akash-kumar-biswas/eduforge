<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InstructorApplicationController extends Controller
{
    /**
     * Show the instructor application form
     */
    public function showApplicationForm()
    {
        return view('instructor.apply');
    }

    /**
     * Handle the instructor application submission
     */
    public function submitApplication(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'expertise' => 'required|string|max:255',
            'experience' => 'required|string',
            'motivation' => 'required|string|max:1000',
            'bio' => 'nullable|string|max:1000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            'linkedin' => 'nullable|url|max:255',
            'portfolio' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Handle CV upload
            $cvPath = null;
            if ($request->hasFile('cv')) {
                $cv = $request->file('cv');
                $cvName = time() . '_' . $cv->getClientOriginalName();
                $cv->move(public_path('uploads/instructor-applications'), $cvName);
                $cvPath = public_path('uploads/instructor-applications/' . $cvName);
            }

            // Prepare data for email
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'expertise' => $request->expertise,
                'experience' => $request->experience,
                'motivation' => $request->motivation,
                'bio' => $request->bio,
                'linkedin' => $request->linkedin,
                'portfolio' => $request->portfolio,
            ];

            // Send email to admin
            Mail::send('emails.instructor-application', ['data' => $data], function ($message) use ($cvPath, $request) {
                $message->to('akash41bt@gmail.com')
                    ->subject('New Instructor Application - ' . $request->name)
                    ->from(config('mail.from.address'), config('mail.from.name'));

                // Attach CV if it exists
                if ($cvPath && file_exists($cvPath)) {
                    $message->attach($cvPath);
                }
            });

            return redirect()->back()->with(
                'success',
                'Your application has been submitted successfully! Our admin team will review your application and contact you via email within 3-5 business days.'
            );

        } catch (\Exception $e) {
            \Log::error('Instructor Application Error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'An error occurred while submitting your application. Please try again later.')
                ->withInput();
        }
    }
}
