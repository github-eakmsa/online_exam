@extends('layouts.app')

@section('content')

<div class="container">

<h3>Student Accounts</h3>

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Profile ID</th>
<th>Username</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($accounts as $acc)

<tr>

<td>{{ $acc->id }}</td>

<td>{{ $acc->profileID }}</td>

<td>{{ $acc->username }}</td>

<td>
@if($acc->status)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-danger">Disabled</span>
@endif
</td>

<td>

<a href="/admin/student-accounts/reset-password/{{ $acc->id }}"
class="btn btn-warning btn-sm" onclick="return confirm('Are you sure to reset password?')">
Reset Password
</a>

<a href="/admin/student-accounts/toggle-status/{{ $acc->id }}"
class="btn btn-info btn-sm" onclick="return confirm('Are you sure to toggle status?')">
Toggle Status
</a>

<a href="/admin/student-accounts/delete/{{ $acc->id }}"
class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this record')">
Delete
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $accounts->links() }}

</div>

@endsection
