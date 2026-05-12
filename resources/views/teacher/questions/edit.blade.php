@extends('layouts.app')

@section('content')
<div class="container">

<h3>Edit Question</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/teacher/questions/update/{{ $question->qid }}" enctype="multipart/form-data">
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


<div class="mb-3">

<label>Question Type</label>

<select
name="question_type"
class="form-control"
id="questionType">

<option
value="text"
{{ $question->question_type == 'text' ? 'selected' : '' }}>
Text Question
</option>

<option
value="image"
{{ $question->question_type == 'image' ? 'selected' : '' }}>
Image Question
</option>

</select>

</div>

<div id="textQuestionArea"
{{ $question->question_type == 'text' ? '' : 'style=display:none;' }}>

<label class="form-label">Question</label>

<textarea
name="question"
id="question-editor"
class="form-control ckeditor mb-3"
rows="5"
placeholder="Question">
{!! $question->qns !!}
</textarea>

</div>

<div
id="imageQuestionArea"
{{ $question->question_type == 'image' ? '' : 'style=display:none;' }}>

<label>Upload Question Image</label>

<input
type="file"
name="question_image"
class="form-control"
accept="image/*">

@if($question->question_image)

<div class="mt-2">

<img
src="{{ asset('storage/'.$question->question_image) }}"
class="img-fluid border rounded"
style="max-height:300px;">

</div>

@endif

</div>

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

<label>Question Status</label>
<select name="status" class="form-control mb-3">
    <option value="1" {{ $question->status == 1 ? 'selected' : '' }}>Active</option>
    <option value="0" {{ $question->status == 0 ? 'selected' : '' }}>Inactive</option>
</select>

<button class="btn btn-success">Update</button>

</form>

</div>
@endsection


@section('scripts')

<script>

document
.getElementById('questionType')
.addEventListener('change', function() {

    if(this.value === 'image') {

        document.getElementById('imageQuestionArea').style.display = 'block';
        document.getElementById('textQuestionArea').style.display = 'none';

    } else {

        document.getElementById('imageQuestionArea').style.display = 'none';
        document.getElementById('textQuestionArea').style.display = 'block';

    }

});

</script>

@endsection
