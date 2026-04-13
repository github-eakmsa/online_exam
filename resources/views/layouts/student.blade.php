<!DOCTYPE html>
<html>
<head>
    <title>Online Exam Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand" href="/student/dashboard">
            Student Exam Panel
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#studentNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="studentNavbar">

            <!-- LEFT: Navigation -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('student/dashboard') ? 'active' : '' }}"
                       href="/student/dashboard">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('student/exams*') ? 'active' : '' }}"
                       href="/student/exams">
                        Take Exam
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('student/results*') ? 'active' : '' }}"
                       href="/student/results">
                        My Results
                    </a>
                </li>

            </ul>

            <!-- RIGHT: Student Info + Logout -->
            <div class="d-flex align-items-center gap-3">

                @if(session('student'))
                    <span class="text-warning small">
                        {{ session('student.name') }} |
                        grade: {{ session('student.class') }}
                    </span>
                @endif

                <form method="POST" action="{{ route('student.logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>

            </div>

        </div>
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@yield('content')

@yield('scripts')

</body>
</html>
