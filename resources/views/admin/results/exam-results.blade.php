@extends('layouts.app')

@section('content')

<div class="container">

<h3>

{{ $exam->title }}

</h3>

<div class="mb-3">

<a
href="/admin/results/exams"
class="btn btn-secondary">

Back

</a>

</div>

<p>
    <u>Total Attempts:</u> <b>{{ $totalAttempts }}</b>
    <u>Highest Score:</u> <b>{{ $highestScore }}</b>
    <u>Average Score:</u> <b>{{ $averageScore }}</b>
    <u>Lowest Score:</u> <b>{{ $lowestScore }}</b>
</p>

<table class="table table-bordered">

<thead>

<tr>

<th>Student</th>

<th>Class</th>

<th>Section</th>

<th>Correct</th>

<th>Wrong</th>

<th>Unanswered</th>

<th>Score</th>

<th>Date</th>

</tr>

</thead>

<tbody>

@foreach($results as $result)

<tr>

<td>{{ $result->fullname }}</td>

<td>{{ $result->col_current_class }}</td>

<td>{{ $result->col_section }}</td>

<td>{{ $result->correct }}</td>

<td>{{ $result->wrong }}</td>

<td>{{ $result->unanswered }}</td>

<td>

<span class="badge bg-success">

{{ $result->score }}

</span>

</td>

<td>{{ $result->date }}</td>

</tr>

@endforeach

</tbody>

</table>

{{ $results->links() }}

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

