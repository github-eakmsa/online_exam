@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Students</h3>

    <a href="/admin/students/create" class="btn btn-primary mb-3">Add Student</a>

    <form action="/admin/students/import" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">

        <div class="col-md-4">
            <a href="/admin/students/template" class="btn btn-link" download="">Download Template</a>
        </div>

        <div class="col-md-4">
        <input type="file" name="file" class="form-control">
        </div>

        <div class="col-md-2">
        <button class="btn btn-success">Import Students</button>
        </div>

        </div>

    </form>

    <table id="usersTable" class="table table-bordered">
        <thead>
            <tr>
            <th>Profile ID</th>
            <th>Full Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Branch</th>
            <th>Action</th>
            </tr>
        </thead>
    </table>

</div>
@endsection


@section('scripts')
<script>
$(document).ready(function() {

$('#usersTable').DataTable({

processing: true,
serverSide: true,

ajax: '/admin/students/data',

columns: [
{ data: 'profile_ID' },
{ data: 'fullname' },
{ data: 'col_current_class' },
{ data: 'col_section' },
{ data: 'branch' },
{ data: 'actions', orderable:false, searchable:false }
]

});

});
</script>
@endsection
