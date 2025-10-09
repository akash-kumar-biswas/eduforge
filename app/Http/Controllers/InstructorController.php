<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    // Show list of instructors
    public function index()
    {
        $instructors = Instructor::all();
        return view('admin.instructors.index', compact('instructors'));
    }

    public function instructorsList()
    {
        // Optional: Fetch instructors, or only display logged-in instructor’s name.
        $instructors = Instructor::all();
        $instructorName = session('instructor_name');

        return view('instructor.instructors', compact('instructors', 'instructorName'));
    }

    public function enrollments()
    {
        if (!session('instructor_logged_in')) {
            return redirect()->route('instructor.login')->with('error', 'Please login first.');
        }

        $instructorId = session('instructor_id');
        $instructor = Instructor::find($instructorId);

        if (!$instructor) {
            session()->forget(['instructor_logged_in', 'instructor_name', 'instructor_id']);
            return redirect()->route('instructor.login')->with('error', 'Instructor not found. Please login again.');
        }

        $courses = Course::with([
            'enrollments.student' => function ($query) {
                $query->select('students.id', 'students.name', 'students.email', 'students.image');
            }
        ])
            ->where('instructor_id', $instructor->id)
            ->orderBy('title')
            ->get();

        $courses->each(function ($course) {
            $course->enrollments = $course->enrollments->sortByDesc('created_at')->values();
        });

        $allEnrollments = $courses->flatMap(function ($course) {
            return $course->enrollments->map(function ($enrollment) use ($course) {
                $enrollment->course_title = $course->title;
                return $enrollment;
            });
        });

        $coursesWithEnrollments = $courses->filter(function ($course) {
            return $course->enrollments->isNotEmpty();
        })->count();

        $stats = [
            'total_enrollments' => $allEnrollments->count(),
            'unique_students' => $allEnrollments->pluck('student_id')->unique()->count(),
            'courses_with_students' => $coursesWithEnrollments,
            'recent_enrollments' => $allEnrollments->where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('instructor.enrollments', [
            'courses' => $courses,
            'stats' => $stats,
            'instructor' => $instructor,
        ]);
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
            'name' => 'required',
            'email' => 'required|email|unique:instructors',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'bio', 'status']);
        $data['password'] = Hash::make($request->password);

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
        $instructor = Instructor::findOrFail($id);
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
            'name' => 'required',
            'email' => 'required|email|unique:instructors,email,' . $id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $instructor = Instructor::findOrFail($id);
        $data = $request->only(['name', 'email', 'bio', 'status']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/instructors'), $imageName);
            $data['image'] = $imageName;

            // Delete old image if exists
            if ($instructor->image && file_exists(public_path('uploads/instructors/' . $instructor->image))) {
                unlink(public_path('uploads/instructors/' . $instructor->image));
            }
        }

        $instructor->update($data);

        // Update password if provided
        if ($request->filled('password')) {
            $instructor->password = Hash::make($request->password);
            $instructor->save();
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

    // Instructor dashboard
    public function dashboard()
    {
        // Check if instructor is logged in
        if (!session('instructor_logged_in')) {
            return redirect()->route('instructor.login');
        }

        $instructorId = session('instructor_id');

        // Fetch courses created by this instructor along with enrollment counts
        $courses = Course::where('instructor_id', $instructorId)
            ->orderByDesc('created_at')
            ->withCount('enrollments')
            ->get();

        // Aggregate simple metrics
        $totalCourses = $courses->count();
        $activeCourses = $courses->where('status', 'active')->count();

        $enrollmentsQuery = Enrollment::whereHas('course', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        });

        $totalEnrollments = (clone $enrollmentsQuery)->count();
        $uniqueStudents = (clone $enrollmentsQuery)->distinct('student_id')->count('student_id');

        $recentEnrollments = (clone $enrollmentsQuery)
            ->with(['student:id,name,email,image', 'course:id,title'])
            ->latest()
            ->take(5)
            ->get();

        return view('instructor.dashboard', [
            'instructor_name' => session('instructor_name'),
            'courses' => $courses,
            'stats' => [
                'total_courses' => $totalCourses,
                'active_courses' => $activeCourses,
                'total_enrollments' => $totalEnrollments,
                'unique_students' => $uniqueStudents,
            ],
            'recentEnrollments' => $recentEnrollments,
        ]);
    }

    // Show instructor profile
    public function profile()
    {
        // Get the logged-in instructor
        $instructor = Instructor::findOrFail(session('instructor_id'));
        return view('instructor.profile', compact('instructor'));
    }

    // Show edit profile form
    public function editProfile()
    {
        $instructor = Instructor::findOrFail(session('instructor_id'));
        return view('instructor.edit-profile', compact('instructor'));
    }

    // Update instructor profile
    public function updateProfile(Request $request)
    {
        $instructor = Instructor::findOrFail(session('instructor_id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:instructors,email,' . $instructor->id,
            'bio' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $instructor->name = $request->name;
        $instructor->email = $request->email;
        $instructor->bio = $request->bio;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/instructors'), $imageName);

            // Delete old image if exists
            if ($instructor->image && file_exists(public_path('uploads/instructors/' . $instructor->image))) {
                unlink(public_path('uploads/instructors/' . $instructor->image));
            }

            $instructor->image = $imageName;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $instructor->password = Hash::make($request->password);
        }

        $instructor->save();

        // Update session data
        session(['instructor_name' => $instructor->name]);

        return redirect()->route('instructor.profile')->with('success', 'Profile updated successfully!');
    }

    // ========== COURSE MANAGEMENT ==========

    // Show all courses for the logged-in instructor
    public function courses()
    {
        $courses = Course::where('instructor_id', session('instructor_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('instructor.courses.index', compact('courses'));
    }

    // Show form to create a new course
    public function createCourse()
    {
        return view('instructor.courses.create');
    }

    // Store a new course
    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:free,paid',
            'price' => 'required_if:type,paid|nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'content_url' => 'nullable|url|max:500',
            'status' => 'required|in:0,1,2',
        ]);

        $data = $request->only(['title', 'description', 'type', 'difficulty', 'content_url', 'status']);
        $data['instructor_id'] = session('instructor_id');

        // Extract numeric value from duration (e.g., "40 hours" -> 40)
        if ($request->duration) {
            $data['duration'] = (int) preg_replace('/[^0-9]/', '', $request->duration);
        }

        // Set price based on type
        if ($request->type === 'free') {
            $data['price'] = 0;
        } else {
            $data['price'] = $request->price;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/courses'), $imageName);
            $data['image'] = $imageName;
        }

        Course::create($data);

        return redirect()->route('instructor.courses')->with('success', 'Course created successfully!');
    }

    // Show form to edit a course
    public function editCourse($id)
    {
        $course = Course::where('id', $id)
            ->where('instructor_id', session('instructor_id'))
            ->firstOrFail();

        return view('instructor.courses.edit', compact('course'));
    }

    // Update a course
    public function updateCourse(Request $request, $id)
    {
        $course = Course::where('id', $id)
            ->where('instructor_id', session('instructor_id'))
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:free,paid',
            'price' => 'required_if:type,paid|nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'content_url' => 'nullable|url|max:500',
            'status' => 'required|in:0,1,2',
        ]);

        $data = $request->only(['title', 'description', 'type', 'difficulty', 'content_url', 'status']);

        // Extract numeric value from duration (e.g., "40 hours" -> 40)
        if ($request->duration) {
            $data['duration'] = (int) preg_replace('/[^0-9]/', '', $request->duration);
        }

        // Set price based on type
        if ($request->type === 'free') {
            $data['price'] = 0;
        } else {
            $data['price'] = $request->price;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/courses'), $imageName);

            // Delete old image if exists
            if ($course->image && file_exists(public_path('uploads/courses/' . $course->image))) {
                unlink(public_path('uploads/courses/' . $course->image));
            }

            $data['image'] = $imageName;
        }

        $course->update($data);

        return redirect()->route('instructor.courses')->with('success', 'Course updated successfully!');
    }

    // Delete a course
    public function destroyCourse($id)
    {
        $course = Course::where('id', $id)
            ->where('instructor_id', session('instructor_id'))
            ->firstOrFail();

        // Delete image if exists
        if ($course->image && file_exists(public_path('uploads/courses/' . $course->image))) {
            unlink(public_path('uploads/courses/' . $course->image));
        }

        $course->delete();

        return redirect()->route('instructor.courses')->with('success', 'Course deleted successfully!');
    }
}
