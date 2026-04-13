@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create User</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/admin/users/store">
        @csrf

        <div class="mb-2">
            <label>Full Name</label>
            <input name="fullname" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Email</label>
            <input name="email" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Username</label>
            <input name="username" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Phone</label>
            <input name="phone" class="form-control">
        </div>

        <div class="mb-2">
            <label>Branch</label>
            <input name="branch" class="form-control">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="">Select Role</option>
                <option value="superadmin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
            </select>
        </div>

        <button class="btn btn-success">Create User</button>
    </form>
</div>
@endsection
