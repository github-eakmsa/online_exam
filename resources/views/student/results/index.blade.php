@extends('layouts.student')

@section('content')
<div class="container">

    <h3 class="mb-4">My Exam Results</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Exam</th>
                <th>Score</th>
                <th>Correct</th>
                <th>Wrong</th>
                <th>Unanswered</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($results as $r)
                <tr>
                    <td>{{ $r->exam->title ?? 'N/A' }}</td>
                    <td>{{ $r->score }}</td>
                    <td>{{ $r->correct }}</td>
                    <td>{{ $r->wrong }}</td>
                    <td>{{ $r->unanswered }}</td>
                    <td>{{ $r->date }}</td>

                    <td>
                        <a href="/student/results/{{ $r->eid }}" class="btn btn-primary btn-sm">
                            View Details
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection