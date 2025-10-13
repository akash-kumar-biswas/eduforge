@extends('admin.layout')

@section('content')
    <style>
        /* Clean, Professional Dashboard Design */
        .dashboard-header {
            background: #fff;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            border-left: 4px solid #135dd5ff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .dashboard-title {
            color: #1e293b;
            font-weight: 600;
            font-size: 1.75rem;
            margin: 0;
        }

        .dashboard-subtitle {
            color: #64748b;
            margin: 0.25rem 0 0 0;
            font-size: 0.9rem;
        }

        .stats-card {
            background: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            height: 100%;
        }

        .stats-card:hover {
            border-color: #04317aff;
            box-shadow: 0 4px 12px rgba(4, 49, 122, 0.15);
            transform: translateY(-2px);
        }

        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0.5rem 0;
        }

        .stats-label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stats-meta {
            font-size: 0.813rem;
            color: #94a3b8;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #f1f5f9;
        }

        .card-clean {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .card-header-clean {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
        }

        .card-header-title {
            color: #1e293b;
            font-weight: 600;
            font-size: 1rem;
            margin: 0;
        }

        .btn-export {
            background: #04317aff;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-export:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.25);
        }

        .enrollment-item {
            padding: 1rem 1.5rem;
            transition: background 0.15s ease;
        }

        .enrollment-item:hover {
            background: #f8fafc;
        }

        .course-item {
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .course-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .badge-clean {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .text-blue { color: #04317aff; }
        .text-green { color: #10b981; }
        .text-orange { color: #f59e0b; }
        .text-purple { color: #8b5cf6; }
        
        .bg-blue-light { background: #eff6ff; color: #04317aff; }
        .bg-green-light { background: #f0fdf4; color: #10b981; }
        .bg-orange-light { background: #fffbeb; color: #f59e0b; }
        .bg-purple-light { background: #f5f3ff; color: #8b5cf6; }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .rank-badge {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.813rem;
        }

        .rank-1 { background: #fef3c7; color: #d97706; }
        .rank-2 { background: #e5e7eb; color: #6b7280; }
        .rank-3 { background: #fce7f3; color: #db2777; }
        .rank-other { background: #f1f5f9; color: #64748b; }

        .progress-clean {
            height: 6px;
            background-color: #f1f5f9;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar-blue { background: #04317aff; }
        .progress-bar-green { background: #10b981; }
        .progress-bar-orange { background: #f59e0b; }
        .progress-bar-purple { background: #8b5cf6; }
        .progress-bar-pink { background: #ec4899; }
    </style>

    <div class="container-fluid">
        <!-- Header Section -->
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Dashboard</h1>
                <p class="dashboard-subtitle">Welcome back, {{ $admin_name }} • {{ date('l, F d, Y') }}</p>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row g-3 mb-4">
            <!-- Total Students Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-label text-blue">Total Students</div>
                    <div class="stats-value">{{ $totalStudents }}</div>
                    <div class="stats-meta">
                        <span class="text-green">{{ $activeStudents }} Active</span>
                        <span class="text-muted ms-3">{{ $totalStudents - $activeStudents }} Inactive</span>
                    </div>
                </div>
            </div>

            <!-- Total Instructors Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-label text-purple">Total Instructors</div>
                    <div class="stats-value">{{ $totalInstructors }}</div>
                    <div class="stats-meta">
                        <span class="text-green">{{ $activeInstructors }} Active</span>
                        <span class="text-muted ms-3">{{ $totalInstructors - $activeInstructors }} Inactive</span>
                    </div>
                </div>
            </div>

            <!-- Total Courses Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-label text-orange">Total Courses</div>
                    <div class="stats-value">{{ $totalCourses }}</div>
                    <div class="stats-meta">
                        <span class="text-green">{{ $activeCourses }} Active</span>
                        <span class="text-muted ms-3">{{ $pendingCourses }} Pending</span>
                    </div>
                </div>
            </div>

            <!-- Total Enrollments Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-label text-green">Total Enrollments</div>
                    <div class="stats-value">{{ $totalEnrollments }}</div>
                    <div class="stats-meta">
                        <span class="text-muted">All Time</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Cards Row -->
        <div class="row g-3 mb-4">
            <!-- Total Revenue Card -->
            <div class="col-xl-6">
                <div class="stats-card">
                    <div class="stats-label">Total Revenue</div>
                    <div class="stats-value text-blue">৳{{ number_format($totalRevenue, 2) }}</div>
                    <div class="row mt-3 pt-3" style="border-top: 1px solid #f1f5f9;">
                        <div class="col-6">
                            <small class="text-muted d-block">Total Payments</small>
                            <strong class="text-dark">{{ App\Models\Payment::count() }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Avg. Transaction</small>
                            <strong class="text-dark">
                                ৳{{ App\Models\Payment::count() > 0 ? number_format($totalRevenue / App\Models\Payment::count(), 2) : '0.00' }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This Month Revenue Card -->
            <div class="col-xl-6">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stats-label">This Month Revenue</div>
                            <div class="stats-value text-green">৳{{ number_format($thisMonthRevenue, 2) }}</div>
                        </div>
                        <span class="badge bg-blue-light badge-clean">{{ date('F Y') }}</span>
                    </div>
                    <div class="row mt-3 pt-3" style="border-top: 1px solid #f1f5f9;">
                        <div class="col-6">
                            <small class="text-muted d-block">This Month Payments</small>
                            <strong class="text-dark">
                                {{ App\Models\Payment::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() }}
                            </strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Growth</small>
                            <strong class="{{ $growthDirection == 'up' ? 'text-green' : 'text-danger' }}">
                                {{ $growthDirection == 'up' ? '↑' : '↓' }}{{ number_format(abs($growthPercentage), 1) }}%
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrollment Trends Chart -->
        <div class="row g-3 mb-4">
            <div class="col-xl-12">
                <div class="card-clean">
                    <div class="card-header-clean">
                        <h5 class="card-header-title">Enrollment Trends</h5>
                        <small class="text-muted">Last 6 months (monthly) + {{ date('F Y') }} (daily)</small>
                    </div>
                    <div class="p-3">
                        <canvas id="enrollmentChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Enrollments and Popular Courses -->
        <div class="row g-3">
            <!-- Recent Enrollments -->
            <div class="col-xl-6">
                <div class="card-clean h-100">
                    <div class="card-header-clean d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-header-title">Recent Enrollments</h5>
                            <small class="text-muted">Latest student enrollments</small>
                        </div>
                        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>
                    <div class="p-0">
                        @forelse($recentEnrollments as $enrollment)
                            <div class="enrollment-item border-bottom">
                                <div class="d-flex align-items-start">
                                    <!-- Student Avatar -->
                                    <div class="flex-shrink-0">
                                        @if($enrollment->student && $enrollment->student->image)
                                            <img src="{{ asset('uploads/students/' . $enrollment->student->image) }}"
                                                alt="{{ $enrollment->student->name }}" class="avatar-circle">
                                        @else
                                            <div class="avatar-circle bg-blue-light d-flex align-items-center justify-content-center">
                                                <span class="text-blue fw-bold" style="font-size: 0.875rem;">
                                                    {{ $enrollment->student ? strtoupper(substr($enrollment->student->name, 0, 2)) : '?' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Enrollment Details -->
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1 fw-semibold">{{ $enrollment->student->name ?? 'N/A' }}</h6>
                                                <p class="mb-1 text-muted small">
                                                    {{ $enrollment->course->title ?? 'N/A' }}
                                                </p>
                                            </div>
                                            <span class="badge bg-light text-dark border" style="font-size: 0.75rem;">
                                                {{ $enrollment->created_at->format('M d') }}
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                {{ $enrollment->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <p class="text-muted mb-0">No enrollments found</p>
                            </div>
                        @endforelse
                        @if($recentEnrollments->count() > 0)
                            <div class="p-3 bg-light border-top text-center">
                                <a href="{{ route('admin.enrollments.index') }}" class="text-decoration-none fw-semibold text-primary" style="font-size: 0.875rem;">
                                    View All Enrollments →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Popular Courses -->
            <div class="col-xl-6">
                <div class="card-clean h-100">
                    <div class="card-header-clean d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-header-title">Popular Courses</h5>
                            <small class="text-muted">Top courses by enrollment</small>
                        </div>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>
                    <div class="p-3">
                        @forelse($popularCourses as $index => $course)
                            <div class="course-item">
                                <div class="d-flex align-items-start">
                                    <!-- Rank Badge -->
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rank-badge {{ $index === 0 ? 'rank-1' : ($index === 1 ? 'rank-2' : ($index === 2 ? 'rank-3' : 'rank-other')) }}">
                                            @if($index === 0)
                                                #1
                                            @else
                                                #{{ $index + 1 }}
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Course Info -->
                                    <div class="flex-grow-1">
                                        <h6 class="mb-2 fw-semibold">{{ $course->title }}</h6>
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge bg-blue-light badge-clean">
                                                {{ $course->students_count }} {{ Str::plural('student', $course->students_count) }}
                                            </span>
                                            @if($course->type == 'free')
                                                <span class="badge bg-green-light badge-clean">Free</span>
                                            @else
                                                <span class="badge bg-orange-light badge-clean">৳{{ number_format($course->price, 2) }}</span>
                                            @endif
                                        </div>

                                        <!-- Progress Bar -->
                                        @php
                                            $maxEnrollments = $popularCourses->max('students_count');
                                            $percentage = $maxEnrollments > 0 ? ($course->students_count / $maxEnrollments) * 100 : 0;
                                            $barColors = ['progress-bar-blue', 'progress-bar-purple', 'progress-bar-green', 'progress-bar-orange', 'progress-bar-pink'];
                                            $barColor = $barColors[$index % count($barColors)];
                                        @endphp
                                        <div class="progress-clean">
                                            <div class="progress-bar {{ $barColor }}" role="progressbar"
                                                style="width: {{ $percentage }}%"
                                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <p class="text-muted mb-0">No courses found</p>
                            </div>
                        @endforelse
                    </div>
                    @if($popularCourses->count() > 0)
                        <div class="p-3 bg-light border-top text-center">
                            <a href="{{ route('admin.courses.index') }}" class="text-decoration-none fw-semibold text-primary" style="font-size: 0.875rem;">
                                View All Courses →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('enrollmentChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [{
                    label: 'Enrollments',
                    data: {!! json_encode($monthCounts) !!},
                    borderColor: '#04317aff',
                    backgroundColor: 'rgba(4, 49, 122, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#04317aff',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#04317aff',
                        borderWidth: 1,
                        callbacks: {
                            label: function (context) {
                                return 'Enrollments: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection