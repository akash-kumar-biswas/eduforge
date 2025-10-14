@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }

        /* Header Section */
        .dashboard-header {
            background: white;
            padding: 30px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .student-profile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .student-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #4facfe;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }

        .student-info h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .student-info p {
            color: #7f8c8d;
            font-size: 1rem;
            margin: 0;
        }

        .stats-badges {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .stat-badge {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.enrolled {
            background: rgba(79, 172, 254, 0.1);
            color: #4facfe;
        }

        .stat-icon.completed {
            background: rgba(67, 233, 123, 0.1);
            color: #43e97b;
        }

        .stat-info h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .stat-info p {
            font-size: 0.9rem;
            color: #95a5a6;
            margin: 0;
        }

        /* Navigation Tabs */
        .dashboard-nav {
            background: white;
            border-radius: 10px;
            padding: 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .nav-tabs {
            border: none;
            padding: 0 20px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #7f8c8d;
            font-weight: 600;
            padding: 20px 25px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-tabs .nav-link:hover {
            color: #4facfe;
            background: transparent;
        }

        .nav-tabs .nav-link.active {
            color: #4facfe;
            background: transparent;
            border-bottom: 3px solid #4facfe;
        }

        /* Course Cards */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .course-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .course-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-bottom: 1px solid #ecf0f1;
        }

        .course-content {
            padding: 25px;
        }

        .course-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-instructor {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .course-instructor:hover {
            border-color: #4facfe;
            box-shadow: 0 4px 12px rgba(79, 172, 254, 0.1);
        }

        .instructor-avatar-wrapper {
            width: 80px;
            height: 80px;
            min-width: 80px;
            min-height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #4facfe;
            box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f0f0;
        }

        .instructor-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .instructor-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
            min-width: 0;
        }

        .instructor-name {
            font-size: 1.1rem;
            color: #2c3e50;
            font-weight: 700;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .instructor-email {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .watch-course-btn {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 2px solid #4facfe;
            color: #4facfe;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
        }

        .watch-course-btn:hover {
            background: linear-gradient(135deg, #4facfe 0%, #08bac4ff 100%);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .empty-state i {
            font-size: 5rem;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #7f8c8d;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #95a5a6;
            font-size: 1rem;
        }

        /* Purchase History Styles */
        .purchase-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        .purchase-card:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
        }

        .purchase-left {
            display: flex;
            gap: 20px;
            flex: 1;
            align-items: flex-start;
        }

        .purchase-course-image {
            width: 150px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .purchase-course-info {
            flex: 1;
        }

        .purchase-course-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .purchase-instructor {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .purchase-instructor strong {
            color: #34495e;
        }

        .purchase-price-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            min-width: 140px;
        }

        .purchase-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .purchase-divider {
            width: 2px;
            background: #ecf0f1;
            align-self: stretch;
        }

        .purchase-right {
            display: flex;
            flex-direction: column;
            gap: 15px;
            min-width: 280px;
        }

        .purchase-date {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .purchase-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .purchase-detail-row:last-child {
            border-bottom: none;
        }

        .purchase-detail-row:nth-child(odd) {
            background: #f8f9fa;
            padding: 8px 0;
            border-radius: 4px;
        }

        .purchase-detail-label {
            font-size: 0.9rem;
            color: #7f8c8d;
            font-weight: 500;
        }

        .purchase-detail-value {
            font-size: 0.9rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .purchase-txnid {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: #4facfe;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 30px;
            height: 30px;
            border: none;
            background: transparent;
            color: #95a5a6;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            padding: 0;
        }

        .close-btn:hover {
            color: #e74c3c;
            transform: rotate(90deg);
        }

        /* ========================================
               📱 RESPONSIVE STYLES
               ======================================== */

        /* Tablets and Below (992px) */
        @media (max-width: 992px) {
            .dashboard-header {
                padding: 20px 0;
            }

            .student-avatar {
                width: 70px;
                height: 70px;
            }

            .student-info h2 {
                font-size: 1.5rem;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .stat-info h3 {
                font-size: 1.6rem;
            }

            .courses-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;
            }

            .course-image {
                height: 180px;
            }

            .course-content {
                padding: 20px;
            }
        }

        /* Mobile (768px) */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 15px 0;
                margin-bottom: 20px;
            }

            .courses-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-badges {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
                width: 100%;
            }

            .stat-badge {
                width: 100%;
                justify-content: space-between;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 10px;
            }

            .student-profile {
                flex-direction: column;
                text-align: center;
            }

            .student-info {
                width: 100%;
            }

            .nav-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
                padding: 0 15px;
                -webkit-overflow-scrolling: touch;
            }

            .nav-tabs .nav-link {
                white-space: nowrap;
                padding: 15px 20px;
                font-size: 0.95rem;
            }

            .dashboard-nav {
                margin-bottom: 20px;
            }

            /* Course Cards Mobile */
            .course-card {
                border-radius: 10px;
            }

            .course-image {
                height: 160px;
            }

            .course-content {
                padding: 15px;
            }

            .course-title {
                font-size: 1.1rem;
                margin-bottom: 10px;
            }

            .course-instructor {
                padding: 15px;
                margin-bottom: 15px;
            }

            .instructor-avatar-wrapper {
                width: 60px;
                height: 60px;
                min-width: 60px;
            }

            /* Purchase History Responsive */
            .purchase-card {
                flex-direction: column;
                gap: 20px;
            }

            .purchase-left {
                flex-direction: column;
            }

            .purchase-course-image {
                width: 100%;
                height: 180px;
            }

            .purchase-price-section {
                align-items: flex-start;
            }

            .purchase-divider {
                display: none;
            }

            .purchase-right {
                width: 100%;
            }

            .close-btn {
                top: 10px;
                right: 10px;
            }

            /* Profile Tab */
            .profile-img,
            .profile-placeholder {
                width: 120px;
                height: 120px;
                font-size: 2.5rem;
            }

            .card-body {
                padding: 1rem;
            }

            .info-item {
                margin-bottom: 1rem;
            }
        }

        /* Small Mobile (576px) */
        @media (max-width: 576px) {
            .dashboard-header {
                padding: 15px 0;
            }

            .student-avatar {
                width: 60px;
                height: 60px;
            }

            .student-info h2 {
                font-size: 1.25rem;
            }

            .student-info p {
                font-size: 0.9rem;
            }

            .stat-badge {
                padding: 12px;
            }

            .stat-icon {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }

            .stat-info h3 {
                font-size: 1.4rem;
            }

            .stat-info p {
                font-size: 0.85rem;
            }

            .nav-tabs {
                padding: 0 10px;
            }

            .nav-tabs .nav-link {
                padding: 12px 15px;
                font-size: 0.9rem;
            }

            .courses-grid {
                gap: 15px;
            }

            .course-image {
                height: 140px;
            }

            .course-content {
                padding: 12px;
            }

            .course-title {
                font-size: 1rem;
            }

            .course-instructor {
                padding: 12px;
                margin-bottom: 12px;
            }

            .instructor-avatar-wrapper {
                width: 50px;
                height: 50px;
                min-width: 50px;
            }

            /* Purchase Cards Mobile */
            .purchase-course-image {
                height: 150px;
            }

            /* Profile Tab */
            .profile-img,
            .profile-placeholder {
                width: 100px;
                height: 100px;
                font-size: 2rem;
            }

            .card-header h5 {
                font-size: 1rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .info-item label {
                font-size: 0.85rem;
            }

            .info-item p {
                font-size: 0.9rem;
            }

            /* Button adjustments */
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }

        /* Extra Small (400px) */
        @media (max-width: 400px) {
            .student-info h2 {
                font-size: 1.1rem;
            }

            .stat-info h3 {
                font-size: 1.2rem;
            }

            .course-image {
                height: 120px;
            }

            .profile-img,
            .profile-placeholder {
                width: 80px;
                height: 80px;
                font-size: 1.5rem;
            }
        }

        /* Profile Tab Styles */
        .profile-image-wrapper {
            position: relative;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #4facfe;
        }

        .profile-placeholder {
            width: 150px;
            height: 150px;
            font-size: 3rem;
            border: 4px solid #4facfe;
        }

        .info-item label {
            font-weight: 600;
            color: #6c757d;
        }

        .card-header {
            padding: 1rem 1.25rem;
        }
    </style>

    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="student-profile">
                        <img src="{{ $student->image ? asset('uploads/students/' . $student->image) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&size=90&background=4facfe&color=fff' }}"
                            alt="{{ $student->name }}" class="student-avatar">
                        <div class="student-info">
                            <h2>{{ $student->name }}</h2>
                            <p> {{ $student->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stats-badges justify-content-lg-end mt-4 mt-lg-0">
                        <div class="stat-badge">
                            <div class="stat-icon enrolled">
                                <i class="bi bi-book"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $enrolledCount }}</h3>
                                <p>Enrolled Courses</p>
                            </div>
                        </div>
                        <div class="stat-badge">
                            <div class="stat-icon completed">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $completedCount }}</h3>
                                <p>Completed Courses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="container">
        <div class="dashboard-nav">
            <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-courses-tab" data-bs-toggle="tab" data-bs-target="#all-courses"
                        type="button" role="tab">All Courses</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="purchase-history-tab" data-bs-toggle="tab"
                        data-bs-target="#purchase-history" type="button" role="tab">Purchase History</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab">Profile</button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="dashboardTabsContent">
            <!-- All Courses Tab -->
            <div class="tab-pane fade show active" id="all-courses" role="tabpanel">
                @if($allCourses->count() > 0)
                    <div class="courses-grid">
                        @foreach($allCourses as $course)
                            <div class="course-card">
                                <img src="{{ $course->image ? asset('uploads/courses/' . $course->image) : 'https://via.placeholder.com/400x220/4facfe/ffffff?text=Course+Image' }}"
                                    alt="{{ $course->title }}" class="course-image">
                                <div class="course-content">
                                    <h3 class="course-title">{{ $course->title }}</h3>

                                    <div class="course-instructor">
                                        <div class="instructor-avatar-wrapper">
                                            <img src="{{ $course->instructor->image ? asset('uploads/instructors/' . $course->instructor->image) : 'https://ui-avatars.com/api/?name=' . urlencode($course->instructor->name) . '&size=80&background=4facfe&color=fff' }}"
                                                alt="{{ $course->instructor->name }}" class="instructor-avatar">
                                        </div>
                                        <div class="instructor-info">
                                            <div class="instructor-name">{{ $course->instructor->name }}</div>
                                            <div class="instructor-email">{{ $course->instructor->email }}</div>
                                        </div>
                                    </div>

                                    <a href="{{ route('student.courses.watch', $course->id) }}" class="watch-course-btn">
                                        WATCH COURSE
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h3>No Courses Enrolled</h3>
                        <p>You haven't enrolled in any courses yet. Start learning today!</p>
                    </div>
                @endif
            </div>

            <div class="tab-pane fade" id="purchase-history" role="tabpanel">
                @if(isset($purchaseHistory) && $purchaseHistory->count() > 0)
                    @foreach($purchaseHistory as $purchaseGroup)
                        <div class="purchase-card">
                            <button class="close-btn" onclick="this.parentElement.remove()">×</button>

                            <!-- Left Section: Course Info -->
                            <div class="purchase-left">
                                @php
                                    $firstItem = $purchaseGroup->items->first();
                                @endphp
                                <img src="{{ $firstItem && $firstItem->course && $firstItem->course->image ? asset('uploads/courses/' . $firstItem->course->image) : 'https://via.placeholder.com/150x100/667eea/ffffff?text=Course' }}"
                                    alt="{{ $firstItem && $firstItem->course ? $firstItem->course->title : 'Course' }}"
                                    class="purchase-course-image">

                                <div class="purchase-course-info">
                                    <h3 class="purchase-course-title">
                                        {{ $firstItem && $firstItem->course ? $firstItem->course->title : 'Course Title' }}
                                    </h3>
                                    <p class="purchase-instructor">
                                        By
                                        <strong>{{ $firstItem && $firstItem->course && $firstItem->course->instructor ? $firstItem->course->instructor->name : 'Instructor' }}</strong>
                                    </p>
                                </div>
                            </div>

                            <!-- Price Section -->
                            <div class="purchase-price-section">
                                <div class="purchase-price">৳{{ number_format($purchaseGroup->total_price, 2) }}</div>
                            </div>

                            <!-- Divider -->
                            <div class="purchase-divider"></div>

                            <!-- Right Section: Purchase Details -->
                            <div class="purchase-right">
                                <div class="purchase-date">{{ $purchaseGroup->created_at->format('Y-m-d H:i:s') }}</div>

                                <div class="purchase-detail-row">
                                    <span class="purchase-detail-label">Total</span>
                                    <span class="purchase-detail-value">{{ number_format($purchaseGroup->total_price) }}</span>
                                </div>

                                <div class="purchase-detail-row">
                                    <span class="purchase-detail-label">Total Courses</span>
                                    <span class="purchase-detail-value">{{ $purchaseGroup->total_courses }}</span>
                                </div>

                                <div class="purchase-detail-row">
                                    <span class="purchase-detail-label">Payment Type</span>
                                    <span class="purchase-detail-value purchase-txnid">{{ $purchaseGroup->txnid ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-receipt"></i>
                        <h3>No Purchase History</h3>
                        <p>You haven't made any purchases yet.</p>
                    </div>
                @endif
            </div>

            <!-- Profile Tab -->
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <!-- Profile Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center mb-3 mb-md-0">
                                        <div class="profile-image-wrapper">
                                            @if($student->image)
                                                <img src="{{ asset('uploads/students/' . $student->image) }}" alt="Profile"
                                                    class="img-fluid rounded-circle profile-img">
                                            @else
                                                <div
                                                    class="profile-placeholder rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
                                                    <span
                                                        class="fs-1 fw-bold">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h2 class="fw-bold mb-2">{{ $student->name }}</h2>
                                        <p class="text-muted mb-2"><i
                                                class="bi bi-envelope-fill me-2"></i>{{ $student->email }}</p>
                                        @if($student->city || $student->country)
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-geo-alt-fill me-2"></i>
                                                @if($student->city){{ $student->city }}@endif
                                                @if($student->city && $student->country), @endif
                                                @if($student->country){{ $student->country }}@endif
                                            </p>
                                        @endif
                                        <p class="text-muted mb-0"><i class="bi bi-calendar-fill me-2"></i>Member Since:
                                            {{ $student->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                        <a href="{{ route('student.profile.edit') }}" class="btn btn-primary btn-lg">
                                            <i class="bi bi-pencil-square me-2"></i>Edit Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Personal Information -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-person-fill me-2"></i>Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Full Name</label>
                                    <p class="fw-semibold mb-0">{{ $student->name }}</p>
                                </div>
                                <hr>
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Email Address</label>
                                    <p class="fw-semibold mb-0">{{ $student->email }}</p>
                                </div>
                                <hr>
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Phone Number</label>
                                    <p class="fw-semibold mb-0">{{ $student->phone ?? 'Not set' }}</p>
                                </div>
                                <hr>
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Date of Birth</label>
                                    <p class="fw-semibold mb-0">
                                        {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'Not set' }}
                                    </p>
                                </div>
                                <hr>
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Gender</label>
                                    <p class="fw-semibold mb-0">
                                        {{ $student->gender ? ucfirst($student->gender) : 'Not set' }}
                                    </p>
                                </div>
                                <hr>
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Nationality</label>
                                    <p class="fw-semibold mb-0">{{ $student->nationality ?? 'Not set' }}</p>
                                </div>
                                @if($student->bio)
                                    <hr>
                                    <div class="info-item">
                                        <label class="text-muted small mb-1">Bio</label>
                                        <p class="mb-0">{{ $student->bio }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Address Information -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-geo-fill me-2"></i>Contact & Address</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-item mb-3">
                                    <label class="text-muted small mb-1">Address</label>
                                    <p class="fw-semibold mb-0">{{ $student->address ?? 'Not set' }}</p>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="text-muted small mb-1">City</label>
                                            <p class="fw-semibold mb-0">{{ $student->city ?? 'Not set' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="text-muted small mb-1">State</label>
                                            <p class="fw-semibold mb-0">{{ $student->state ?? 'Not set' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="text-muted small mb-1">Postcode</label>
                                            <p class="fw-semibold mb-0">{{ $student->postcode ?? 'Not set' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="text-muted small mb-1">Country</label>
                                            <p class="fw-semibold mb-0">{{ $student->country ?? 'Not set' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="info-item">
                                    <label class="text-muted small mb-1">Account Status</label>
                                    <p class="mb-0">
                                        @if($student->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection