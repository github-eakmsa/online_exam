@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Users</h3>

    <a href="/admin/users/create" class="btn btn-primary mb-3">Add User</a>

    <table id="usersTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Branch</th>
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

ajax: '/admin/users/data',

columns: [
{ data: 'sn' },
{ data: 'fullname' },
{ data: 'phone' },
{ data: 'role' },
{ data: 'branch' },
{ data: 'actions', orderable:false, searchable:false }
]

});

});
</script>
@endsection
