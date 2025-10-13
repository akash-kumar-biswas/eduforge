@extends('layouts.app')

@section('title', 'Watch Course')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <span class="text-muted small">Enrolled Course</span>
    </div>

    <h1 class="h3 fw-semibold mb-4">{{ $course->title }}</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($videoType === 'video' && $videoUrl)
                <div class="ratio ratio-16x9">
                    <video controls preload="metadata" class="w-100 h-100">
                        <source src="{{ $videoUrl }}" type="{{ $videoMime ?? 'video/mp4' }}">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @elseif ($videoType === 'iframe' && $videoUrl)
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $videoUrl }}" title="{{ $course->title }}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen loading="lazy"></iframe>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-play-circle" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-0">Video content is not available for this course yet.</p>
                </div>
            @endif
        </div>
    </div>

    @if ($course->description)
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h2 class="h5 fw-semibold mb-3">Course Overview</h2>
                <p class="mb-0 text-muted">{{ $course->description }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
