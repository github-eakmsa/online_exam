@extends('layouts.app')

@section('content')
<div class="container">
    
    <h3>Student Dashboard</h3>

    <div class="row">
        <div class="col-md-4"><div class="card p-3">Available Exams: {{ $exams }}</div></div>
        <div class="col-md-4"><div class="card p-3">My Attempts: {{ $attempts }}</div></div>
        <div class="col-md-4"><div class="card p-3">Average Score: {{ $average }}</div></div>
    </div>
</div>
@endsection
