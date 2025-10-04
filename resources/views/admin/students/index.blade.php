@extends('admin.layout')
@section('title', 'Student List')

@section('content')
    <style>
        /* Clean, Professional Design matching Dashboard and Instructors */
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

        .badge-gender {
            background: #eff6ff;
            color: #04317aff;
            padding: 0.4rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-gender i {
            color: #04317aff !important;
            font-size: 1rem !important;
        }

        .badge-country {
            background: #faf5ff;
            color: #8b5cf6;
            padding: 0.4rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-country i {
            color: #8b5cf6 !important;
            font-size: 1rem !important;
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
            color: #02234f !important;
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

        /* DataTable Customization */
        #students-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        #students-table thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-align: center;
            padding: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        #students-table tbody td {
            vertical-align: middle;
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }

        #students-table tbody tr {
            transition: all 0.2s ease;
        }

        #students-table tbody tr:hover {
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
                <h1 class="page-title">Student Management</h1>
                <p class="page-subtitle">Manage and monitor all students</p>
            </div>
            <div>
                <a href="{{ route('admin.students.create') }}" class="btn-add">
                    <i class="bi bi-person-plus-fill me-2"></i>Add New Student
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

    <!-- Students Table Card -->
    <div class="table-card">
        <div class="table-card-header">
            <h5 class="table-card-title">All Students</h5>
        </div>
        <div class="p-3">
            <div class="table-responsive">
            <table id="students-table" class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th style="width: 80px;">Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Country</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td><strong>{{ $student->id }}</strong></td>
                            <td>
                                @if($student->image)
                                    <img src="{{ asset('uploads/students/' . $student->image) }}"
                                        alt="{{ $student->name }}" class="student-avatar">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $student->name }}</strong></td>
                            <td class="text-muted">{{ $student->email }}</td>
                            <td>
                                <span class="badge-gender">
                                    @if($student->gender == 'male')
                                        <i class="bi bi-gender-male" style="color: #04317aff !important;"></i>
                                    @elseif($student->gender == 'female')
                                        <i class="bi bi-gender-female" style="color: #04317aff !important;"></i>
                                    @else
                                        <i class="bi bi-person" style="color: #04317aff !important;"></i>
                                    @endif
                                    {{ ucfirst($student->gender ?? 'N/A') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-country">
                                    <i class="bi bi-geo-alt-fill" style="color: #8b5cf6 !important;"></i>
                                    {{ $student->country ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @if($student->status)
                                    <span class="badge-status-active">Active</span>
                                @else
                                    <span class="badge-status-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn-action-edit"
                                        title="Edit">
                                        <i class="bi bi-pencil" style="color: #04317aff; font-size: 1.1rem;"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this student?');"
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
            $('#students-table').DataTable({
                "ordering": true
            });
        });
    </script>
@endsection