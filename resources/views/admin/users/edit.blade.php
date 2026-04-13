@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create User</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
    <form method="POST" action="/admin/users/update/{{ $user->id }}">
@csrf

<input name="fullname" value="{{ $user->fullname }}" class="form-control mb-2">
<input name="email" value="{{ $user->email }}" class="form-control mb-2">
<input name="username" value="{{ $user->login->username ?? '' }}" class="form-control mb-2">
<input name="phone" value="{{ $user->phone }}" class="form-control mb-2">

<select name="role" class="form-control mb-2">
    <option {{ $user->role=='admin'?'selected':'' }}>admin</option>
    <option {{ $user->role=='teacher'?'selected':'' }}>teacher</option>
    <option {{ $user->role=='student'?'selected':'' }}>student</option>
</select>

<button class="btn btn-success">Update</button>
</form>
</div>
@endsection

