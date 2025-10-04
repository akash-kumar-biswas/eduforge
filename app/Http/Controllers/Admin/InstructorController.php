<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $data['password'] = Hash::make($request->password);
        $data['status'] = $request->has('status') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/instructors'), $imageName);
            $data['image'] = $imageName;
        }

        Instructor::create($data);

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor created successfully!');
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

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $instructor->update($data);

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
