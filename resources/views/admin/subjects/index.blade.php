@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Subjects</h3>

    <form method="POST" action="/admin/subjects/store" class="mb-3">
        @csrf
        <input name="name" class="form-control mb-2" placeholder="Subject Name">
        <button class="btn btn-primary">Add</button>
    </form>

    <table id="usersTable" class="table table-bordered">
        <thead>
            <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
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

ajax: '/admin/subjects/data',

columns: [
{ data: 'subject_ID' },
{ data: 'subject_name' },
{ data: 'status' },
{ data: 'actions', orderable:false, searchable:false }
]

});

});
</script>
@endsection
