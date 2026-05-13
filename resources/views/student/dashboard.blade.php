@extends('layouts.student')

@section('content')
<div class="container">

    <h3 class="mb-4">Welcome, {{ $student['name'] }}</h3>

    <div class="row">
        <p>
            Class: <strong>{{ $student['class'] }}</strong> |
            Section: <strong>{{ $student['section'] }}</strong>
        </p>
        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>Available Exams</h5>
                <a href="/student/exams" class="btn btn-primary btn-sm mt-2">
                    View Exams
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>My Attempts</h5>
                <a href="/student/results" class="btn btn-success btn-sm mt-2">
                    View Results
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>Average Score</h5>
                <h3>-</h3>
            </div>
        </div>

    </div>

    <hr class="my-4">

    {{-- Exam Instructions --}}
    <h4>Exam Instructions</h4>
    <ul>
        <li>Read each question carefully before answering.</li>
        <li>Manage your time wisely. Each exam has a time limit.</li>
        <li>Do not refresh the page during an exam, or you may lose progress.</li>
        <li>Once you submit, you cannot change your answers.</li>
        <li>Good luck!</li>
    </ul>

</div>
@endsection
