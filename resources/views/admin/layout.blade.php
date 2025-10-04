<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="{{ asset('css/admin.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        /* Simple Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e0e0e0;
            padding: 0;
            overflow-y: auto;
            z-index: 1000;
        }

        /* Simple Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f5f5f5;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #d0d0d0;
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #b0b0b0;
        }

        /* Logo Section - Simple */
        .sidebar-header {
            background: #04317aff;
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid #032558;
        }

        .sidebar-header h4 {
            color: white;
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0.3rem 0 0 0;
            font-size: 0.75rem;
        }

        /* Navigation Menu - Clean */
        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .nav-item {
            margin-bottom: 0.2rem;
            padding: 0 1rem;
        }

        .sidebar .nav-link {
            color: #4a5568;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 0.75rem;
            width: 25px;
            text-align: center;
            color: #6b7280;
        }

        .sidebar .nav-link:hover {
            background: #f3f4f6;
            color: #04317aff;
        }

        .sidebar .nav-link:hover i {
            color: #04317aff;
        }

        .sidebar .nav-link.active {
            background: #04317aff;
            color: white;
        }

        .sidebar .nav-link.active i {
            color: white;
        }

        /* Menu Section Divider - Simple Line */
        .menu-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 1rem 1.5rem;
        }

        .menu-label {
            color: #9ca3af;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.5rem 1.5rem;
            margin-top: 0.5rem;
        }

        /* Logout Button - Simple */
        .logout-section {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
        }

        .logout-section .nav-link {
            color: #ef4444;
            background: #fef2f2;
            justify-content: center;
            font-weight: 600;
            border-radius: 6px;
        }

        .logout-section .nav-link:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .logout-section .nav-link i {
            color: #ef4444;
        }

        .logout-section .nav-link:hover i {
            color: #dc2626;
        }

        /* Main content shifts right */
        .content-wrapper {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            background: #f5f5f5;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Logo/Header Section -->
        <div class="sidebar-header">
            <h4><i class="bi bi-mortarboard-fill"></i> EDUFORGE</h4>
            <p>Admin Dashboard</p>
        </div>

        <!-- Navigation Menu -->
        <ul class="nav flex-column sidebar-nav">
            <!-- Main Menu Label -->
            <div class="menu-label">Main Menu</div>

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ url('/admin/dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Menu Divider -->
            <div class="menu-divider"></div>

            <!-- Management Section Label -->
            <div class="menu-label">Management</div>

            <!-- Instructors -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/instructors*') ? 'active' : '' }}"
                    href="{{ route('admin.instructors.index') }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Instructors</span>
                </a>
            </li>

            <!-- Students -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/students*') ? 'active' : '' }}"
                    href="{{ route('admin.students.index') }}">
                    <i class="bi bi-people"></i>
                    <span>Students</span>
                </a>
            </li>

            <!-- Courses -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/courses*') ? 'active' : '' }}"
                    href="{{ route('admin.courses.index') }}">
                    <i class="bi bi-book"></i>
                    <span>Courses</span>
                </a>
            </li>

            <!-- Enrollments -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/enrollments*') ? 'active' : '' }}"
                    href="{{ route('admin.enrollments.index') }}">
                    <i class="bi bi-journal-check"></i>
                    <span>Enrollments</span>
                </a>
            </li>

            <!-- Extra bottom padding for logout button -->
            <div style="height: 80px;"></div>
        </ul>

        <!-- Logout Section -->
        <div class="logout-section">
            <a class="nav-link d-flex align-items-center" href="{{ route('admin.logout') }}">
                <i class="bi bi-box-arrow-right me-2"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    <script>
        $(document).ready(function () {
            $('#instructors-table').DataTable({
                "ordering": true
            });
        });
    </script>
</body>

</html>