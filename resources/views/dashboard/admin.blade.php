@extends('layouts.app')

@section('content')
<div class="container">
    
    <h3>Admin Dashboard</h3>

    <div class="row">
        <div class="col-md-3"><div class="card p-3">Students: {{ $students }}</div></div>
        <div class="col-md-3"><div class="card p-3">Teachers: {{ $teachers }}</div></div>
        <div class="col-md-3"><div class="card p-3">Subjects: {{ $subjects }}</div></div>
        <div class="col-md-3"><div class="card p-3">Branches: {{ $branches }}</div></div>
    </div>
</div>
@endsection
