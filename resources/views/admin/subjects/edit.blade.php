@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Subject</h3>

<form method="POST" action="/admin/subjects/update/{{ $subject->subject_ID }}">
@csrf

<input name="name" value="{{ $subject->subject_name }}" class="form-control mb-2">

<button class="btn btn-success">Update</button>
</form>
</div>
@endsection
