@extends('layouts.app')

@section('content')

<div class="container">

<h3>Student Accounts</h3>

<table id="usersTable" class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Profile ID</th>
<th>Full Name</th>
<th>Grade</th>
<th>Section</th>
<th>Username</th>
<th>Temp.pass</th>
<th>Status</th>
<th>Actions</th>
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

ajax: '/admin/student-accounts/data',

columns: [
{ data: 'id' },
{ data: 'profileID' },
{ data: 'student.fullname' },
{ data: 'student.col_current_class' },
{ data: 'student.col_section' },
{ data: 'username' },
{ data: 'temp' },
{ data: 'status', render: function(data, type, row) {
return Number(data) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Disabled</span>';
} },
{ data: 'actions', orderable:false, searchable:false }
]

});

});
</script>
@endsection
