<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\ExamRecord;
use App\Models\History;
use App\Models\Answer;
use App\Models\Option;
use App\Models\ExamSession;
use Log;
use Carbon\Carbon;

class ExamController extends Controller
{

    public function dashboard()
    {
        $student = session('student');

        if (!$student) {
            return redirect()->route('student.login');
        }

        $exams = Quiz::where('class_level', $student['class'])
            ->where('status', 1)
            ->count();

        $attempts = History::where('profileID', $student['profileID'])->count();

        $average = History::where('profileID', $student['profileID'])->avg('score') ?? 0;

        return view('student.dashboard', compact('exams', 'attempts', 'average', 'student'));
    }

    // ================= NEW FUNCTIONS =================

    public function studentExams()
    {
        $student = session('student');

        $class_section = $student['class'] . '_' . $student['section']; // e.g. "10_A"

        $exams = Quiz::where('class_level', $class_section)
            ->where('status', config('_const.exam_status_active'))
            ->whereNotIn('id', function($query) use ($student) {
                $query->select('eid')->from('history')->where('profileID', $student['profileID']);
            })
            ->get();

        return view('student.exams.index', compact('exams'));
    }

    public function startExam($eid)
    {
        $student = session('student');

        // check if exam session already exists and is active
        $existingSession = ExamSession::where('profileID', $student['profileID'])
            ->where('exam_id', $eid)
            ->where('status', config('_const.exam_status_active'))
            ->first();
        if ($existingSession) {
            return redirect('/student/exams')->with('error', 'You have an active session for this exam. Please complete it.');
        }

        // Prevent retake
        if (History::where('profileID', $student['profileID'])
            ->where('eid', $eid)->exists()) {
            return redirect('/student/exams')->with('error', 'Already attempted');
        }

        $exam = Quiz::where('eid', $eid)->firstOrFail();

        // Create session
        $now = Carbon::now();
        $expires = Carbon::now()->addSeconds((int)$exam->time);

        ExamSession::create([
            'profileID' => $student['profileID'],
            'exam_id' => $eid,
            'started_at' => $now,
            'expires_at' => $expires,
            'status' => config('_const.exam_status_active')
        ]);

        // Load questions
        $qids = ExamQuestion::where('examID', $exam->id)->pluck('quesID');

        $questions = Question::whereIn('qid', $qids)->get()->shuffle();

        foreach ($questions as $q) {
            $q->options = Option::where('qid', $q->qid)->get()->shuffle();
        }

        return view('student.exams.take', compact('exam', 'questions', 'now', 'expires'));
    }

    public function submitExam(Request $request, $eid)
    {
        $student = session('student');

        // log every step for debugging
        Log::info("Student {$student['profileID']} submitting exam {$eid}");

        $exam = Quiz::findOrFail($eid);

        $session = ExamSession::where('profileID', $student['profileID'])
            ->where('exam_id', $exam->eid)
            ->where('status', config('_const.exam_status_active'))
            ->first();

        Log::info("Session found: " . ($session ? 'Yes' : 'No'));

        if (!$session) {
            return redirect('/student/dashboard')->with('error', 'Invalid session');
        }

        // Check expiry
        if (now()->gt($session->expires_at)) {
            $session->update(['status' => 0]);
        }

        Log::info("Session status after expiry check: " . $session->status);

        // Prevent double submit
        if (History::where('profileID', $student['profileID'])
            ->where('eid', $eid)->exists()) {
            Log::warning("Student {$student['profileID']} attempted to resubmit exam {$eid}");
            return redirect('/student/dashboard')->with('error', 'Already submitted');
        }

        // Process answers (same as before)
        $answers = $request->answers ?? [];

        $correct = 0;
        $wrong = 0;
        $unanswered = 0;

        $questionIds = ExamQuestion::where('examID', $eid)->pluck('quesID');

        Log::info("Processing answers for questions: " . implode(',', $questionIds->toArray()));

        foreach ($questionIds as $qid) {

            $selected = $answers[$qid] ?? null;

            if (!$selected) {
                $unanswered++;
                continue;
            }

            $correctAnswer = Answer::where('qid', $qid)->value('ansid');

            if ($selected == $correctAnswer) {
                $correct++;
            } else {
                $wrong++;
            }

            // Save record
            ExamRecord::create([
                'std_id' => $student['profileID'],
                'exam_id' => $eid,
                'Question_id' => $qid,
                'option_id' => $selected
            ]);
        }

        $score = $correct;

        History::create([
            'profileID' => $student['profileID'],
            'eid' => $eid,
            'correct' => $correct,
            'wrong' => $wrong,
            'unanswered' => $unanswered,
            'score' => $score,
            'level' => 1
        ]);

        // mark session closed
        $session->update(['status' => 0]);

        return redirect('/student/results')->with('success', 'Exam Submitted');
    }

    public function results()
    {
        $student = session('student');

        $results = History::whereHas('exam', function ($query) {
                $query->where('result_status', config('_const.result_status_show'));
            })
            ->where('profileID', $student['profileID'])
            ->orderBy('date', 'desc')
            ->get();

        return view('student.results.index', compact('results'));
    }

    public function resultDetails($eid)
    {
        $student = session('student');

        // exam record (student answers)
        $records = ExamRecord::where('std_id', $student['profileID'])
            ->where('exam_id', $eid)
            ->get();

        $data = [];

        foreach ($records as $rec) {

            $question = Question::where('qid', $rec->Question_id)->first();

            $options = Option::where('qid', $rec->Question_id)->get();

            $correct = Answer::where('qid', $rec->Question_id)->value('ansid');

            $data[] = [
                'question' => $question,
                'options' => $options,
                'selected' => $rec->option_id,
                'correct' => $correct
            ];
        }

        return view('student.results.details', compact('data'));
    }
}
