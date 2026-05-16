@extends('layouts.student')

@section('content')
<div class="container">
    <h3>{{ $exam->title }}</h3>
    <p>
        Subject: <b>{{ $exam->subject?->subject_name }}</b> |
        Class: <b>{{ $exam->class_level }}</b> |
        Time: <b>{{ $exam->time }}</b> sec
    </p>

    <div class="alert alert-warning">
        Time Remaining: <span id="timer"></span>
    </div>

    <form method="POST" action="/student/exam/{{ $exam->id }}/submit">
        @csrf

        @foreach($questions as $index => $q)
            <div class="card p-3 mb-3">

                @if($q->question_type === 'image')

                    <img
                        src="{{ asset('storage/'.$q->question_image) }}"
                        class="img-fluid rounded border mb-3">

                @else

                <p><strong>Q{{ $index+1 }}:</strong> {!! $q->qns !!}</p>

                @endif

                @foreach($q->options as $idx => $opt)
                    <div>
                        <input type="radio"
                                id="option-{{ $opt->optionid }}"
                               name="answers[{{ $q->qid }}]"
                               value="{{ $opt->optionid }}">
                               <label for="option-{{ $opt->optionid }}">
                                {{ chr(65 + $idx) }}.
                                {!! $opt->option !!}
                            </label>
                    </div>
                @endforeach
            </div>
        @endforeach

        <button class="btn btn-success">Submit Exam</button>
        <br>
        <small class="text-muted">Note: Once submitted, you cannot retake the exam.</small>
        <br>
    </form>
</div>

<script>
    /**
     * 1. Prepare Expiry:
     * We convert "2026-03-31 20:59:29" to "2026-03-31T20:59:29Z"
     * This forces JavaScript to treat the backend time as UTC.
     */
    const expiryString = "{{ $expires }}".replace(" ", "T") + "Z";
    const endTime = new Date(expiryString).getTime();

    const timer = setInterval(function() {
        // 2. Get current UTC time in milliseconds
        const now = Date.now();

        // 3. Numeric subtraction (both are now UTC timestamps)
        const distance = endTime - now;

        if (distance <= 0) {
            clearInterval(timer);
            document.getElementById("timer").innerHTML = "0m 0s";
            alert("Time is up! Submitting...");
            document.getElementById("examForm").submit();
            return;
        }

        // 4. Calculate display units
        const minutes = Math.floor(distance / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("timer").innerHTML = `${minutes}m ${seconds}s`;

    }, 1000);
</script>

<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>

<script>
document.addEventListener('contextmenu', e => e.preventDefault());
document.addEventListener('copy', e => e.preventDefault());
</script>

@endsection
