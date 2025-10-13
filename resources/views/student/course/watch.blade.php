@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="container my-5">
    <h2 class="mb-3">{{ $course->title }}</h2>
    
    <div class="ratio ratio-16x9">
        <iframe src="{{ $course->content_url }}" title="{{ $course->title }}" 
                allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
        </iframe>
    </div>
</div>
@endsection
