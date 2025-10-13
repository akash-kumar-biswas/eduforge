<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    // List all enrollments
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->get();
        return response()->json($enrollments);
    }

    // Enroll a student in a course
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrollment = Enrollment::create($request->all());
        return response()->json($enrollment, 201);
    }

    // Show a single enrollment
    public function show($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
        return response()->json($enrollment);
    }

    // Delete enrollment (soft delete)
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return response()->json(['message' => 'Enrollment removed successfully']);
    }
}
