@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Exam</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/teacher/exams/store">
        @csrf

        <div class="mb-2">
            <label>Exam Title</label>
            <input name="title" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Subject</label>
            <select name="subject_ID" class="form-control" required>
                @foreach(\App\Models\Subject::all() as $s)
                    <option value="{{ $s->subject_ID }}">
                        {{ $s->subject_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label>Class Level</label>
            <input name="class_level" class="form-control" placeholder="e.g. 10_A" required>
        </div>

        <div class="mb-2">
            <label>Time (seconds)</label>
            <input type="number" name="time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Instructions</label>
            <textarea name="intro" class="form-control" required></textarea>
        </div>

        <button class="btn btn-primary">Create Exam</button>
    </form>
</div>
@endsection
