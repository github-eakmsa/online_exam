@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Questions</h3>
    <a href="/teacher/questions/create" class="btn btn-primary mb-3">Add Question</a>

    <table id="usersTable" class="table table-bordered w-100">
        <thead>
            <tr>
            <th>ID</th>
            <th>Grade Level</th>
            <th>Subject</th>
            <th>Question</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
        </thead>
    </table>

</div>
@endsection


@section('scripts')
<script>
    var recordStatusMap = {
        1: 'Active',
        0: 'Inactive',
        '-1': 'Archived'
    };

$(document).ready(function() {

$('#usersTable').DataTable({

processing: true,
serverSide: true,

ajax: '/teacher/questions/data',

columns: [
{ data: 'qid' },
{ data: 'grade_level' },
{ data: 'subject' },
{ data: 'qns' },
{ data: 'status', render: function(data) {
    return recordStatusMap[data] || data;
} },
{ data: 'actions', orderable:false, searchable:false }
]

});

});
</script>
@endsection
