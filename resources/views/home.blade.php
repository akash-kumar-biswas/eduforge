@extends('layouts.app')
@section('title', 'Home')

@section('content')

    <!-- 🌟 Hero Banner -->
    <section class="main-banner text-light d-flex align-items-center"
        style="background-image: url('{{ asset('frontend/dist/images/banner/banner.jpg') }}');">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <h1 class="fw-bold display-5 mb-3">Unlock Knowledge Anywhere, Anytime with Experts.</h1>
                    <p class="lead mb-4">Our commitment is to guide you to the finest online courses, offering expert
                        insights whenever and wherever you are.</p>
                    <form action="{{ route('courses.index') }}" method="GET"
                        class="d-flex flex-column flex-md-row align-items-stretch banner-search">
                        <input type="text" name="search" class="form-control me-md-2 mb-3 mb-md-0 rounded-pill"
                            placeholder="What do you want to learn today..." value="{{ request('search') }}">
                        <button type="submit"
                            class="btn btn-primary text-white rounded-pill px-4 fw-semibold">Search</button>
                    </form>
                </div>
                <!-- <div class="col-lg-5 text-center">
                                <img src="{{ asset('frontend/dist/images/banner/banner.jpg') }}" alt="Learning Image"
                                    class="img-fluid hero-image rounded">
                            </div> -->
            </div>
        </div>
    </section>

    <!-- 💡 Why You'll Learn With EduForge -->
    <section class="py-5 bg-light text-center">
        <div class="container">
            <h2 class="fw-bold mb-5">Why You'll Learn with EduForge</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="cardFeature shadow-sm p-4 h-100">
                        <div class="feature-icon bg-success text-white mb-3">
                            <i class="bi bi-journal-text fs-3"></i>
                        </div>
                        <h5 class="fw-semibold">250k+ Online Courses</h5>
                        <p class="text-muted">Learn at your own pace with thousands of expert-created online courses
                            designed for real growth.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="cardFeature shadow-sm p-4 h-100">
                        <div class="feature-icon bg-primary text-white mb-3">
                            <i class="bi bi-person-badge fs-3"></i>
                        </div>
                        <h5 class="fw-semibold">Expert Instructors</h5>
                        <p class="text-muted">Our instructors are industry leaders who bring hands-on experience and modern
                            learning methods.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mx-auto">
                    <div class="cardFeature shadow-sm p-4 h-100">
                        <div class="feature-icon bg-danger text-white mb-3">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                        <h5 class="fw-semibold">Lifetime Access</h5>
                        <p class="text-muted">Access your purchased courses anytime, forever — review lessons whenever you
                            need to refresh your skills.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- 📞 Contact Section -->
    <section class="py-5 bg-primary text-white text-center contact-s" style="background-color: red;">
        <div class="container">
            <h2 class="fw-bold mb-3">Have Questions? Get In Touch!</h2>
            <p class="lead mb-4">We're here to help you on your learning journey. Contact us anytime!</p>
            <a href="{{ url('/contact') }}" class="btn btn-light btn-lg px-5">Contact Us</a>
        </div>
    </section>

    <style>
        .learning-section {
            color: whitesmoke;
        }

        .learning-section p {
            color: whitesmoke !important;
        }
    </style>

@endsection