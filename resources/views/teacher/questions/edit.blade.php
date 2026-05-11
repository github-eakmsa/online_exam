@extends('layouts.app')

@section('content')
<div class="container">

<h3>Edit Question</h3>

<form method="POST" action="/teacher/questions/update/{{ $question->qid }}">
@csrf

<label class="form-label">Subject</label>

<select name="subject" class="form-control mb-3">
    @foreach(\App\Models\Subject::all() as $s)
        <option value="{{ $s->subject_name }}" {{ $question->subject == $s->subject_name ? 'selected' : '' }}>
            {{ $s->subject_name }}
        </option>
    @endforeach
</select>

<label class="form-label">Grade Level</label>

<select name="grade_level" class="form-control mb-3">
    @foreach (config('_option.grade_levels') as $key => $item)
        <option value="{{ $item }}" {{ $question->grade_level == $item ? 'selected' : '' }}>
            {{ $item }}
        </option>
    @endforeach
</select>

<label class="form-label">Question</label>

<textarea
    id="question_editor"
    name="question"
    class="form-control ckeditor mb-3"
    rows="5"
    placeholder="Question">
{!! $question->qns !!}
</textarea>

<label class="form-label mt-3">Options</label>

@php
    $optionLetters = ["A", "B", "C", "D"];
@endphp

@foreach(config('_option.option_letters') as $key => $item)

<textarea
    name="options[]"
    class="form-control ckeditor mb-3"
    rows="2"
    placeholder="Option {{ $item }}">
    {!! $question->options[$key]->option ?? '' !!}
</textarea>

@endforeach

<label class="form-label mt-3">Correct Option</label>

<select name="correct" class="form-control mb-3">
    @foreach (config('_option.option_letters') as $key => $item)
        <option value="{{ $key }}" {{ $question->correct == $key ? 'selected' : '' }}>
            {{ $item }}
        </option>
    @endforeach
</select>

<button class="btn btn-success">Update</button>

</form>

</div>
@endsection
