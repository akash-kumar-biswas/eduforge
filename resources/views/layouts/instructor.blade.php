<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Instructor Dashboard')</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/instructor.css') }}" rel="stylesheet">

    <style>
        /* Fixed Sidebar */
        .instructor-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            /* background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); */
            padding: 1rem;
            overflow-y: auto;
            z-index: 1000;
        }

        .instructor-sidebar .nav-link.active {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            color: white;
            border-radius: 8px;
        }

        /* Main content shifted right to accommodate sidebar */
        .instructor-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            background: #f8f9fa;
        }

        /* Ensure logout stays at bottom */
        .instructor-sidebar .mt-auto {
            margin-top: auto !important;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="instructor-sidebar d-flex flex-column text-white">
            <div class="sidebar-header mb-4 text-center">
                <h4 class="fw-bold"><i class="bi bi-person-badge"></i> EDUFORGE</h4>
                <p class="small">Instructor Panel</p>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('instructor.dashboard') }}"
                        class="nav-link {{ Request::is('instructor/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('instructor.courses') }}"
                        class="nav-link {{ Request::is('instructor/courses*') ? 'active' : '' }}">
                        <i class="bi bi-book me-2"></i> My Courses
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('instructor.enrollments') }}"
                        class="nav-link {{ Request::is('instructor/enrollments*') ? 'active' : '' }}">
                        <i class="bi bi-journal-check me-2"></i> Enrollments
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('instructor.instructors') }}"
                        class="nav-link {{ Request::is('instructor/instructors*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i> Instructors
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('instructor.profile') }}"
                        class="nav-link {{ Request::is('instructor/profile*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle me-2"></i> Profile
                    </a>
                </li>
            </ul>

            <div class="mt-auto pt-3 border-top border-light">
                <a href="{{ route('instructor.logout') }}" class="nav-link text-danger fw-bold">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="instructor-content flex-grow-1">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>