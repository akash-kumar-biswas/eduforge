<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a list of all active courses (Blade view or API).
     */
    public function index(Request $request)
    {
        $query = Course::with('instructor')->where('status', 2); // only active courses

        // ✅ Search by course name (match from beginning)
        if ($request->filled('search')) {
            $query->where('title', 'like', $request->search . '%');
        }

        // ✅ Apply filters if provided
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('duration')) {
            // Define custom duration ranges
            switch ($request->duration) {
                case 'short':
                    $query->where('duration', '<=', 5);
                    break;
                case 'medium':
                    $query->whereBetween('duration', [6, 20]);
                    break;
                case 'long':
                    $query->where('duration', '>', 20);
                    break;
            }
        }

        $courses = $query->latest()->get();

        // Return JSON if request expects API response
        if ($request->wantsJson()) {
            return response()->json($courses);
        }

        // Otherwise return Blade view
        return view('courses', compact('courses'));
    }

    /**
     * Show a single course.
     */
    public function show(Request $request, $id)
    {
        $course = Course::with('instructor')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json($course);
        }

        return view('course-details', compact('course'));
    }

    /**
     * Optional: Store a new course (API only)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'nullable|exists:instructors,id',
            'type' => 'required|in:free,paid',
            'price' => 'required|numeric|min:0',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'duration' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1,2',
        ]);

        $course = Course::create($request->all());

        return response()->json($course, 201);
    }

    /**
     * Optional: Delete a course (soft delete) (API only)
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted successfully']);
    }
}
