<!DOCTYPE html>
<html>
<head>
    <title>Online Exam Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container" style="max-width: 400px; margin-top: 80px;">
    <div class="card p-4 shadow">

        <h4 class="text-center mb-3">Student Login</h4>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('student.login') }}">
            @csrf

            <div class="mb-3">
                <label>Username</label>
                <input name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Login</button>
        </form>

    </div>
</div>

</body>
</html>