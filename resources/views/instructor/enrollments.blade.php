@extends('layouts.instructor')

@section('title', 'Course Enrollments')

@section('content')
<div class="container mt-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="mb-1">Course Enrollments</h3>
            <p class="text-muted mb-0">Students currently enrolled across your courses.</p>
        </div>
        <div class="badge bg-light text-dark fw-semibold p-3">
            <i class="bi bi-person-badge me-2"></i>{{ $instructor->name }}
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Enrollments</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total_enrollments'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Unique Students</p>
                    <h3 class="fw-bold mb-0">{{ $stats['unique_students'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Courses with Students</p>
                    <h3 class="fw-bold mb-0">{{ $stats['courses_with_students'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Last 7 Days</p>
                    <h3 class="fw-bold mb-0">{{ $stats['recent_enrollments'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    @if ($courses->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No courses found</h5>
                <p class="text-muted">Create a course to start receiving enrollments.</p>
            </div>
        </div>
    @else
        @php
            $coursesWithStudents = $courses->filter(fn($course) => $course->enrollments->isNotEmpty());
        @endphp

        @if ($coursesWithStudents->isEmpty())
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">No enrollments yet</h5>
                    <p class="text-muted">Students will appear here once they enroll in your courses.</p>
                </div>
            </div>
        @else
            <div class="accordion" id="coursesAccordion">
                @foreach ($courses as $course)
                    <div class="accordion-item mb-3 shadow-sm">
                        <h2 class="accordion-header" id="heading{{ $course->id }}">
                            <button class="accordion-button d-flex flex-wrap justify-content-between gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $course->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $course->id }}">
                                <div>
                                    <h5 class="mb-0">{{ $course->title }}</h5>
                                    <div class="text-muted small">
                                        <span class="me-3"><i class="bi bi-people"></i> {{ $course->enrollments->count() }} students</span>
                                        <span class="me-3"><i class="bi bi-clock-history"></i> {{ optional($course->enrollments->first())->created_at?->diffForHumans() ?? 'No enrollments yet' }}</span>
                                        @if ($course->type)
                                            <span class="badge {{ $course->type === 'free' ? 'bg-success' : 'bg-primary' }}">{{ ucfirst($course->type) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end ms-lg-auto">
                                    <span class="badge bg-light text-dark">Status: {{ ucfirst($course->status ?? 'active') }}</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $course->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $course->id }}" data-bs-parent="#coursesAccordion">
                            <div class="accordion-body">
                                @if ($course->enrollments->isEmpty())
                                    <p class="text-muted mb-0">No students enrolled yet.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle enrollment-table" id="enrollment-table-{{ $course->id }}">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student</th>
                                                    <th>Email</th>
                                                    <th>Enrolled On</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($course->enrollments as $index => $enrollment)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-3">
                                                                @if ($enrollment->student && $enrollment->student->image)
                                                                    <img src="{{ asset('uploads/students/' . $enrollment->student->image) }}" alt="{{ $enrollment->student->name }}" class="rounded-circle student-avatar">
                                                                @else
                                                                    <div class="rounded-circle student-avatar placeholder-avatar">
                                                                        <span>{{ strtoupper(substr($enrollment->student->name ?? 'S', 0, 1)) }}</span>
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <span class="fw-semibold">{{ $enrollment->student->name ?? 'Unknown Student' }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $enrollment->student->email ?? 'N/A' }}</td>
                                                        <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('.enrollment-table').each(function () {
            const tableId = $(this).attr('id');
            $('#' + tableId).DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50],
                order: [[3, 'desc']],
                language: {
                    search: '_INPUT_',
                    searchPlaceholder: 'Search students...'
                }
            });
        });
    });
</script>
@endsection
