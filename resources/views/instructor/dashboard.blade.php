@extends('layouts.instructor')

@section('title', 'Instructor Dashboard')

@section('content')
<style>
    /* === Global Brand Theme === */
    :root {
        --brand-color: #04317aff;
    }

    /* === Stat Cards (Top 4) === */
    .stats-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        transition: all 0.2s ease;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .stats-card:hover {
        border-color: var(--brand-color);
        box-shadow: 0 4px 12px rgba(4, 49, 122, 0.15);
        transform: translateY(-2px);
    }

    /* === Primary Buttons === */
    .btn-primary {
        background-color: var(--brand-color) !important;
        border-color: var(--brand-color) !important;
        color: #fff !important;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background-color: var(--brand-color) !important;
        border-color: var(--brand-color) !important;
        box-shadow: 0 4px 8px rgba(4, 49, 122, 0.25);
        transform: translateY(-1px);
    }

    /* === Outline Buttons === */
    .btn-outline-primary {
        color: var(--brand-color) !important;
        border-color: var(--brand-color) !important;
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover {
        background-color: var(--brand-color) !important;
        color: #fff !important;
        box-shadow: 0 4px 8px rgba(4, 49, 122, 0.25);
        transform: translateY(-1px);
    }

    /* === Outline Secondary (Converted to Brand Color) === */
    .btn-outline-secondary {
        color: var(--brand-color) !important;
        border-color: var(--brand-color) !important;
        transition: all 0.2s ease;
    }

    .btn-outline-secondary:hover {
        background-color: var(--brand-color) !important;
        color: #fff !important;
        border-color: var(--brand-color) !important;
        box-shadow: 0 4px 8px rgba(4, 49, 122, 0.25);
        transform: translateY(-1px);
    }

    /* === Badges for consistency === */
    .badge.bg-primary {
        background-color: var(--brand-color) !important;
    }

    /* === General Aesthetic Improvements === */
    .card-header.bg-light {
        background-color: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0;
    }

    .fw-semibold {
        font-weight: 600;
    }

    .text-brand {
        color: var(--brand-color) !important;
    }
</style>

<div class="container my-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="mb-1">Welcome, {{ $instructor_name }}</h2>
            <p class="text-muted mb-0">Here is a quick snapshot of your teaching activity.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create Course
            </a>
            <a href="{{ route('instructor.enrollments') }}" class="btn btn-outline-primary">
                <i class="bi bi-journal-check"></i> View Enrollments
            </a>
        </div>
    </div>

    <!-- === Stats Cards === -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Courses</p>
                    <h3 class="fw-bold mb-0 text-brand">{{ $stats['total_courses'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Active Courses</p>
                    <h3 class="fw-bold mb-0 text-brand">{{ $stats['active_courses'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Enrollments</p>
                    <h3 class="fw-bold mb-0 text-brand">{{ $stats['total_enrollments'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Unique Students</p>
                    <h3 class="fw-bold mb-0 text-brand">{{ $stats['unique_students'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- === Recent Enrollments & Courses === -->
    <div class="row g-4">
        <!-- Recent Enrollments -->
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <strong><i class="bi bi-people me-2 text-brand"></i>Recent Enrollments</strong>
                </div>
                <div class="card-body">
                    @if($recentEnrollments->isEmpty())
                        <p class="text-muted mb-0">No enrollments yet. Once students enroll in your courses, you will see them here.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($recentEnrollments as $enrollment)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ optional($enrollment->student)->name ?? 'Unknown student' }}</div>
                                        <small class="text-muted">{{ optional($enrollment->course)->title ?? 'Unknown course' }}</small>
                                    </div>
                                    <small class="text-muted">{{ $enrollment->created_at->format('M d, Y') }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Your Courses -->
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <strong><i class="bi bi-book me-2 text-brand"></i>Your Courses</strong>
                    <a href="{{ route('instructor.courses') }}" class="btn btn-sm btn-outline-secondary">Manage</a>
                </div>
                <div class="card-body">
                    @if($courses->isEmpty())
                        <p class="text-muted mb-0">You have not created any courses yet.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($courses->take(6) as $course)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-semibold">{{ $course->title }}</span>
                                        <a href="{{ route('instructor.courses.edit', $course->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </div>
                                    <div class="small text-muted">
                                        <span class="badge {{ $course->type === 'free' ? 'bg-success' : 'bg-primary' }}">{{ ucfirst($course->type) }}</span>
                                        <span class="badge {{ $course->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($course->status ?? 'active') }}</span>
                                        <span class="ms-2"><i class="bi bi-people"></i> {{ $course->enrollments_count }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if($courses->count() > 6)
                            <div class="text-center mt-3">
                                <a href="{{ route('instructor.courses') }}" class="btn btn-sm btn-outline-secondary">View all courses</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
