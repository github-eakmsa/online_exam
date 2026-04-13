@extends('layouts.student')

@section('content')
<div class="container">

    <h3 class="mb-4">Exam Review</h3>

    @foreach($data as $index => $item)
        <div class="card p-3 mb-3">

            <p><strong>Q{{ $index+1 }}:</strong> {{ $item['question']->qns }}</p>

            @foreach($item['options'] as $opt)

                @php
                    $isCorrect = $opt->optionid == $item['correct'];
                    $isSelected = $opt->optionid == $item['selected'];
                @endphp

                <div style="
                    padding:5px;
                    background:
                        {{ $isCorrect ? '#d4edda' : ($isSelected ? '#f8d7da' : '') }};
                ">
                    {{ $opt->option }}

                    @if($isCorrect)
                        ✅
                    @endif

                    @if($isSelected && !$isCorrect)
                        ❌
                    @endif
                </div>

            @endforeach

        </div>
    @endforeach

</div>
@endsection