<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::guard('student')->user();

        // Get all enrolled courses with instructor info
        $allCourses = $student->courses()
            ->with('instructor')
            ->withPivot(['created_at', 'is_completed'])
            ->get();

        // Calculate progress for each course (for now, using random percentage)
        $allCourses->each(function ($course) {
            $course->progress = rand(10, 95); // Replace with actual progress calculation
        });

        // Get enrolled courses count
        $enrolledCount = $allCourses->count();

        // Completed courses count: use the authoritative students.complete_course column
        $completedCount = (int) $student->complete_course;

        // Get purchase history with grouped payments
        $purchaseHistory = \App\Models\Payment::where('student_id', $student->id)
            ->with(['items.course.instructor'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($payment) {
                $payment->total_courses = $payment->items->count();
                return $payment;
            });

        // Get cart items count
        $cartCount = \App\Models\Cart::where('student_id', $student->id)->count();

        return view('student.dashboard', compact('student', 'allCourses', 'enrolledCount', 'completedCount', 'purchaseHistory', 'cartCount'));
    }

    public function index()
    {
        return response()->json(Student::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|min:6',
        ]);

        $student = Student::create([
            'name' => $request->name_en,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status ?? 1,
        ]);

        return response()->json($student, 201);
    }

    public function show($id)
    {
        return response()->json(Student::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->except('password'));

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
            $student->save();
        }

        return response()->json($student);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(['message' => 'Student deleted successfully']);
    }

    public function watchCourse(Course $course)
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('student.login');
        }

        $isEnrolled = $student->courses()->where('courses.id', $course->id)->exists();

        if (!$isEnrolled) {
            return redirect()->route('student.dashboard')->with('error', 'You are not enrolled in this course.');
        }

        // Prioritize uploaded video over content URL
        if ($course->video_path) {
            $videoData = [
                'type' => 'video',
                'url' => asset('uploads/videos/' . $course->video_path),
                'mime' => 'video/' . pathinfo($course->video_path, PATHINFO_EXTENSION),
            ];
        } else {
            $videoData = $this->resolveVideoSource($course->content_url);
        }

        return view('student.watch-course', [
            'course' => $course,
            'videoType' => $videoData['type'],
            'videoUrl' => $videoData['url'],
            'videoMime' => $videoData['mime'],
        ]);
    }

    /**
     * AJAX endpoint: mark a course as completed for the authenticated student.
     * Increments `complete_course` on the students table and creates enrollment
     * record if missing (idempotent).
     */
    public function completeCourseAjax(Course $course)
    {
        $student = Auth::guard('student')->user();

        // Log the incoming request so we can debug client/server interactions
        Log::info('Entered completeCourseAjax', [
            'student_id' => $student->id ?? null,
            'course_id' => $course->id ?? null,
            'method' => request()->method(),
            'ip' => request()->ip(),
            'headers' => collect(request()->headers->all())->mapWithKeys(function ($v, $k) {
                return [$k => $v[0] ?? null];
            })->toArray(),
        ]);

        if (!$student) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Ensure the student is enrolled in the course before marking complete
        $isEnrolled = $student->courses()->where('courses.id', $course->id)->exists();
        if (!$isEnrolled) {
            // Optionally auto-enroll? For now, return an error.
            return response()->json(['error' => 'Not enrolled in this course'], 403);
        }

        try {
            $enrollment = \App\Models\Enrollment::firstOrCreate([
                'student_id' => $student->id,
                'course_id' => $course->id,
            ]);

            $wasCompleted = (bool) ($enrollment->is_completed ?? false);

            if (!$wasCompleted) {
                // mark completed and increment student's counter
                $enrollment->is_completed = true;
                $enrollment->save();

                $student->increment('complete_course');
            }

            return response()->json([
                'success' => true,
                'complete_course' => $student->fresh()->complete_course,
                'enrollment_completed' => true,
            ]);
        } catch (\Exception $e) {
            Log::error('completeCourseAjax error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Could not update completion: ' . $e->getMessage()], 500);
        }
    }

    protected function resolveVideoSource(?string $contentUrl): array
    {
        if (!$contentUrl) {
            return ['type' => 'none', 'url' => null, 'mime' => null];
        }

        $url = trim($contentUrl);

        if (!Str::startsWith($url, ['http://', 'https://'])) {
            $url = asset($url);
        }

        if (Str::contains($url, ['youtube.com', 'youtu.be'])) {
            $videoId = null;

            if (Str::contains($url, 'youtu.be')) {
                $segments = explode('/', parse_url($url, PHP_URL_PATH) ?? '');
                $videoId = end($segments);
            } else {
                parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $query);
                $videoId = $query['v'] ?? null;

                if (!$videoId && Str::contains($url, '/embed/')) {
                    $segments = explode('/', parse_url($url, PHP_URL_PATH) ?? '');
                    $videoId = end($segments);
                }
            }

            if ($videoId) {
                return [
                    'type' => 'iframe',
                    'url' => 'https://www.youtube.com/embed/' . $videoId,
                    'mime' => null,
                ];
            }
        }

        if (Str::contains($url, ['vimeo.com'])) {
            $path = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');
            if ($path) {
                if (Str::startsWith($path, 'player.vimeo.com/video')) {
                    return ['type' => 'iframe', 'url' => $url, 'mime' => null];
                }

                $segments = explode('/', $path);
                $videoId = end($segments);

                if ($videoId) {
                    return [
                        'type' => 'iframe',
                        'url' => 'https://player.vimeo.com/video/' . $videoId,
                        'mime' => null,
                    ];
                }
            }
        }

        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));

        $videoMimeMap = [
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'ogv' => 'video/ogg',
            'ogg' => 'video/ogg',
        ];

        if ($extension && array_key_exists($extension, $videoMimeMap)) {
            return [
                'type' => 'video',
                'url' => $url,
                'mime' => $videoMimeMap[$extension],
            ];
        }

        return ['type' => 'iframe', 'url' => $url, 'mime' => null];
    }
}
