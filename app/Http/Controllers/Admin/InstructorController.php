<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class InstructorController extends Controller
{
    // Show list of instructors
    public function index()
    {
        $instructors = Instructor::withCount('courses')->get();
        return view('admin.instructors.index', compact('instructors'));
    }

    // Show form to create a new instructor
    public function create()
    {
        return view('admin.instructors.create');
    }

    // Store new instructor
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors',
            'password' => 'required|min:6',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'email', 'bio', 'status']);

        // Store the plain password to send via email
        $plainPassword = $request->password;

        $data['password'] = Hash::make($request->password);
        $data['status'] = $request->has('status') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/instructors'), $imageName);
            $data['image'] = $imageName;
        }

        $instructor = Instructor::create($data);

        // Send welcome email with credentials
        try {
            Mail::send('emails.instructor-welcome', [
                'instructorName' => $instructor->name,
                'instructorEmail' => $instructor->email,
                'password' => $plainPassword,
                'loginUrl' => route('instructor.login'),
            ], function ($message) use ($instructor) {
                $message->to($instructor->email)
                    ->subject('Welcome to EduForge - Your Instructor Account is Ready!')
                    ->from('akash41bt@gmail.com', 'EduForge Admin');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send instructor welcome email: ' . $e->getMessage());
        }

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor added successfully! A welcome email with login credentials has been sent to ' . $instructor->email);
    }

    // Show instructor details
    public function show($id)
    {
        $instructor = Instructor::withCount('courses')->findOrFail($id);
        return view('admin.instructors.show', compact('instructor'));
    }

    // Show form to edit instructor
    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('admin.instructors.edit', compact('instructor'));
    }

    // Update instructor
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email,' . $id,
            'password' => 'nullable|min:6',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $instructor = Instructor::findOrFail($id);
        $data = $request->only(['name', 'email', 'bio']);
        $data['status'] = $request->has('status') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/instructors'), $imageName);
            $data['image'] = $imageName;
        }

        // Track if password is being updated
        $passwordUpdated = false;
        $newPassword = null;

        // Update password if provided
        if ($request->filled('password')) {
            $newPassword = $request->password;
            $data['password'] = Hash::make($request->password);
            $passwordUpdated = true;
        }

        $instructor->update($data);

        // Send email if password was updated
        if ($passwordUpdated && $newPassword) {
            try {
                Mail::send('emails.instructor-password-updated', [
                    'instructorName' => $instructor->name,
                    'instructorEmail' => $instructor->email,
                    'newPassword' => $newPassword,
                    'loginUrl' => route('instructor.login'),
                ], function ($message) use ($instructor) {
                    $message->to($instructor->email)
                        ->subject('Your EduForge Password Has Been Updated')
                        ->from('akash41bt@gmail.com', 'EduForge Admin');
                });

                return redirect()->route('admin.instructors.index')->with('success', 'Instructor updated successfully! A password update email has been sent to ' . $instructor->email);
            } catch (\Exception $e) {
                \Log::error('Failed to send password update email: ' . $e->getMessage());
                return redirect()->route('admin.instructors.index')->with('success', 'Instructor updated successfully! (Note: Email notification could not be sent)');
            }
        }

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor updated successfully!');
    }

    // Delete instructor
    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);

        // Delete image if exists
        if ($instructor->image && file_exists(public_path('uploads/instructors/' . $instructor->image))) {
            unlink(public_path('uploads/instructors/' . $instructor->image));
        }

        $instructor->delete();

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor deleted successfully!');
    }
}
