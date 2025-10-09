@extends('layouts.instructor')

@section('title', 'Instructors List')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">
        All Instructors
    </h3>

    <div class="card shadow-sm">
        <div class="card-body p-0" style="padding: 2rem !important">
            <table id="instructors-table" class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Bio</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructors as $instructor)
                        <tr>
                            <td>{{ $instructor->id }}</td>
                            <td>
                                @if($instructor->image)
                                    <img src="{{ asset('uploads/instructors/' . $instructor->image) }}" 
                                         class="rounded-circle" width="40" height="40" alt="{{ $instructor->name }}">
                                @else
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width:40px; height:40px; font-weight:bold;">
                                        {{ strtoupper(substr($instructor->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td>{{ $instructor->name }}</td>
                            <td>{{ $instructor->email }}</td>
                            <td>
                                <span class="bio-text" title="{{ $instructor->bio }}">
                                    {{ Str::limit($instructor->bio, 50) }}
                                </span>
                            </td>
                            <td>
                                @if($instructor->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#instructors-table').DataTable({
            "paging": true,       // optional: add pagination
            "lengthChange": true,
            "searching": true,    // adds search box
            "ordering": true,     // enables column sorting
            "info": true,
            "autoWidth": false,
            "order": [[0, "asc"]], // default sort by first column
            "language": {
                search: "_INPUT_",
                searchPlaceholder: "Search instructors..."
            }
        });
    });
</script>
@endsection
