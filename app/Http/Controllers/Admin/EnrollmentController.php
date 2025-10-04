<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Show list of enrollments
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course.instructor'])->get();
        return view('admin.enrollments.index', compact('enrollments'));
    }

    // Show form to create a new enrollment
    public function create()
    {
        $students = Student::where('status', 1)->get();
        $courses = Course::where('status', 2)->get();
        return view('admin.enrollments.create', compact('students', 'courses'));
    }

    // Store new enrollment
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Check if enrollment already exists
        $exists = Enrollment::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This student is already enrolled in this course!');
        }

        Enrollment::create($request->only(['student_id', 'course_id']));

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment created successfully!');
    }

    // Show enrollment details
    public function show($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
        return view('admin.enrollments.show', compact('enrollment'));
    }

    // Show form to edit enrollment
    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $students = Student::where('status', 1)->get();
        $courses = Course::where('status', 2)->get();
        return view('admin.enrollments.edit', compact('enrollment', 'students', 'courses'));
    }

    // Update enrollment
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrollment = Enrollment::findOrFail($id);

        // Check if enrollment already exists (excluding current)
        $exists = Enrollment::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This student is already enrolled in this course!');
        }

        $enrollment->update($request->only(['student_id', 'course_id']));

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment updated successfully!');
    }

    // Delete enrollment
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment deleted successfully!');
    }
}
