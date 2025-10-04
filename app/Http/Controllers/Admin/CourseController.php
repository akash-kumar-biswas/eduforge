<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Show list of courses
    public function index()
    {
        $courses = Course::with('instructor')->get();
        return view('admin.courses.index', compact('courses'));
    }

    // Show form to create a new course
    public function create()
    {
        $instructors = Instructor::where('status', 1)->get();
        return view('admin.courses.create', compact('instructors'));
    }

    // Store new course
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'instructor_id' => 'required|exists:instructors,id',
            'type' => 'required|in:free,paid',
            'price' => 'required_if:type,paid|numeric|min:0',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'instructor_id', 'type', 'duration', 'price', 'difficulty', 'status']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/courses'), $imageName);
            $data['image'] = $imageName;
        }

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    // Show course details
    public function show($id)
    {
        $course = Course::with('instructor')->findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    // Show form to edit course
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $instructors = Instructor::where('status', 1)->get();
        return view('admin.courses.edit', compact('course', 'instructors'));
    }

    // Update course
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'instructor_id' => 'required|exists:instructors,id',
            'type' => 'required|in:free,paid',
            'price' => 'required_if:type,paid|numeric|min:0',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $course = Course::findOrFail($id);
        $data = $request->only(['title', 'description', 'instructor_id', 'type', 'duration', 'price', 'difficulty', 'status']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/courses'), $imageName);
            $data['image'] = $imageName;
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    // Delete course
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Delete image if exists
        if ($course->image && file_exists(public_path('uploads/courses/' . $course->image))) {
            unlink(public_path('uploads/courses/' . $course->image));
        }

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }
}
