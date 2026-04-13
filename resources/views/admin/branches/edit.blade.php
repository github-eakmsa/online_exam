@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Branch</h3>

<form method="POST" action="/admin/branches/update/{{ $branch->branch_ID }}">
@csrf

<input name="branch_name" value="{{ $branch->branch_name }}" class="form-control mb-2">
<input name="section_name" value="{{ $branch->section_name }}" class="form-control mb-2">

<button class="btn btn-success">Update</button>
</form>

</div>
@endsection

