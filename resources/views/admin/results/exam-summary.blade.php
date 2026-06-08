@extends('layouts.app')

@section('content')

<div class="container">

<h3>Exam Attempts Summary</h3>

<table class="table table-bordered" id="usersTable">

<thead>

<tr>
    <th>Exam</th>
    <th>Class</th>
    <th>Questions</th>
    <th>Attempts</th>
    <th>Action</th>
</tr>

</thead>

<tbody>

@foreach($exams as $exam)

<tr>

    <td>{{ $exam->title }}</td>

    <td>{{ $exam->class_level }}</td>

    <td>{{ $exam->total }}</td>

    <td>
        <span class="badge bg-primary">
            {{ $exam->attempts }}
        </span>
    </td>

    <td>

        <a
            href="/admin/results/exam/{{ $exam->eid }}"
            class="btn btn-sm btn-success">

            View Results

        </a>

    </td>

</tr>

@endforeach

</tbody>

</table>

{{ $exams->links() }}

</div>

@endsection


{{-- @section('scripts')
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
@endsection --}}

