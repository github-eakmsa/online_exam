@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Exams</h3>

    <a href="/teacher/exams/create" class="btn btn-primary mb-3">Create Exam</a>

    <table id="usersTable" class="table table-bordered">
        <thead>
            <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Class</th>
            <th>Subject</th>
            <th>Total Questions</th>
            <th>Status</th>
            <th>Result Status</th>
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

ajax: '/teacher/exams/data',

columns: [
{ data: 'id' },
{ data: 'title' },
{ data: 'class_level' },
{ data: 'subject_ID' },
{ data: 'total' },
{ data: 'status' },
{ data: 'result_status' },
{ data: 'actions', orderable:false, searchable:false }
]

});

});
</script>
@endsection
