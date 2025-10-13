@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="container my-5">
        <div class="row">
            <!-- ✅ Sidebar Filters -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Filter Courses</h5>

                        <form method="GET" action="{{ route('courses.index') }}">
                            <!-- ✅ Preserve search term when filtering -->
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <!-- Difficulty Filter -->
                            <div class="mb-3">
                                <label class="form-label">Difficulty</label>
                                <select name="difficulty" class="form-select">
                                    <option value="">All</option>
                                    <option value="beginner" {{ request('difficulty') == 'beginner' ? 'selected' : '' }}>
                                        Beginner</option>
                                    <option value="intermediate" {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ request('difficulty') == 'advanced' ? 'selected' : '' }}>
                                        Advanced</option>
                                </select>
                            </div>

                            <!-- Type Filter -->
                            <div class="mb-3">
                                <label class="form-label">Price Type</label>
                                <select name="type" class="form-select">
                                    <option value="">All</option>
                                    <option value="free" {{ request('type') == 'free' ? 'selected' : '' }}>Free</option>
                                    <option value="paid" {{ request('type') == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>

                            <!-- Duration Filter -->
                            <div class="mb-3">
                                <label class="form-label">Duration</label>
                                <select name="duration" class="form-select">
                                    <option value="">All</option>
                                    <option value="short" {{ request('duration') == 'short' ? 'selected' : '' }}>Short (&lt;=
                                        5 hrs)</option>
                                    <option value="medium" {{ request('duration') == 'medium' ? 'selected' : '' }}>Medium
                                        (6–20 hrs)</option>
                                    <option value="long" {{ request('duration') == 'long' ? 'selected' : '' }}>Long (&gt; 20
                                        hrs)</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </form>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ✅ Courses Section -->
        <div class="col-md-9">
            <div class="text-center mb-4">
                <h1 class="fw-bold">
                    @if(request('search'))
                        Search Results for "{{ request('search') }}"
                    @else
                        Available Courses
                    @endif
                </h1>
                <p class="text-muted">
                    @if(request('search'))
                        Found {{ $courses->count() }} course(s) matching your search.
                    @else
                        Browse through our curated list of high-quality courses and start learning today.
                    @endif
                </p>
            </div>

            <div class="row g-4">
                @forelse($courses as $course)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm course-card">
                            <!-- Course Thumbnail -->
                            @if($course->image)
                                <img src="{{ asset('uploads/courses/' . $course->image) }}" class="card-img-top"
                                    alt="{{ $course->title }}">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $course->title }}</h5>

                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($course->description, 100) }}
                                </p>

                                <div class="mb-2">
                                    <span
                                        class="badge bg-secondary text-capitalize">{{ $course->difficulty ?? 'all levels' }}</span>
                                    <span class="badge bg-info">{{ $course->type }}</span>
                                    @if($course->duration)
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-clock"></i> {{ $course->duration }} hrs
                                        </span>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($course->type === 'paid')
                                            <span class="fw-bold text-dark">৳{{ number_format($course->price, 2) }}</span>
                                            @if($course->old_price)
                                                <span class="text-muted text-decoration-line-through">
                                                    ৳{{ number_format($course->old_price, 2) }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="fw-bold text-success">Free</span>
                                        @endif
                                    </div>

                                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-primary">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        @if(request('search'))
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No courses found for "{{ request('search') }}"</h5>
                            <p class="text-muted">Try searching with different keywords or <a
                                    href="{{ route('courses.index') }}">view all courses</a>.</p>
                        @else
                            <h5 class="text-muted">No courses match your filters.</h5>
                            <p class="text-muted"><a href="{{ route('courses.index') }}">Reset filters</a> to see all courses.</p>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    </div>
@endsection