<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\History;

class DashboardController extends Controller
{
    public function index()
    {
        $role = session('staff.role');

        return match ($role) {
            'superadmin' => $this->superAdmin(),
            'admin' => $this->admin(),
            'teacher' => $this->teacher(),
            'student' => $this->student(),
            default => abort(403)
        };
    }

    /* ================= SUPER ADMIN ================= */

    private function superAdmin()
    {
        return view('dashboard.superadmin', [
            'users' => User::count(),
            'students' => Student::count(),
            'exams' => Quiz::count(),
            'questions' => Question::count(),
        ]);
    }

    /* ================= ADMIN ================= */

    private function admin()
    {
        return view('dashboard.admin', [
            'students' => Student::count(),
            'teachers' => User::where('role', 'teacher')->count(),
            'subjects' => \App\Models\Subject::count(),
            'branches' => \App\Models\Branch::count(),
        ]);
    }

    /* ================= TEACHER ================= */

    private function teacher()
    {
        $userId = session('staff.userid');

        return view('dashboard.teacher', [
            'questions' => Question::where('created_by', $userId)->count(),
            'exams' => Quiz::count(),
            'attempts' => History::count(),
        ]);
    }

    /* ================= STUDENT ================= */

    private function student()
    {
        $userId = session('student.profileID');

        return view('dashboard.student', [
            'exams' => Quiz::where('status', 1)->count(),
            'attempts' => History::where('profileID', $userId)->count(),
            'average' => History::where('profileID', $userId)->avg('score') ?? 0,
        ]);
    }
}
