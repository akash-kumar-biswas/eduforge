@extends('admin.layout')
@section('title', 'Enrollment List')

@section('content')
    <style>
        /* Clean, Professional Design matching Dashboard and Other Pages */
        .page-header {
            background: #fff;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            border-left: 4px solid #8b5cf6;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .page-title {
            color: #1e293b;
            font-weight: 600;
            font-size: 1.75rem;
            margin: 0;
        }

        .page-subtitle {
            color: #64748b;
            margin: 0.25rem 0 0 0;
            font-size: 0.9rem;
        }

        .btn-add {
            background: #8b5cf6;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-add:hover {
            background: #7c3aed;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(139, 92, 246, 0.25);
        }

        .table-card {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .table-card-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
        }

        .table-card-title {
            color: #1e293b;
            font-weight: 600;
            font-size: 1rem;
            margin: 0;
        }

        .student-avatar {
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            object-fit: cover;
            border: 2px solid #e2e8f0 !important;
        }

        .course-thumbnail {
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            object-fit: cover;
            border: 2px solid #e2e8f0 !important;
        }

        div.avatar-placeholder {
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            background-color: #6b7280 !important;
            background: #6b7280 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            border: none !important;
        }

        .badge-student {
            background: #fef3c7;
            color: #f59e0b;
            padding: 0.4rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .student-name {
            font-weight: 600;
            color: #1e293b;
        }

        .badge-course {
            background: #eff6ff;
            color: #04317aff;
            padding: 0.4rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .course-title {
            font-weight: 600;
            color: #1e293b;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }

        .badge-instructor {
            background: #faf5ff;
            color: #8b5cf6;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .instructor-name {
            font-weight: 600;
            color: #1e293b;
        }

        .badge-date {
            background: #f0fdf4;
            color: #10b981;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .email-text {
            color: #64748b;
            font-size: 0.875rem;
        }

        span.badge-status-active {
            background-color: #10b981 !important;
            background: #10b981 !important;
            color: #ffffff !important;
            padding: 0.25rem 0.75rem !important;
            border-radius: 4px !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }

        span.badge-status-inactive {
            background-color: #ef4444 !important;
            background: #ef4444 !important;
            color: #ffffff !important;
            padding: 0.25rem 0.75rem !important;
            border-radius: 4px !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }

        span.badge-status-completed {
            background-color: #10b981 !important;
            background: #10b981 !important;
            color: #ffffff !important;
            padding: 0.25rem 0.75rem !important;
            border-radius: 4px !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }

        span.badge-status-ongoing {
            background-color: #04317aff !important;
            background: #04317aff !important;
            color: #ffffff !important;
            padding: 0.25rem 0.75rem !important;
            border-radius: 4px !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }

        span.badge-status-pending {
            background-color: #f59e0b !important;
            background: #f59e0b !important;
            color: #ffffff !important;
            padding: 0.25rem 0.75rem !important;
            border-radius: 4px !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }

        a.btn-action-edit {
            background-color: #eff6ff !important;
            background: #eff6ff !important;
            color: #04317aff !important;
            border: none !important;
            padding: 0.375rem 0.75rem !important;
            border-radius: 6px !important;
            font-size: 0.875rem !important;
            transition: all 0.2s ease;
            text-decoration: none !important;
            display: inline-block !important;
        }

        a.btn-action-edit:hover {
            background-color: #dbeafe !important;
            background: #dbeafe !important;
            color: #2563eb !important;
        }

        a.btn-action-edit i {
            color: #04317aff !important;
            font-size: 1.1rem !important;
        }

        a.btn-action-edit:hover i {
            color: #2563eb !important;
        }

        button.btn-action-delete {
            background-color: #fef2f2 !important;
            background: #fef2f2 !important;
            color: #ef4444 !important;
            border: none !important;
            padding: 0.375rem 0.75rem !important;
            border-radius: 6px !important;
            font-size: 0.875rem !important;
            transition: all 0.2s ease;
            cursor: pointer !important;
        }

        button.btn-action-delete:hover {
            background-color: #fee2e2 !important;
            background: #fee2e2 !important;
            color: #dc2626 !important;
        }

        button.btn-action-delete i {
            color: #ef4444 !important;
            font-size: 1.1rem !important;
        }

        button.btn-action-delete:hover i {
            color: #dc2626 !important;
        }

        .alert-success-clean {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #166534;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger-clean {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* DataTable Customization */
        #enrollments-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        #enrollments-table thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-align: center;
            padding: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        #enrollments-table tbody td {
            vertical-align: middle;
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }

        #enrollments-table tbody tr {
            transition: all 0.2s ease;
        }

        #enrollments-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #8b5cf6 !important;
            color: white !important;
            border: none !important;
            border-radius: 6px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #7c3aed !important;
            color: white !important;
            border: none !important;
            border-radius: 6px;
        }
    </style>

    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Enrollment Management</h1>
                <p class="page-subtitle">Manage and monitor all enrollments</p>
            </div>
            <div>
                <a href="{{ route('admin.enrollments.create') }}" class="btn-add">
                    <i class="bi bi-plus-circle-fill me-2"></i>Add New Enrollment
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success-clean">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert-danger-clean">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Enrollments Table Card -->
    <div class="table-card">
        <div class="table-card-header">
            <h5 class="table-card-title">All Enrollments</h5>
        </div>
        <div class="p-3">
            <div class="table-responsive">
                <table id="enrollments-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Student</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th style="width: 80px;">Image</th>
                            <th>Instructor</th>
                            <th style="width: 130px;">Enrolled Date</th>
                            <th style="width: 120px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                            <tr>
                                <td><strong>{{ $enrollment->id }}</strong></td>
                                <td>
                                    <strong>{{ $enrollment->student ? $enrollment->student->name : 'N/A' }}</strong>
                                </td>
                                <td>
                                    <span class="email-text">
                                        {{ $enrollment->student ? $enrollment->student->email : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="course-title"
                                        title="{{ $enrollment->course ? $enrollment->course->title : 'N/A' }}">
                                        {{ $enrollment->course ? $enrollment->course->title : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($enrollment->course && $enrollment->course->image)
                                        <img src="{{ asset('uploads/courses/' . $enrollment->course->image) }}"
                                            alt="{{ $enrollment->course->title }}" class="course-thumbnail">
                                    @else
                                        <div class="avatar-placeholder">
                                            <i class="bi bi-book"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $enrollment->course && $enrollment->course->instructor ? $enrollment->course->instructor->name : 'N/A' }}</strong>
                                </td>
                                <td>
                                    <span class="badge-date">
                                        {{ $enrollment->created_at->format('M d, Y') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="btn-action-edit"
                                            title="Edit">
                                            <i class="bi bi-pencil" style="color: #04317aff; font-size: 1.1rem;"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this enrollment?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-delete" title="Delete">
                                                <i class="bi bi-trash" style="color: #ef4444; font-size: 1.1rem;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#enrollments-table').DataTable({
                "ordering": true
            });
        });
    </script>
@endsection