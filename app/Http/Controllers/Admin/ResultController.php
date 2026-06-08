<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Quiz;
use App\Models\History;

class ResultController extends Controller
{

    public function examSummary(Request $request)
    {
        $exams = DB::table('quiz as q')

            ->leftJoin('history as h', 'h.eid', '=', 'q.eid')

            ->select(
                'q.eid',
                'q.title',
                'q.class_level',
                'q.total',
                'q.date',
                DB::raw('COUNT(h.id) as attempts')
            )

            ->groupBy(
                'q.eid',
                'q.title',
                'q.class_level',
                'q.total',
                'q.date'
            )

            ->orderByDesc('q.date')

            ->paginate(20);

        return view(
            'admin.results.exam-summary',
            compact('exams')
        );
    }

    public function examResults($eid)
    {
        $totalAttempts = History::where('eid',$eid)->count();

        $highestScore = History::where('eid',$eid)->max('score');

        $averageScore = History::where('eid',$eid)->avg('score');

        $lowestScore = History::where('eid',$eid)->min('score');

        $exam = Quiz::where('eid',$eid)->firstOrFail();

        $results = DB::table('history as h')

            ->join(
                'students as s',
                's.profile_ID',
                '=',
                'h.profileID'
            )

            ->where('h.eid',$eid)

            ->select(

                'h.*',

                's.fullname',

                's.col_current_class',

                's.col_section'

            )

            ->orderByDesc('h.score')

            ->paginate(50);

        return view(
            'admin.results.exam-results',
            compact('exam','results', 'totalAttempts', 'highestScore', 'averageScore', 'lowestScore')
        );
    }

}
