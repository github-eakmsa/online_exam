@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Assign Questions to Exam</h3>

    @if(session('error'))
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif

    <div class="card p-3 mb-3">
        <h5>{{ $exam->title }}</h5>
        <p>Subject: {{ $subject->subject_name }} | Class: {{ $exam->class_level }}</p>
    </div>

    <form method="POST" action="/teacher/exams/{{ $exam->id }}/assign">
        @csrf

        <div class="mb-3">
            <label>Number of Questions</label>
            <input type="number" name="count" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Auto Assign</button>
    </form>
</div>
@endsection
