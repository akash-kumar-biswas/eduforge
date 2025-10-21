@extends('layouts.app')

@section('title', 'About Us - EduForge Online Education System')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 text-white about-s" style="background: #343a40 !important;">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">About EduForge</h1>
            <p class="lead mb-0">Transforming Lives Through Accessible Online Education</p>
        </div>
    </section>

    <!-- Who We Are Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('frontend/dist/images/Contact/image.jpg') }}"
                        class="img-fluid rounded shadow-lg about-image" alt="EduForge Online Learning"
                        style="width: calc(100% - 10px); height: calc(100% - 10px);">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Who We Are</h2>
                    <p class="text-muted mb-3" style="font-size: 1.1rem; line-height: 1.8;">
                        <strong>EduForge</strong> is a cutting-edge online education platform dedicated to democratizing
                        access to quality learning experiences. We connect students, professionals, and lifelong learners
                        with expert instructors from around the world, offering a diverse range of courses designed to meet
                        the evolving demands of today's job market.
                    </p>
                    <div class="d-flex gap-4 mb-3">
                        <div>
                            <h3 class="text-primary fw-bold mb-0">250K+</h3>
                            <p class="text-muted mb-0">Active Students</p>
                        </div>
                        <div>
                            <h3 class="text-primary fw-bold mb-0">5,000+</h3>
                            <p class="text-muted mb-0">Online Courses</p>
                        </div>
                        <div>
                            <h3 class="text-primary fw-bold mb-0">1,500+</h3>
                            <p class="text-muted mb-0">Expert Instructors</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary text-white rounded-circle p-3 me-3"
                                    style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-bullseye fs-3"></i>
                                </div>
                                <h3 class="fw-bold mb-0">Our Mission</h3>
                            </div>
                            <p class="text-muted" style="font-size: 1.05rem; line-height: 1.8;">
                                To empower individuals worldwide with accessible, affordable, and high-quality online
                                education that enables them to acquire new skills, advance their careers, and achieve their
                                personal and professional goals. We are committed to breaking down barriers to education and
                                fostering a global community of lifelong learners.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary text-white rounded-circle p-3 me-3"
                                    style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-eye fs-3"></i>
                                </div>
                                <h3 class="fw-bold mb-0">Our Vision</h3>
                            </div>
                            <p class="text-muted" style="font-size: 1.05rem; line-height: 1.8;">
                                To become the world's most trusted and innovative online education platform, recognized for
                                transforming lives through education and creating opportunities for millions of learners
                                globally. We envision a future where quality education knows no boundaries and every
                                individual has the tools to unlock their full potential.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Our Core Values</h2>
                <p class="text-muted lead">The principles that guide everything we do</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center hover-lift">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="bi bi-lightbulb-fill text-primary fs-1"></i>
                                </div>
                            </div>
                            <h5 class="fw-semibold mb-3">Innovation</h5>
                            <p class="text-muted">We continuously innovate our platform, courses, and teaching methods to
                                provide cutting-edge learning experiences that meet the demands of a rapidly evolving world.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center hover-lift">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="bi bi-trophy-fill text-primary fs-1"></i>
                                </div>
                            </div>
                            <h5 class="fw-semibold mb-3">Excellence</h5>
                            <p class="text-muted">We are committed to delivering the highest quality courses, content, and
                                support, ensuring that every learner receives exceptional educational value.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center hover-lift">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="bi bi-globe text-primary fs-1"></i>
                                </div>
                            </div>
                            <h5 class="fw-semibold mb-3">Accessibility</h5>
                            <p class="text-muted">We believe education should be accessible to everyone, regardless of
                                location, background, or financial situation. We strive to remove barriers to learning.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center hover-lift">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="bi bi-people-fill text-primary fs-1"></i>
                                </div>
                            </div>
                            <h5 class="fw-semibold mb-3">Community</h5>
                            <p class="text-muted">We foster a supportive learning community where students, instructors, and
                                experts collaborate, share knowledge, and grow together.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Offer Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">What We Offer</h2>
                <p class="text-muted lead">Comprehensive learning solutions for every stage of your journey</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-2">
                                <i class="bi bi-laptop fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-semibold">Expert-Led Courses</h5>
                            <p class="text-muted">Learn from industry professionals and subject matter experts with
                                real-world experience in their fields.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-2">
                                <i class="bi bi-clock-history fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-semibold">Flexible Learning</h5>
                            <p class="text-muted">Study at your own pace, on your own schedule, from anywhere in the world
                                with lifetime access to courses.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-2">
                                <i class="bi bi-award fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-semibold">Certificates</h5>
                            <p class="text-muted">Earn recognized certificates upon course completion to showcase your
                                achievements and enhance your resume.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-2">
                                <i class="bi bi-chat-dots fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-semibold">Interactive Learning</h5>
                            <p class="text-muted">Engage with interactive content, quizzes, assignments, and projects that
                                reinforce your learning.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-2">
                                <i class="bi bi-headset fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-semibold">Dedicated Support</h5>
                            <p class="text-muted">Get help when you need it with our responsive student support team and
                                instructor Q&A forums.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded p-2">
                                <i class="bi bi-graph-up fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-semibold">Career Growth</h5>
                            <p class="text-muted">Gain in-demand skills that help you advance in your current career or
                                transition to a new field.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* ✅ Jumping hover effect for cards */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
        }

        /* ✅ Jumping effect for Mission & Vision cards */
        section.bg-light .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        section.bg-light .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
        }

        /* ✅ Jumping effect for stats numbers */
        .d-flex.gap-4>div {
            transition: transform 0.3s ease;
        }

        .d-flex.gap-4>div:hover {
            transform: translateY(-8px);
        }

        /* ✅ Jumping effect for "What We Offer" items */
        .d-flex.align-items-start {
            transition: transform 0.3s ease;
        }

        .d-flex.align-items-start:hover {
            transform: translateY(-8px);
        }

        /* ✅ Icon rotation effect on hover */
        .bg-primary.text-white.rounded-circle i,
        .bg-primary.bg-opacity-10 i {
            transition: transform 0.3s ease;
        }

        .card:hover .bg-primary.bg-opacity-10 i {
            transform: rotate(10deg) scale(1.1);
        }

        section.bg-light .card:hover .bg-primary.text-white.rounded-circle i {
            transform: rotate(360deg);
        }

        /* ✅ About image hover effect */
        .about-image {
            position: relative;
            left: -20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .about-image:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2) !important;
        }

        @media (max-width: 768px) {
            .about-image {
                left: 0;
            }
        }
    </style>
@endsection