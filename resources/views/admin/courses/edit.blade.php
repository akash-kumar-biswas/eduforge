@extends('admin.layout')

@section('content')
    <div class="container mt-4">
        <h2>Edit Course</h2>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary mb-3">Back to List</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="title">Course Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $course->title) }}"
                            required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="instructor_id">Instructor</label>
                        <select name="instructor_id" class="form-control" required>
                            <option value="">Select Instructor</option>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea name="description" class="form-control"
                    rows="4">{{ old('description', $course->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="type">Course Type</label>
                        <select name="type" id="courseType" class="form-control" required>
                            <option value="paid" {{ old('type', $course->type) == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="free" {{ old('type', $course->type) == 'free' ? 'selected' : '' }}>Free</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3" id="priceField">
                        <label for="price">Price ($)</label>
                        <input type="number" name="price" class="form-control" step="0.01" min="0"
                            value="{{ old('price', $course->price) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="duration">Duration (hours)</label>
                        <input type="number" name="duration" class="form-control" min="1"
                            value="{{ old('duration', $course->duration) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="difficulty">Difficulty Level</label>
                        <select name="difficulty" class="form-control">
                            <option value="">Select Difficulty</option>
                            <option value="beginner" {{ old('difficulty', $course->difficulty) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('difficulty', $course->difficulty) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('difficulty', $course->difficulty) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="0" {{ old('status', $course->status) == '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ old('status', $course->status) == '1' ? 'selected' : '' }}>Inactive</option>
                            <option value="2" {{ old('status', $course->status) == '2' ? 'selected' : '' }}>Active</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="image">Course Image</label>
                @if($course->image)
                    <div class="mb-2">
                        <img src="{{ asset('uploads/courses/' . $course->image) }}" width="100" class="rounded"
                            alt="Course Image">
                    </div>
                @endif
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update Course</button>
        </form>
    </div>

    <script>
        // Toggle price field based on course type
        document.getElementById('courseType').addEventListener('change', function () {
            const priceField = document.getElementById('priceField');
            if (this.value === 'free') {
                priceField.style.display = 'none';
                document.querySelector('input[name="price"]').value = '0.00';
            } else {
                priceField.style.display = 'block';
            }
        });

        // Initialize on page load
        if (document.getElementById('courseType').value === 'free') {
            document.getElementById('priceField').style.display = 'none';
        }
    </script>
@endsection