@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit User</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
    <form method="POST" action="/admin/users/update/{{ $user->sn }}">
@csrf

<div class="form-group row">
<label class="col-form-label">Full Name</label>
<input name="fullname" value="{{ $user->fullname }}" class="form-control mb-2 col-md-6" placeholder="Enter fullname" required>
</div>

<div class="form-group row">
<label class="col-form-label">Phone</label>
<input name="phone" value="{{ $user->phone }}" class="form-control mb-2 col-md-6" placeholder="Enter phone">
</div>

<div class="form-group row">
<label class="col-form-label">Email</label>
<input name="email" value="{{ $user->admin->email ?? '' }}" class="form-control mb-2 col-md-6" placeholder="Enter email" required>
</div>

<div class="form-group row">
    <label class="col-form-label">Branch</label>
    <input name="branch" value="{{ $user->branch }}" class="form-control mb-2 col-md-6" placeholder="Enter branch" required>
</div>

<div class="form-group row">
<label class="col-form-label">Role</label>
<select name="role" class="form-control mb-2 col-md-6" required>
    <option {{ $user->role=='admin'?'selected':'' }} value="admin">Admin</option>
    <option {{ $user->role=='teacher'?'selected':'' }} value="teacher">Teacher</option>
    <option {{ $user->role=='student'?'selected':'' }} value="student">Student</option>
</select>
</div>

<button class="btn btn-success">Update</button>
</form>
</div>
@endsection

