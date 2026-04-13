@extends('layouts.student')

@section('content')
<div class="container">
    <h3>Start Exam</h3>
    <form method="POST" action="/student/exam/{{ $exam->id }}/submit">
@csrf

@foreach($questions as $q)
    <div class="mb-3">
        <h5>{{ $q->question->qns }}</h5>

        @foreach($q->question->options as $opt)
            <div>
                <input type="radio" name="answers[{{ $q->quesID }}]" value="{{ $opt->optionid }}">
                {{ $opt->option }}
            </div>
        @endforeach
    </div>
@endforeach

<button class="btn btn-success">Submit</button>
</form>
</div>
@endsection

