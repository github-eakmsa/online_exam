@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Questions</h3>
    <a href="/teacher/questions/create" class="btn btn-primary mb-3">Add Question</a>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterGradeLevel" class="form-label">Grade Level</label>
            <select id="filterGradeLevel" class="form-control">
                <option value="">All Levels</option>
                @foreach($classLevels as $level)
                    <option value="{{ $level }}">{{ $level }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="filterSubject" class="form-label">Subject</label>
            <select id="filterSubject" class="form-control">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->subject_name }}">{{ $subject->subject_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button id="resetFilters" class="btn btn-secondary ms-auto">Reset Filters</button>
        </div>
    </div>

    <table id="usersTable" class="table table-bordered w-100">
        <thead>
            <tr>
            <th>ID</th>
            <th>Grade Level</th>
            <th>Subject</th>
            <th>Question</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
        </thead>
    </table>

</div>
@endsection


@section('scripts')
<script>
    var recordStatusMap = {
        1: 'Active',
        0: 'Inactive',
        '-1': 'Archived'
    };

$(document).ready(function() {

    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/teacher/questions/data',
            data: function (d) {
                d.grade_level = $('#filterGradeLevel').val();
                d.subject = $('#filterSubject').val();
            }
        },
        columns: [
            { data: 'qid' },
            { data: 'grade_level' },
            { data: 'subject' },
            { data: 'qns' },
            { data: 'status', render: function(data) {
                return recordStatusMap[data] || data;
            } },
            { data: 'actions', orderable:false, searchable:false }
        ]
    });

    $('#filterGradeLevel, #filterSubject').on('change', function() {
        table.ajax.reload();
    });

    $('#resetFilters').on('click', function() {
        $('#filterGradeLevel').val('');
        $('#filterSubject').val('');
        table.ajax.reload();
    });

});
</script>
@endsection
