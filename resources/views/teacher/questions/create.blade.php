@extends('layouts.app')

@section('content')

<div class="container">

<h3>Create Question</h3>

<form method="POST" action="/teacher/questions/store">
@csrf

<label class="form-label">Subject</label>

<select name="subject" class="form-control mb-3">
    @foreach(\App\Models\Subject::all() as $s)
        <option value="{{ $s->subject_name }}">
            {{ $s->subject_name }}
        </option>
    @endforeach
</select>

<label class="form-label">Grade Level</label>

<select name="grade_level" class="form-control mb-3">
    @foreach (config('_option.grade_levels') as $key => $item)
        <option>{{ $item }}</option>
    @endforeach
</select>

<label class="form-label">Question</label>

<textarea
    name="question"
    class="form-control ckeditor mb-3"
    rows="5"
    placeholder="Question">
</textarea>

<label class="form-label mt-3">Options</label>

@foreach(config('_option.option_letters') as $key => $item)

    <textarea
        name="options[]"
        class="form-control ckeditor mb-3"
        rows="2"
        placeholder="Option {{ $item }}">
    </textarea>

@endfor

<label class="form-label mt-3">Correct Option</label>

<select name="correct" class="form-control mb-3">
    @foreach (config('_option.option_letters') as $key => $item)
        <option value="{{ $key }}">{{ $item }}</option>
    @endforeach
</select>

<button class="btn btn-success">Save Question</button>

</form>

</div>

@endsection
