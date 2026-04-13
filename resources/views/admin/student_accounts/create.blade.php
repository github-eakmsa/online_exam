@extends('layouts.app')

@section('content')

<div class="container">

<h3>Create Student Account</h3>

<form method="POST" action="/admin/student-accounts/store">
@csrf

<input type="hidden" name="profileID" value="{{ $student->profile_ID }}">

<div class="mb-3">

<label>Username</label>

<input name="username"
class="form-control"
value="{{ $student->col_phone }}">

</div>

<div class="mb-3">

<label>Password</label>

<input name="password"
class="form-control"
value="123456">

</div>

<button class="btn btn-success">
Create Account
</button>

</form>

</div>

@endsection
