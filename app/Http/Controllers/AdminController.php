<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        // Basic Stats
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 1)->count();
        $totalInstructors = Instructor::count();
        $activeInstructors = Instructor::where('status', 1)->count();
        $totalCourses = Course::count();
        $activeCourses = Course::where('status', 2)->count(); // 2 = active
        $pendingCourses = Course::where('status', 0)->count(); // 0 = pending
        $totalEnrollments = Enrollment::count();
        $totalRevenue = Payment::sum('total_amount') ?? 0;

        // This Month Revenue
        $thisMonthRevenue = Payment::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->sum('total_amount') ?? 0;

        // Last Month Revenue for growth calculation
        $lastMonthRevenue = Payment::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('total_amount') ?? 0;

        // Calculate Growth
        if ($lastMonthRevenue > 0) {
            $growthPercentage = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
            $growthDirection = $growthPercentage >= 0 ? 'up' : 'down';
        } else {
            $growthPercentage = $thisMonthRevenue > 0 ? 100 : 0;
            $growthDirection = 'up';
        }

        // Recent Enrollments
        $recentEnrollments = Enrollment::with(['student', 'course'])
            ->latest()
            ->take(5)
            ->get();

        // Popular Courses
        $popularCourses = Course::withCount(['enrollments as students_count'])
            ->orderBy('students_count', 'desc')
            ->take(5)
            ->get();

        // Chart Data - Last 6 months
        $monthLabels = [];
        $monthCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->format('M Y');
            $monthCounts[] = Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $data = [
            'admin_name' => session('admin_name', 'Admin'),
            'admin_email' => session('admin_email'),
            'totalStudents' => $totalStudents,
            'activeStudents' => $activeStudents,
            'totalInstructors' => $totalInstructors,
            'activeInstructors' => $activeInstructors,
            'totalCourses' => $totalCourses,
            'activeCourses' => $activeCourses,
            'pendingCourses' => $pendingCourses,
            'totalEnrollments' => $totalEnrollments,
            'totalRevenue' => $totalRevenue,
            'thisMonthRevenue' => $thisMonthRevenue,
            'growthPercentage' => $growthPercentage,
            'growthDirection' => $growthDirection,
            'recentEnrollments' => $recentEnrollments,
            'popularCourses' => $popularCourses,
            'monthLabels' => $monthLabels,
            'monthCounts' => $monthCounts,
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * Export Report (placeholder)
     */
    public function exportReport()
    {
        // TODO: Add your export logic here
        return redirect()->route('admin.dashboard')->with('info', 'Export feature coming soon!');
    }
}
