@extends('layouts.instructor')

@section('title', 'Course Enrollments')

@section('content')
<style>
    :root {
        --brand-color: #04317aff;
    }

    /* === Top Stats Cards (Hover Effect Like Dashboard) === */
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

    /* === Buttons === */
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

    /* === Brand Accent Badges === */
    .badge.bg-primary {
        background-color: var(--brand-color) !important;
    }

    .text-brand {
        color: var(--brand-color) !important;
    }

    /* === Student Avatar Placeholder === */
    .student-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }

    .placeholder-avatar {
        background-color: #eff6ff;
        color: var(--brand-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        border: 1px solid #e2e8f0;
    }

    /* === Accordion Styling === */
    .accordion-item {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        overflow: hidden;
    }

    .accordion-button {
        background: #f8fafc;
        font-weight: 600;
        color: #1e293b;
        transition: all 0.2s ease;
    }

    .accordion-button:not(.collapsed) {
        color: var(--brand-color);
        background: #eff6ff;
        border-bottom: 1px solid #e2e8f0;
        box-shadow: inset 0 -1px 0 #e2e8f0;
    }

    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(4, 49, 122, 0.25);
    }

    .accordion-button:hover {
        background: #f1f5f9;
    }

    /* === DataTables Styling === */
    table.dataTable thead th {
        background-color: #f8fafc !important;
        color: #1e293b !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 4px 8px;
        outline: none;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--brand-color);
        box-shadow: 0 0 0 2px rgba(4, 49, 122, 0.15);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: var(--brand-color) !important;
        color: #fff !important;
        border: 1px solid var(--brand-color) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: var(--brand-color) !important;
        color: #fff !important;
    }
</style>

<div class="container mt-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="mb-1">Course Enrollments</h3>
            <p class="text-muted mb-0">Students currently enrolled across your courses.</p>
        </div>
        <div class="badge bg-light text-dark fw-semibold p-3 border" style="border-color: var(--brand-color) !important;">
            <i class="bi bi-person-badge me-2 text-brand"></i>{{ $instructor->name }}
        </div>
    </div>

    <!-- === Top Stats Cards === -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Enrollments</p>
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
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Courses with Students</p>
                    <h3 class="fw-bold mb-0 text-brand">{{ $stats['courses_with_students'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Last 7 Days</p>
                    <h3 class="fw-bold mb-0 text-brand">{{ $stats['recent_enrollments'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- === Main Content === -->
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
                            <button class="accordion-button d-flex flex-wrap justify-content-between gap-2" 
                                    type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse{{ $course->id }}" 
                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                    aria-controls="collapse{{ $course->id }}">
                                <div>
                                    <h5 class="mb-0 text-brand">{{ $course->title }}</h5>
                                    <div class="text-muted small">
                                        <span class="me-3"><i class="bi bi-people"></i> {{ $course->enrollments->count() }} students</span>
                                        <span class="me-3"><i class="bi bi-clock-history"></i> {{ optional($course->enrollments->first())->created_at?->diffForHumans() ?? 'No enrollments yet' }}</span>
                                        @if ($course->type)
                                            <span class="badge {{ $course->type === 'free' ? 'bg-success' : 'bg-primary' }}">{{ ucfirst($course->type) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end ms-lg-auto">
                                    <span class="badge bg-light text-dark border" style="border-color: var(--brand-color) !important;">Status: {{ ucfirst($course->status ?? 'active') }}</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $course->id }}" 
                             class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $course->id }}" 
                             data-bs-parent="#coursesAccordion">
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
                                                    <th>Phone</th>
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
                                                                    <img src="{{ asset('uploads/students/' . $enrollment->student->image) }}" 
                                                                         alt="{{ $enrollment->student->name }}" 
                                                                         class="rounded-circle student-avatar">
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
                                                        <td>{{ $enrollment->student->phone ?? 'N/A' }}</td>
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
