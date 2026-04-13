@extends('layouts.app')

@section('content')
<div class="container">
    
    <h3>Teacher Dashboard</h3>

    <div class="row">
        <div class="col-md-4"><div class="card p-3">My Questions: {{ $questions }}</div></div>
        <div class="col-md-4"><div class="card p-3">Exams: {{ $exams }}</div></div>
        <div class="col-md-4"><div class="card p-3">Attempts: {{ $attempts }}</div></div>
    </div>
</div>
@endsection
