@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Student</h3>

    <form method="POST" action="/admin/students/store">
        @csrf

        <input name="profile_ID" class="form-control mb-2" placeholder="Profile ID (must match login)">
        <input name="fullname" class="form-control mb-2" placeholder="Full Name">
        <input name="phone" class="form-control mb-2" placeholder="Phone">
        <input name="class" class="form-control mb-2" placeholder="Class">
        <input name="section" class="form-control mb-2" placeholder="Section">
        <input name="branch" class="form-control mb-2" placeholder="Branch">

        <select name="gender" class="form-control mb-2">
            <option value="">Gender</option>
            <option>Male</option>
            <option>Female</option>
        </select>

        <input name="age" type="number" class="form-control mb-2" placeholder="Age">

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
