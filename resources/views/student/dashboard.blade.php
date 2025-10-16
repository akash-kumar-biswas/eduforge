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
            flex: 1;
            padding: 12px;
            background: transparent;
            border: 2px solid #4facfe;
            color: #4facfe;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .watch-course-btn:hover {
            background: linear-gradient(135deg, #4facfe 0%, #08bac4ff 100%);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
        }

        .complete-course-btn {
            flex: 1;
            padding: 12px;
            background: transparent;
            border: 2px solid #43e97b;
            color: #43e97b;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            text-align: center;
        }

        .complete-course-btn:hover {
            background: linear-gradient(135deg, #43e97b 0%, #38d39f 100%);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 233, 123, 0.4);
        }

        .course-actions {
            display: flex;
            gap: 12px;
            width: 100%;
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
            flex: 1;
            max-width: 60%;
        }

        .purchase-courses-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .purchase-course-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .purchase-course-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .purchase-course-thumb {
            width: 80px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .purchase-course-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .purchase-course-name {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            line-height: 1.3;
        }

        .purchase-course-instructor {
            color: #7f8c8d;
            font-size: 0.85rem;
            margin: 0;
        }

        .purchase-course-instructor strong {
            color: #34495e;
        }

        .purchase-course-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #43e97b;
            margin-top: auto;
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
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }

        .purchase-date {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4facfe;
        }

        .purchase-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .purchase-detail-row:last-child {
            border-bottom: none;
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
            word-break: break-word;
        }

        .purchase-detail-value.purchase-price {
            color: #43e97b;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .purchase-txnid {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: #4facfe;
            word-break: break-all;
        }

        /* Payment Method Badges */
        .payment-method-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .payment-method-badge.payment-bkash {
            background: linear-gradient(135deg, #E2136E 0%, #c91062 100%);
            box-shadow: 0 2px 8px rgba(226, 19, 110, 0.3);
        }

        .payment-method-badge.payment-nagad {
            background: linear-gradient(135deg, #ED1C24 0%, #d41820 100%);
            box-shadow: 0 2px 8px rgba(237, 28, 36, 0.3);
        }

        .payment-method-badge.payment-rocket {
            background: linear-gradient(135deg, #8B3A8B 0%, #762f76 100%);
            box-shadow: 0 2px 8px rgba(139, 58, 139, 0.3);
        }

        .payment-method-badge.payment-upay {
            background: linear-gradient(135deg, #00A8E1 0%, #0092c7 100%);
            box-shadow: 0 2px 8px rgba(0, 168, 225, 0.3);
        }

        .payment-method-badge.payment-manual {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            box-shadow: 0 2px 8px rgba(149, 165, 166, 0.3);
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

        /* Large Tablets (992px and below) */
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

            /* Purchase History - Large Tablet */
            .purchase-card {
                padding: 25px;
                gap: 25px;
            }

            .purchase-left {
                max-width: 55%;
            }

            .purchase-right {
                min-width: 240px;
                padding: 18px;
            }

            .purchase-course-thumb {
                width: 75px;
                height: 55px;
            }

            .purchase-course-name {
                font-size: 0.95rem;
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

            /* Purchase History Responsive - Tablet */
            .purchase-card {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }

            .purchase-left {
                max-width: 100%;
                width: 100%;
            }

            .purchase-courses-list {
                gap: 12px;
            }

            .purchase-course-item {
                padding: 12px;
                gap: 12px;
            }

            .purchase-course-thumb {
                width: 70px;
                height: 55px;
            }

            .purchase-course-name {
                font-size: 0.95rem;
            }

            .purchase-course-instructor {
                font-size: 0.8rem;
            }

            .purchase-course-price {
                font-size: 1rem;
            }

            .purchase-divider {
                display: none;
            }

            .purchase-right {
                width: 100%;
                min-width: auto;
                padding: 15px;
            }

            .purchase-date {
                font-size: 0.95rem;
            }

            .purchase-detail-row {
                padding: 10px 0;
            }

            .close-btn {
                top: 10px;
                right: 10px;
                width: 28px;
                height: 28px;
                font-size: 1.3rem;
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

            /* Course Actions - Mobile */
            .course-actions {
                flex-direction: column;
                gap: 8px;
            }

            .watch-course-btn,
            .complete-course-btn {
                width: 100%;
                padding: 10px;
                font-size: 0.9rem;
            }

            /* Purchase History - Mobile */
            .purchase-card {
                padding: 15px;
                gap: 15px;
                margin-bottom: 15px;
            }

            .purchase-courses-list {
                gap: 10px;
            }

            .purchase-course-item {
                padding: 10px;
                gap: 10px;
                border-radius: 8px;
            }

            .purchase-course-thumb {
                width: 60px;
                height: 45px;
            }

            .purchase-course-details {
                gap: 3px;
            }

            .purchase-course-name {
                font-size: 0.9rem;
                line-height: 1.2;
            }

            .purchase-course-instructor {
                font-size: 0.75rem;
            }

            .purchase-course-price {
                font-size: 0.95rem;
            }

            .purchase-right {
                padding: 12px;
                gap: 10px;
            }

            .purchase-date {
                font-size: 0.9rem;
                margin-bottom: 8px;
                padding-bottom: 8px;
            }

            .purchase-detail-row {
                padding: 8px 0;
                font-size: 0.85rem;
            }

            .purchase-detail-label,
            .purchase-detail-value {
                font-size: 0.85rem;
            }

            .close-btn {
                width: 26px;
                height: 26px;
                font-size: 1.2rem;
                top: 8px;
                right: 8px;
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

            /* Purchase History - Extra Small */
            .purchase-card {
                padding: 12px;
                gap: 12px;
                border-radius: 10px;
            }

            .purchase-courses-list {
                gap: 8px;
            }

            .purchase-course-item {
                padding: 8px;
                gap: 8px;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .purchase-course-thumb {
                width: 100%;
                height: 80px;
                max-width: 120px;
            }

            .purchase-course-details {
                width: 100%;
                align-items: center;
            }

            .purchase-course-name {
                font-size: 0.85rem;
                text-align: center;
            }

            .purchase-course-instructor {
                font-size: 0.7rem;
                text-align: center;
            }

            .purchase-course-price {
                font-size: 0.9rem;
                margin-top: 5px;
            }

            .purchase-right {
                padding: 10px;
                gap: 8px;
            }

            .purchase-date {
                font-size: 0.85rem;
            }

            .purchase-detail-row {
                padding: 6px 0;
                font-size: 0.8rem;
            }

            .purchase-detail-label,
            .purchase-detail-value {
                font-size: 0.8rem;
            }

            .close-btn {
                width: 24px;
                height: 24px;
                font-size: 1.1rem;
            }

            .profile-img,
            .profile-placeholder {
                width: 80px;
                height: 80px;
                font-size: 1.5rem;
            }

            /* Course Actions - Extra Small */
            .watch-course-btn,
            .complete-course-btn {
                padding: 8px;
                font-size: 0.85rem;
                letter-spacing: 0.3px;
            }

            .watch-course-btn i,
            .complete-course-btn i {
                display: none;
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
                            @php
                                $isCompleted = false;
                                // if the pivot has is_completed (from migration) use it
                                if (isset($course->pivot) && isset($course->pivot->is_completed)) {
                                    $isCompleted = (bool) $course->pivot->is_completed;
                                } else {
                                    // fallback: if student.complete_course is present, UI will show count only
                                    $isCompleted = false;
                                }
                            @endphp
                            <div class="course-card" data-course-id="{{ $course->id }}">
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

                                    <div class="course-actions">
                                        <a href="{{ route('student.courses.watch', $course->id) }}" class="watch-course-btn">
                                            <i class="bi bi-play-circle me-1"></i> WATCH
                                        </a>
                                        @if($isCompleted)
                                            <button class="complete-course-btn" disabled>
                                                <i class="bi bi-check-circle me-1"></i> COMPLETED
                                            </button>
                                        @else
                                            <button onclick="completeCourse(this, {{ $course->id }})" class="complete-course-btn">
                                                <i class="bi bi-check-circle me-1"></i> COMPLETE
                                            </button>
                                        @endif
                                    </div>
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

                            <!-- Left Section: All Courses with Individual Prices -->
                            <div class="purchase-left">
                                <div class="purchase-courses-list">
                                    @foreach($purchaseGroup->items as $item)
                                        <div class="purchase-course-item">
                                            <img src="{{ $item->course && $item->course->image ? asset('uploads/courses/' . $item->course->image) : 'https://via.placeholder.com/80x60/667eea/ffffff?text=Course' }}"
                                                alt="{{ $item->course ? $item->course->title : 'Course' }}"
                                                class="purchase-course-thumb">

                                            <div class="purchase-course-details">
                                                <h4 class="purchase-course-name">
                                                    {{ $item->course ? $item->course->title : 'Course Title' }}
                                                </h4>
                                                <p class="purchase-course-instructor">
                                                    By
                                                    <strong>{{ $item->course && $item->course->instructor ? $item->course->instructor->name : 'Instructor' }}</strong>
                                                </p>
                                                <div class="purchase-course-price">৳{{ number_format($item->price, 2) }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="purchase-divider"></div>

                            <!-- Right Section: Purchase Summary -->
                            <div class="purchase-right">
                                <div class="purchase-date">{{ $purchaseGroup->created_at->format('Y-m-d H:i:s') }}</div>

                                <div class="purchase-detail-row">
                                    <span class="purchase-detail-label">Total Courses</span>
                                    <span class="purchase-detail-value">{{ $purchaseGroup->total_courses }}</span>
                                </div>

                                <div class="purchase-detail-row">
                                    <span class="purchase-detail-label">Total Amount</span>
                                    <span
                                        class="purchase-detail-value purchase-price">৳{{ number_format($purchaseGroup->total_price, 2) }}</span>
                                </div>

                                <div class="purchase-detail-row">
                                    <span class="purchase-detail-label">Payment Method</span>
                                    <span class="purchase-detail-value">
                                        @if($purchaseGroup->payment && $purchaseGroup->payment->method)
                                            <span
                                                class="payment-method-badge payment-{{ strtolower($purchaseGroup->payment->method) }}">
                                                {{ strtoupper($purchaseGroup->payment->method) }}
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </span>
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

    <script>
        // Complete Course Functionality (server-backed)
        // Prevent duplicate clicks while request is pending
        const completing = new Set();

        async function completeCourse(button, courseId) {
            if (completing.has(courseId)) return; // already pending
            completing.add(courseId);

            // Optimistically disable the button
            button.disabled = true;
            button.style.opacity = '0.7';

            try {
                const meta = document.querySelector('meta[name="csrf-token"]');
                const token = meta ? meta.getAttribute('content') : null;

                const res = await fetch("{{ url('student/courses') }}/" + courseId + "/complete", {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                if (!res.ok) {
                    // try to extract JSON message or text
                    let err = {};
                    try { err = await res.json(); } catch (e) { /* ignore */ }
                    alert(err.error || err.message || 'Could not mark course complete.');
                    button.disabled = false;
                    button.style.opacity = '';
                    return;
                }

                const data = await res.json().catch(() => ({}));

                // Mark the course card as completed in-place (do not remove)
                const courseCard = button.closest('.course-card');
                if (courseCard) {
                    const completedBtn = document.createElement('button');
                    completedBtn.className = 'complete-course-btn';
                    completedBtn.disabled = true;
                    completedBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> COMPLETED';
                    button.replaceWith(completedBtn);
                }

                // Update completed count from server value
                if (data && data.complete_course !== undefined) {
                    const completedCountElement = document.querySelector('.stat-icon.completed').nextElementSibling.querySelector('h3');
                    if (completedCountElement) {
                        completedCountElement.textContent = data.complete_course;
                        // brief animation
                        completedCountElement.style.transition = 'all 0.3s ease';
                        completedCountElement.style.transform = 'scale(1.2)';
                        completedCountElement.style.color = '#43e97b';
                        setTimeout(() => {
                            completedCountElement.style.transform = 'scale(1)';
                            completedCountElement.style.color = '';
                        }, 300);
                    }
                } else {
                    // fallback to incrementing locally
                    try { updateCompletedCount(); } catch (e) { /* ignore */ }
                }

            } catch (e) {
                console.error('completeCourse error', e);
                let msg = 'An error occurred while marking the course complete.';
                try { if (e && e.message) msg = e.message; } catch (_) { }
                alert(msg);
                button.disabled = false;
                button.style.opacity = '';
            } finally {
                completing.delete(courseId);
            }
        }

        function updateCompletedCount() {
            const completedCountElement = document.querySelector('.stat-icon.completed').nextElementSibling.querySelector('h3');
            const currentCount = parseInt(completedCountElement.textContent);
            completedCountElement.textContent = currentCount + 1;

            // Add animation
            completedCountElement.style.transition = 'all 0.3s ease';
            completedCountElement.style.transform = 'scale(1.2)';
            completedCountElement.style.color = '#43e97b';

            setTimeout(() => {
                completedCountElement.style.transform = 'scale(1)';
                completedCountElement.style.color = '';
            }, 300);
        }

        function checkEmptyState() {
            const coursesGrid = document.querySelector('.courses-grid');
            const visibleCourses = coursesGrid.querySelectorAll('.course-card:not([style*="display: none"])');

            if (visibleCourses.length === 0) {
                coursesGrid.innerHTML = `
                                <div class="empty-state" style="grid-column: 1 / -1;">
                                    <i class="bi bi-trophy-fill" style="font-size: 4rem; color: #43e97b;"></i>
                                    <h3>🎉 Congratulations!</h3>
                                    <p>You've completed all your enrolled courses!</p>
                                </div>
                            `;
            }
        }

        // Hide already completed courses on page load (if provided)
        document.addEventListener('DOMContentLoaded', function () {
            try {
                if (typeof completedCourses !== 'undefined' && Array.isArray(completedCourses)) {
                    completedCourses.forEach(courseId => {
                        const courseCards = document.querySelectorAll('.course-card');
                        courseCards.forEach(card => {
                            const completeButton = card.querySelector('.complete-course-btn');
                            if (completeButton && completeButton.onclick && completeButton.onclick.toString().includes(courseId)) {
                                card.style.display = 'none';
                            }
                        });
                    });
                }
            } catch (e) {
                // ignore
            }

            checkEmptyState();
        });

        // If the page was restored from the browser's back-forward cache (bfcache),
        // reload to ensure we display the authoritative server-rendered state
        window.addEventListener('pageshow', function (event) {
            try {
                if (event.persisted) {
                    window.location.reload();
                }
            } catch (e) {
                // ignore
            }
        });

        // When the tab becomes visible again, reload to get fresh server data
        document.addEventListener('visibilitychange', function () {
            try {
                if (document.visibilityState === 'visible') {
                    // small optimization: only reload if page wasn't just loaded
                    if (!window.__dashboardAutoReloaded) {
                        window.__dashboardAutoReloaded = true;
                        window.location.reload();
                    }
                }
            } catch (e) {
                // ignore
            }
        });
    </script>
@endsection