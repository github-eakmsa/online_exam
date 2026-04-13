@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Student</h3>

    <form method="POST" action="/admin/students/update/{{ $student->student_ID }}">
        @csrf

        <input name="fullname" value="{{ $student->fullname }}" class="form-control mb-2">
        <input name="col_phone" value="{{ $student->col_phone }}" class="form-control mb-2">
        <input name="col_current_class" value="{{ $student->col_current_class }}" class="form-control mb-2">
        <input name="col_section" value="{{ $student->col_section }}" class="form-control mb-2">

        <input name="branch" value="{{ $student->branch }}" class="form-control mb-2" placeholder="Branch">

        <select name="gender" class="form-control mb-2">
            <option value="">Gender</option>
            <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
        </select>

        <input name="age" type="number" value="{{ $student->age }}" class="form-control mb-2" placeholder="Age">

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
