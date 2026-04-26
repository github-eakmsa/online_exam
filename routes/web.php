<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\StudentAccountController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


// -------------------------------
// Public Routes
// -------------------------------

// Home
Route::get('/', function () {
    return redirect()->route('student.login');
});


// -------------------------------
// Student Routes
// -------------------------------

// Student Login
Route::get('/login', [LoginController::class, 'studentLoginForm'])->name('student.login');
Route::post('/login', [LoginController::class, 'studentLogin']);

// -------------------------------
// Student Authenticated Routes
// -------------------------------

Route::middleware(['student.auth'])->prefix('student')->group(function () {

    // Student Dashboard
    Route::get('/dashboard', [ExamController::class, 'dashboard'])->name('student.dashboard');

    // Student Logout
    Route::post('/logout', [LoginController::class, 'studentLogout'])->name('student.logout');

    // Exams
    Route::get('/exams', [ExamController::class, 'studentExams']);
    Route::get('/exam/{eid}/start', [ExamController::class, 'startExam']);
    Route::post('/exam/{eid}/submit', [ExamController::class, 'submitExam']);

    // Student results list
    Route::get('/results', [ExamController::class, 'results']);
    Route::get('/results/{eid}', [ExamController::class, 'resultDetails']);
});


// -------------------------------
// Staff Routes
// -------------------------------

// Staff Login
Route::get('/staff/login', [LoginController::class, 'staffLoginForm'])->name('staff.login');
Route::post('/staff/login', [LoginController::class, 'staffLogin']);

// -------------------------------
// Staff Authenticated
// -------------------------------

Route::middleware(['staff.auth'])->group(function () {

    // Staff Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');

    // Staff Logout
    Route::post('/staff/logout', [LoginController::class, 'staffLogout'])->name('staff.logout');

});

// ---- New Staff Routes (using session-based auth) ----
Route::middleware(['staff.auth'])->prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/data', [AdminController::class, 'usersData']);
    Route::get('/users/create', [AdminController::class, 'createUser']);
    Route::post('/users/store', [AdminController::class, 'storeUser']);
    Route::get('/users/edit/{id}', [AdminController::class, 'editUser']);
    Route::post('/users/update/{id}', [AdminController::class, 'updateUser']);
    Route::get('/users/delete/{id}', [AdminController::class, 'deleteUser']);

    /*
    |--------------------------------------------------------------------------
    | STUDENTS
    |--------------------------------------------------------------------------
    */
    Route::get('/students', [AdminController::class, 'students']);
    Route::get('/students/data', [AdminController::class, 'studentsData']);
    Route::get('/students/template', function(){
        return response()->download(public_path('student_template.xlsx'));
    });
    Route::post('/students/import', [AdminController::class,'importStudents']);
    Route::get('/students/create', [AdminController::class, 'createStudent']);
    Route::post('/students/store', [AdminController::class, 'storeStudent']);
    Route::get('/students/edit/{id}', [AdminController::class, 'editStudent']);
    Route::post('/students/update/{id}', [AdminController::class, 'updateStudent']);
    Route::get('/students/delete/{id}', [AdminController::class, 'deleteStudent']);

    /*
    |--------------------------------------------------------------------------
    | SUBJECTS
    |--------------------------------------------------------------------------
    */
    Route::get('/subjects', [AdminController::class, 'subjects']);
    Route::get('/subjects/data', [AdminController::class, 'subjectsData']);
    Route::post('/subjects/store', [AdminController::class, 'storeSubject']);
    Route::get('/subjects/edit/{id}', [AdminController::class, 'editSubject']);
    Route::post('/subjects/update/{id}', [AdminController::class, 'updateSubject']);
    Route::get('/subjects/delete/{id}', [AdminController::class, 'deleteSubject']);

    /*
    |--------------------------------------------------------------------------
    | BRANCHES
    |--------------------------------------------------------------------------
    */
    Route::get('/branches', [AdminController::class, 'branches']);
    Route::post('/branches/store', [AdminController::class, 'storeBranch']);
    Route::get('/branches/edit/{id}', [AdminController::class, 'editBranch']);
    Route::post('/branches/update/{id}', [AdminController::class, 'updateBranch']);
    Route::get('/branches/delete/{id}', [AdminController::class, 'deleteBranch']);
});

Route::middleware(['staff.auth'])->prefix('admin/student-accounts')->group(function () {

    Route::get('/', [StudentAccountController::class,'index']);
    Route::get('/data', [StudentAccountController::class,'studentsAccountData']);
    Route::get('/create/{profileID}', [StudentAccountController::class,'create']);
    Route::post('/store', [StudentAccountController::class,'store']);
    Route::get('/reset-password/{id}', [StudentAccountController::class,'resetPassword']);
    Route::get('/toggle-status/{id}', [StudentAccountController::class,'toggleStatus']);
    Route::get('/delete/{id}', [StudentAccountController::class,'delete']);

});

Route::middleware(['staff.auth'])->prefix('teacher')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | QUESTIONS
    |--------------------------------------------------------------------------
    */
    Route::get('/questions', [TeacherController::class, 'questions']);
    Route::get('/questions/data', [TeacherController::class, 'questionsData']);
    Route::get('/questions/create', [TeacherController::class, 'createQuestion']);
    Route::post('/questions/store', [TeacherController::class, 'storeQuestion']);
    Route::get('/questions/edit/{qid}', [TeacherController::class, 'editQuestion']);
    Route::post('/questions/update/{qid}', [TeacherController::class, 'updateQuestion']);
    Route::get('/questions/delete/{qid}', [TeacherController::class, 'deleteQuestion']);

    /*
    |--------------------------------------------------------------------------
    | EXAMS
    |--------------------------------------------------------------------------
    */
    Route::get('/exams', [TeacherController::class, 'exams']);
    Route::get('/exams/data', [TeacherController::class, 'examsData']);
    Route::get('/exams/create', [TeacherController::class, 'createExam']);
    Route::post('/exams/store', [TeacherController::class, 'storeExam']);
    Route::get('/exams/edit/{id}', [TeacherController::class, 'editExam']);
    Route::post('/exams/update/{id}', [TeacherController::class, 'updateExam']);
    Route::get('/exams/delete/{id}', [TeacherController::class, 'deleteExam']);

    /*
    |--------------------------------------------------------------------------
    | ASSIGN QUESTIONS (AUTO)
    |--------------------------------------------------------------------------
    */
    Route::get('/exams/{eid}/assign', [TeacherController::class, 'assignQuestions']);
    Route::post('/exams/{eid}/assign', [TeacherController::class, 'storeAssignQuestions']);
});
