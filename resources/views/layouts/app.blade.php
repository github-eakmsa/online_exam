<!DOCTYPE html>
<html>
<head>
    <title>Online Exam Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand" href="/dashboard">
            Online Exam Panel
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarMain">

            <!-- LEFT: Navigation Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Admin / SuperAdmin -->
                @if(session('staff.role') === 'superadmin' || session('staff.role') === 'admin')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="/admin/users">Users</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/students*') ? 'active' : '' }}" href="/admin/students">Students</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/student-accounts*') ? 'active' : '' }}" href="/admin/student-accounts">Student Accounts</a>
                    </li>

                    <li class="nav-item"></li>
                        <a class="nav-link {{ request()->is('admin/subjects*') ? 'active' : '' }}" href="/admin/subjects">Subjects</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/branches*') ? 'active' : '' }}" href="/admin/branches">Branches</a>
                    </li>

                @endif


                <!-- Teacher / SuperAdmin -->
                @if(session('staff.role') === 'superadmin' || session('staff.role') === 'teacher')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('teacher/questions*') ? 'active' : '' }}" href="/teacher/questions">My Questions</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('teacher/exams*') ? 'active' : '' }}" href="/teacher/exams">Exams</a>
                    </li>

                @endif

            </ul>

            <!-- RIGHT: User Info + Logout -->
            <div class="d-flex align-items-center gap-3">

                @if(session('staff'))
                    <span class="text-warning small">
                        {{ strtoupper(session('staff.role')) }} |
                        {{ session('staff.name') }}
                    </span>
                @endif

                <form method="POST" action="{{ route('staff.logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>

            </div>

        </div>
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@yield('content')

    <br>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
function initCKEditors() {

    document.querySelectorAll('.ckeditor').forEach((editor) => {

        ClassicEditor
            .create(editor, {
                toolbar: [
                    'bold','italic',
                    '|',
                    'bulletedList','numberedList',
                    '|',
                    'link',
                    'blockQuote',
                    '|',
                    'undo','redo'
                ]
            })
            .catch(error => {
                console.error(error);
            });

    });

}

document.addEventListener("DOMContentLoaded", initCKEditors);
</script>

@yield('scripts')

</body>
</html>
