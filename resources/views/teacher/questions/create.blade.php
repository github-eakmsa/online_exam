@extends('layouts.app')

@section('content')

<div class="container">

<h3>Create Question</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/teacher/questions/store" enctype="multipart/form-data">
@csrf

<label class="form-label">Grade Level</label>

<select name="grade_level" class="form-control mb-3">
    <option value="">-Select Grade Level-</option>
    @foreach (config('_option.grade_levels') as $key => $item)
        <option>{{ $item }}</option>
    @endforeach
</select>

<label class="form-label">Subject</label>

<select name="subject" class="form-control mb-3">
    <option value="">-Select Subject-</option>
    @foreach(\App\Models\Subject::all() as $s)
        <option value="{{ $s->subject_name }}">
            {{ $s->subject_name }}
        </option>
    @endforeach
</select>

<div class="mb-3">

<label>Question Type</label>

<select name="question_type"
class="form-control"
id="questionType">

<option value="">-Select Question Type-</option>
<option value="text">Text Question</option>
<option value="image">Image Question</option>

</select>

</div>

<div id="textQuestionArea">

<label>Question</label>

<textarea
name="question"
id="question-editor"
class="form-control ckeditor mb-3"
rows="5"
placeholder="Question">
</textarea>

</div>

<div id="imageQuestionArea" style="display:none;">

<label>Upload Question Screenshot</label>

<input type="file"
name="question_image"
class="form-control"
accept="image/*">

</div>

<label class="form-label mt-3">Options</label>

@foreach(config('_option.option_letters') as $key => $item)

    <textarea
        name="options[]"
        class="form-control ckeditor mb-3"
        rows="2"
        placeholder="Option {{ $item }}">
    </textarea>

@endforeach

<label class="form-label mt-3">Correct Option</label>

<select name="correct" class="form-control mb-3">
    <option value="">-Select Correct Option-</option>
    @foreach (config('_option.option_letters') as $key => $item)
        <option value="{{ $key }}">{{ $item }}</option>
    @endforeach
</select>

<button class="btn btn-success">Save Question</button>

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
