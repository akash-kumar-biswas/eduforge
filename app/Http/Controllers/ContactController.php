<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'messageContent' => $request->message,  // Renamed to avoid conflict with Mail $message object
        ];

        try {
            // Send email to akash41bt@gmail.com (TEST EMAIL)
            Mail::send('emails.contact', $data, function ($message) use ($data) {
                $message->to('akash41bt@gmail.com')
                    ->subject('Contact Form: ' . $data['subject'])
                    ->replyTo($data['email'], $data['name']);
            });

            return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Contact form error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }
}
