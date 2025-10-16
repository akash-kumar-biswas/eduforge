<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My Website')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ✅ Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/courses.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --bs-primary: #0d62b7ff;
            --bs-primary-rgb: 13, 98, 183;
            --bs-link-color: var(--bs-primary);
            --bs-link-hover-color: #0b56a0;
        }

        /* ✅ Dropdown hover fix */
        .dropdown-item.active,
        .dropdown-item:active,
        .dropdown-item:focus,
        .dropdown-item:hover {
            background-color: var(--bs-primary) !important;
            color: #fff !important;
        }

        /* ✅ Buttons */
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .btn-primary:hover,
        .btn-outline-light:hover {
            background-color: #343a40;
        }

        .btn-outline-light:hover {
            color: #fff !important;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background: #343a40 !important;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            text-decoration: underline;
        }

        .navbar-brand img {
            height: 1.8rem;
            position: relative;
            top: -3px;
            left: 4px;
        }

        .search-bar {
            max-width: 250px;
        }

        @media (max-width: 991px) {
            .search-bar {
                margin-bottom: 1rem;
                margin-right: 0 !important;
            }
        }

        /* ✅ Footer Styles */
        footer {
            background: linear-gradient(180deg, #1a1d20 0%, #111315 100%);
            color: #ccc;
                margin-bottom: 0 !important;
                padding-bottom: 0 !important;
        }

        .footer-bottom {
    margin-bottom: 0 !important;
    padding-bottom: 2px !important; /* was likely 20px or more */
}



        footer h5 {
            color: #fff;
            margin-bottom: 15px;
            font-weight: 600;
            text-transform: uppercase;
        }

        footer a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--bs-primary);
        }

        footer ul li {
            margin-bottom: 8px;
        }

        /* ✅ Social Media Buttons (static color, lift on hover) */
        .social-icon {
            width: 45px;
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.25rem;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .social-icon.facebook {
            background: #1877F2;
        }

        .social-icon.twitter {
            background: #1DA1F2;
        }

        .social-icon.instagram {
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }

        .social-icon.linkedin {
            background: #0A66C2;
        }

        .social-icon:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }

        .footer-bottom {
            border-top: 1px solid #444;
            margin-top: 30px;
            padding-top: 15px;
            text-align: center;
            font-size: 1.1rem; /* ⬆ Increased font size */
            font-weight: 600; /* ⬆ Bold for visibility */
            color: #f1f1f1;
        }

        .contact-s,
        .about-s,
        .browse-c {
            background-color: #434548ff !important;
        }
        
    </style>
</head>

<body>

    <!-- ✅ Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('frontend/dist/images/eduforge-white.png') }}" alt="EduForge">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/courses') }}">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
                </ul>

                <!-- ✅ Search Bar -->
                <form class="d-flex me-3 search-bar" role="search" id="searchForm">
                    <input class="form-control s" type="text" id="searchInput" placeholder="Search Courses..."
                        aria-label="Search" value="{{ request('search') }}">
                </form>

                <!-- ✅ Conditional Auth Buttons -->
                <div class="d-flex align-items-center">
                    @auth('student')
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="userMenu"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                👤 {{ Auth::guard('student')->user()->name ?? Auth::guard('student')->user()->email }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="{{ route('student.dashboard') }}">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('student.logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('student.login') }}" class="btn btn-outline-light me-2">Sign In</a>
                    @endauth

                    <a href="{{ url('/cart') }}" class="btn btn-outline-light ms-2">🛒 Cart</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ✅ Flash Messages -->
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- ✅ Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- ✅ Footer -->
    <footer class="mt-5 text-light">
        <div class="container py-5">
            <div class="row gy-4">
                <!-- Quick Links -->
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/courses') }}">Courses</a></li>
                        <li><a href="{{ url('/about') }}">About</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>

                <!-- Why Choose Us -->
                <div class="col-md-3">
                    <h5>Why Choose Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i>Expert Instructors</li>
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i>Lifetime Access</li>
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i>Certificates</li>
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i>24/7 Support</li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-md-3">
                    <h5>Contact Info</h5>
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i>123 Main Street, Dhaka-1000</p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i>+880 1234 567 890</p>
                    <p class="mb-2"><i class="bi bi-envelope-fill text-primary me-2"></i>contact@eduforge.com</p>
                </div>

                <!-- Social Links -->
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="social-icon facebook" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon twitter" title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-icon instagram" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon linkedin" title="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                    <p class="mt-3 mb-0 small text-secondary">
                        Connect with us on social media for updates and learning tips.
                    </p>
                </div>
            </div>

<div class="footer-bottom mt-4 pt-3 text-center border-top border-secondary" style="font-size: 0.84rem;">
    &copy; {{ date('Y') }} <span class="text-primary fw-bold" style="font-size: 0.84rem;">EduForge</span>. All rights reserved.
</div>


        </div>
    </footer>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ Real-time Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');

            if (searchForm) searchForm.addEventListener('submit', e => e.preventDefault());

            if (searchInput) {
                let timeout;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timeout);
                    const search = this.value.trim();
                    timeout = setTimeout(() => {
                        if (search.length > 0)
                            window.location.href = '{{ route("courses.index") }}?search=' + encodeURIComponent(search);
                    }, 300);
                });
            }
        });
    </script>
</body>

</html>
