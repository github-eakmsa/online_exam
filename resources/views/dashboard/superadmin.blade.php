@extends('layouts.app')

@section('content')
<div class="container">
    
    <h3>Super Admin Dashboard</h3>

    <div class="row">
        <div class="col-md-3"><div class="card p-3">Users: {{ $users }}</div></div>
        <div class="col-md-3"><div class="card p-3">Students: {{ $students }}</div></div>
        <div class="col-md-3"><div class="card p-3">Exams: {{ $exams }}</div></div>
        <div class="col-md-3"><div class="card p-3">Questions: {{ $questions }}</div></div>
    </div>
</div>
@endsection
