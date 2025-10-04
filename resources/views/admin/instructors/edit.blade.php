@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2>Edit Instructor</h2>
    <a href="{{ route('admin.instructors.index') }}" class="btn btn-secondary mb-3">Back to List</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.instructors.update', $instructor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $instructor->name) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $instructor->email) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="bio">Bio</label>
            <textarea name="bio" class="form-control">{{ old('bio', $instructor->bio) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="image">Profile Image</label>
            @if($instructor->image)
                <div class="mb-2">
                    <img src="{{ asset('uploads/instructors/'.$instructor->image) }}" width="100" class="rounded-circle" alt="Instructor Image">
                </div>
            @endif
            <input type="file" name="image" class="form-control-file">
        </div>

        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $instructor->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $instructor->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Instructor</button>
    </form>
</div>
@endsection
