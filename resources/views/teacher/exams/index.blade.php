@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Exams</h3>

    <a href="/teacher/exams/create" class="btn btn-primary mb-3">Create Exam</a>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterClassLevel" class="form-label">Grade Level</label>
            <select id="filterClassLevel" class="form-control">
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
                    <option value="{{ $subject->subject_ID }}">{{ $subject->subject_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button id="resetFilters" class="btn btn-secondary ms-auto">Reset Filters</button>
        </div>
    </div>

    <table id="usersTable" class="table table-bordered">
        <thead>
            <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Class</th>
            <th>Subject</th>
            <th>Total Questions</th>
            <th>Status</th>
            <th>Result Status</th>
            <th>Action</th>
            </tr>
        </thead>
    </table>

</div>
@endsection


@section('scripts')
<script>
    recordStatusMap = {
        1: 'Active',
        0: 'Inactive',
        '-1': 'Archived'
    };

$(document).ready(function() {

    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/teacher/exams/data',
            data: function (d) {
                d.subject_ID = $('#filterSubject').val();
                d.class_level = $('#filterClassLevel').val();
            }
        },
        columns: [
            { data: 'id' },
            { data: 'title' },
            { data: 'class_level' },
            { data: 'subject.subject_name' },
            { data: 'total' },
            { data: 'status', render: function(data) {
                return recordStatusMap[data] || data;
            } },
            { data: 'result_status', render: function(data) {
                return recordStatusMap[data] || data;
            } },
            { data: 'actions', orderable:false, searchable:false }
        ]
    });

    $('#filterClassLevel, #filterSubject').on('change', function() {
        table.ajax.reload();
    });

    $('#resetFilters').on('click', function() {
        $('#filterClassLevel').val('');
        $('#filterSubject').val('');
        table.ajax.reload();
    });

});
</script>
@endsection
