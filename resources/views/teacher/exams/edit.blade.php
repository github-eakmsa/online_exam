@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Exam</h3>
    <form method="POST" action="/teacher/exams/update/{{ $exam->id }}">
@csrf

<input name="title" value="{{ $exam->title }}" class="form-control mb-2">

<div class="mb-2">
    <label>Subject</label>
    <select name="subject_ID" class="form-control">
        @foreach(\App\Models\Subject::all() as $s)
            <option value="{{ $s->subject_ID }}" {{ $s->subject_ID == $exam->subject_ID ? 'selected' : '' }}>
                {{ $s->subject_name }}
            </option>
        @endforeach
    </select>
</div>

<input name="class_level" value="{{ $exam->class_level }}" class="form-control mb-2">
<input name="time" value="{{ $exam->time }}" class="form-control mb-2">

<textarea name="intro" class="form-control mb-2">{{ $exam->intro }}</textarea>

<div class="mb-2">
    <label>Status</label>
    <select name="status" class="form-control">
        @foreach (config('_option.exam_status') as $value => $label)
            <option value="{{ $value }}" {{ $exam->status == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-2">
    <label>Result Status</label>
    <select name="result_status" class="form-control">
        @foreach (config('_option.result_status') as $value => $label)
            <option value="{{ $value }}" {{ $exam->result_status == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

<button class="btn btn-success">Update</button>
</form>
</div>
@endsection


