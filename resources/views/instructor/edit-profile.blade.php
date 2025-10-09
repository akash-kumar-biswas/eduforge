@extends('layouts.instructor')

@section('title', 'Edit Profile')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Profile</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('instructor.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-4 text-center">
                                <label class="form-label fw-bold">Profile Picture</label>
                                <div class="mb-3">
                                    @if($instructor->image)
                                        <img src="{{ asset('uploads/instructors/' . $instructor->image) }}" 
                                             alt="Current Profile" 
                                             id="preview-image"
                                             class="img-fluid rounded-circle border border-3 border-primary" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                             id="preview-placeholder"
                                             style="width: 150px; height: 150px;">
                                            <i class="bi bi-person-fill text-white" style="font-size: 4rem;"></i>
                                        </div>
                                        <img src="" alt="Preview" id="preview-image" class="img-fluid rounded-circle border border-3 border-primary d-none" style="width: 150px; height: 150px; object-fit: cover;">
                                    @endif
                                </div>
                                <input type="file" class="form-control w-50 mx-auto" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted">Accepted formats: JPG, PNG, JPEG, GIF (Max: 2MB)</small>
                                @error('image')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" 
                                       value="{{ old('name', $instructor->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email', $instructor->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bio" class="form-label fw-bold">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="4" 
                                      placeholder="Tell us about yourself...">{{ old('bio', $instructor->bio) }}</textarea>
                            <small class="text-muted">Maximum 1000 characters</small>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="mb-3 text-muted">Change Password (Optional)</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" 
                                       placeholder="Leave blank to keep current password">
                                <small class="text-muted">Minimum 6 characters</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Confirm your new password">
                            </div>
                        </div>
                        
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Update Profile
                            </button>
                            <a href="{{ route('instructor.profile') }}" class="btn btn-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-image');
                const placeholder = document.getElementById('preview-placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
