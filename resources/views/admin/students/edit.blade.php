@extends('admin.layout')

@section('content')
    <div class="container mt-4">
        <h2>Edit Student</h2>
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary mb-3">Back to List</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}"
                            required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}"
                            required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password">Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control"
                            value="{{ old('date_of_birth', $student->date_of_birth) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="gender">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female
                            </option>
                            <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nationality">Nationality</label>
                        <input type="text" name="nationality" class="form-control"
                            value="{{ old('nationality', $student->nationality) }}">
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="bio">Bio</label>
                <textarea name="bio" class="form-control" rows="3">{{ old('bio', $student->bio) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $student->address) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $student->city) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="state">State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', $student->state) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="postcode" class="form-control"
                            value="{{ old('postcode', $student->postcode) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="country">Country</label>
                        <input type="text" name="country" class="form-control"
                            value="{{ old('country', $student->country) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="image">Profile Image</label>
                        @if($student->image)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/students/' . $student->image) }}" width="100" class="rounded-circle"
                                    alt="Student Image">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $student->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $student->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    </div>
@endsection