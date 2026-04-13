@extends('layouts.student')

@section('content')
<div class="container">
    <h3>Available Exams</h3>

    @foreach($exams as $exam)
        <div class="card mb-3 p-3">
            <h5>{{ $exam->title }}</h5>
            <p>Class: {{ $exam->class_level }} | Time: {{ $exam->time }} sec</p>
            <a href="/student/exam/{{ $exam->eid }}/start" class="btn btn-success">Start Exam</a>
        </div>
    @endforeach
</div>
@endsection
