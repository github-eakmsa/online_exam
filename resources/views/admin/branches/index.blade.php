@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Branches</h3>

    <form method="POST" action="/admin/branches/store" class="mb-3">
        @csrf
        <input name="branch_name" class="form-control mb-2" placeholder="Branch Name">
        <input name="section_name" class="form-control mb-2" placeholder="Section">
        <button class="btn btn-primary">Add</button>
    </form>

    <table class="table table-bordered">
        <tr>
            <th>Branch</th>
            <th>Section</th>
            <th>Action</th>
        </tr>

        @foreach($branches as $b)
        <tr>
            <td>{{ $b->branch_name }}</td>
            <td>{{ $b->section_name }}</td>
            <td>
                <a href="/admin/branches/delete/{{ $b->branch_ID }}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                <a href="/admin/branches/edit/{{ $b->branch_ID }}" class="btn btn-warning btn-sm">Edit</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection

