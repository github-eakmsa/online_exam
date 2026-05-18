<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\Option;
use App\Models\Answer;
use App\Models\Quiz;
use App\Models\ExamQuestion;
use App\Models\Subject;
use Log;
use Yajra\DataTables\Facades\DataTables;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /* ================= QUESTIONS ================= */

    public function questions()
    {
        $classLevels = config('_option.grade_levels');
        $subjects = Subject::orderBy('subject_name')->get();

        return view('teacher.questions.index', compact('classLevels', 'subjects'));
    }

    public function questionsData(Request $request)
    {
        $query = Question::query();

        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        return DataTables::of($query)
            ->addColumn('actions', function ($question) {
                return '
                    <a href="/teacher/questions/edit/'.$question->qid.'" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/teacher/questions/delete/'.$question->qid.'" onclick="return confirm(\'Are you sure you want to delete this record?\')" class="btn btn-sm btn-danger">Delete</a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function createQuestion()
    {
        return view('teacher.questions.create');
    }

    public function storeQuestion(Request $request)
    {
        $user = session('staff');

        Log::info('Storing new question', ['request' => $request->all(), 'user_id' => $user]);

        $request->validate([
            'question' => 'required_if:question_type,text',
            'question_image' => 'required_if:question_type,image|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'required|array|min:2',
            'correct' => 'required'
        ]);

        $imagePath = null;

        if ($request->hasFile('question_image')) {

            $imagePath = $request
                ->file('question_image')
                ->store('questions', 'public');
        }

        $qid = Str::uuid();

        if ($request->question_type == 'image') {
            $question = "question image attached";
            $questionImage = $imagePath;
        }
        else {
            $question = $request->question;
            $questionImage = null;
        }

        Question::create([
            'qid' => $qid,
            'grade_level' => $request->grade_level,
            'subject' => $request->subject,
            'question_type' => $request->question_type,
            'qns' => $question,
            'question_image' => $questionImage,
            'choice' => count($request->options),
            'created_by' => $user['id'],
            'exam_type' => 'mcq',
            'status' => 1
        ]);

        foreach ($request->options as $index => $opt) {

            $optionId = Str::uuid();

            Option::create([
                'qid' => $qid,
                'option' => $opt,
                'optionid' => $optionId
            ]);

            if ($index == $request->correct) {
                Answer::create([
                    'qid' => $qid,
                    'ansid' => $optionId
                ]);
            }
        }

        return redirect('teacher/questions')->with('success', 'Question created');
    }

    public function editQuestion($id)
    {
        $question = Question::where('qid', $id)->with('options')->firstOrFail();
        return view('teacher.questions.edit', compact('question'));
    }

    public function updateQuestion(Request $request, $id)
    {
        $request->validate([

            'question_type' => 'required|in:text,image',

            'question' => 'nullable',

            'question_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'subject' => 'required',

            'grade_level' => 'required',

            'options' => 'required|array|min:2',

            'correct' => 'required|numeric'

        ]);

        DB::transaction(function () use ($request, $id) {

            $question = Question::where('qid', $id)->firstOrFail();


            $updates = [

                'question_type' => $request->question_type,

                'subject' => $request->subject,

                'grade_level' => $request->grade_level,

                'status' => $request->status

            ];

            $imagePath = $question->question_image;

            /*
            |--------------------------------------------------------------------------
            | Handle Image Upload
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('question_image')) {

                // delete old image
                if ($question->question_image &&
                    Storage::disk('public')->exists($question->question_image)) {

                    Storage::disk('public')->delete($question->question_image);
                }

                $imagePath = $request
                    ->file('question_image')
                    ->store('questions', 'public');
            }

            if ($request->question_type == 'image') {
                $questionText = "question image attached";
                $questionImage = $imagePath;
            }
            else {
                $questionText = $request->question;
                $questionImage = null;
            }

            $updates['qns'] = $questionText;
            $updates['question_image'] = $questionImage;

            /*
            |--------------------------------------------------------------------------
            | Update Question
            |--------------------------------------------------------------------------
            */

            $question->update($updates);

            /*
            |--------------------------------------------------------------------------
            | Replace Options
            |--------------------------------------------------------------------------
            */

            Option::where('qid', $id)->delete();

            Answer::where('qid', $id)->delete();

            foreach ($request->options as $index => $opt) {

                $optionId = (string) Str::uuid();

                Option::create([

                    'qid' => $id,

                    'option' => $opt,

                    'optionid' => $optionId

                ]);

                if ((int)$index === (int)$request->correct) {

                    Answer::create([

                        'qid' => $id,

                        'ansid' => $optionId

                    ]);
                }
            }
        });

        return redirect('/teacher/questions')
            ->with('success', 'Question updated successfully');
    }

    public function deleteQuestion($id)
    {
        Question::where('qid', $id)->delete();
        Option::where('qid', $id)->delete();
        Answer::where('qid', $id)->delete();

        return back()->with('success', 'Deleted');
    }

    /* ================= EXAMS ================= */

    public function exams()
    {
        $subjects = Subject::orderBy('subject_name')->get();
        $classLevels = Quiz::select('class_level')
            ->distinct()
            ->orderBy('class_level')
            ->pluck('class_level');

        return view('teacher.exams.index', compact('subjects', 'classLevels'));
    }

    public function examsData(Request $request)
    {
        $query = Quiz::with('subject');

        if ($request->filled('subject_ID')) {
            $query->where('subject_ID', $request->subject_ID);
        }

        if ($request->filled('class_level')) {
            $query->where('class_level', $request->class_level);
        }

        return DataTables::eloquent($query)
            ->addColumn('actions', function ($exam) {
                return '
                    <a href="/teacher/exams/edit/'.$exam->id.'" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/teacher/exams/'.$exam->id.'/assign" class="btn btn-sm btn-warning">Assign Questions</a>
                    <a href="/teacher/exams/delete/'.$exam->id.'" onclick="return confirm(\'Are you sure you want to delete this record?\')" class="btn btn-sm btn-danger">Delete</a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function createExam()
    {
        return view('teacher.exams.create');
    }

    public function storeExam(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'time' => 'required'
        ]);

        $quiz = Quiz::create([
            'eid' => (string) Str::uuid(),
            'title' => $request->title,
            'subject_ID' => $request->subject_ID,
            'class_level' => $request->class_level,
            'time' => $request->time,
            'total' => 0,
            'sahi' => 1,
            'wrong' => 0,
            'intro' => $request->intro,
            'status' => 1
        ]);

        $eid = $quiz->id;

        // return redirect()->route('teacher.exams')->with('success', 'Exam created');
        return redirect("/teacher/exams/{$eid}/assign")
                ->with('success', 'Exam created. Now assign questions.');
    }

    public function editExam($id)
    {
        $exam = Quiz::findOrFail($id);
        return view('teacher.exams.edit', compact('exam'));
    }

    public function updateExam(Request $request, $id)
    {
        Quiz::findOrFail($id)->update($request->all());

        return redirect('teacher/exams')->with('success', 'Updated');
    }

    public function deleteExam($id)
    {
        Quiz::findOrFail($id)->delete();

        ExamQuestion::where('examID', $id)->delete();

        return back()->with('success', 'Deleted');
    }

    /* ================= ASSIGN QUESTIONS ================= */

    public function assignQuestions($eid)
    {
        $exam = Quiz::findOrFail($eid);
        $subject = Subject::findOrFail($exam->subject_ID);
        return view('teacher.exams.assign', compact('exam', 'subject'));
    }

    public function storeAssignQuestions(Request $request, $eid)
    {
        $exam = Quiz::where('id', $eid)->firstOrFail();

        Log::info('Assigning questions to exam', ['exam_id' => $eid, 'count' => $request->count]);

        $count = (int) $request->count;

        $grade_level = explode("_", $exam->class_level)[0]; // e.g. "10_A" => "10"

        // 1. Get matching questions
        $questions = Question::where('subject', $exam->subject?->subject_name)
            ->where('grade_level',  $grade_level)
            ->where('status', 1)
            ->inRandomOrder()
            ->limit($count)
            ->get();

        Log::info('Fetched questions', ['fetched_count' => $questions->count(), 'requested_count' => $count]);

        // 2. Validation
        if ($questions->count() < $count) {
            Log::warning('Not enough questions available for this exam', ['available' => $questions->count(), 'requested' => $count]);
            return back()->with('error', 'Not enough questions available for this exam. found only ' . $questions->count() . ' questions.');
        }

        Log::info('Validation passed, proceeding to assign questions');

        // 3. Remove existing assignments (optional but recommended)
        ExamQuestion::where('examID', $exam->id)->delete();

        // 4. Assign questions
        foreach ($questions as $q) {
            ExamQuestion::create([
                'examID' => $exam->id,
                'quesID' => $q->qid,
                'status' => 1
            ]);
        }

        // 5. Update total questions in exam
        $exam->update([
            'total' => $count
        ]);

        return redirect('/teacher/exams')
            ->with('success', 'Questions assigned successfully.');
    }

}
