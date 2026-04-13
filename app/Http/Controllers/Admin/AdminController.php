<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LoginInformation;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use Yajra\DataTables\Facades\DataTables;

use App\Services\StudentImportService;

class AdminController extends Controller
{
    /* ================= USERS ================= */

    public function users()
    {
        $users = User::with('admin')->get();
        return view('admin.users.index', compact('users'));
    }

    public function usersData()
    {
        $query = User::query();

        return DataTables::of($query)
            ->addColumn('actions', function ($user) {
                return '
                    <a href="/admin/users/edit/'.$user->sn.'" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/admin/users/delete/'.$user->sn.'" onclick="return confirm(\'Are you sure you want to delete this record?\')" class="btn btn-sm btn-danger">Delete</a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $userid = (string) Str::uuid();

        // 1. Create user profile
        User::create([
            'userid' => $userid,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'branch' => $request->branch,
            'role' => $request->role,
            'status' => 1
        ]);

        $hashedPassword = Hash::make($request->password);

        // 2. Create login record
        Admin::create([
            'admin_id' => $userid,
            'email' => $request->email,
            'password' => $hashedPassword, // hash later
            'temp' => $request->password,
            'login_status' => 1
        ]);

        return redirect('/admin/users')->with('success', 'User created');
    }

    public function editUser($id)
    {
        $user = User::with('admin')->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'branch' => $request->branch,
            'role' => $request->role,
        ]);

        if ($user->admin) {
            $user->admin->update([
                'username' => $request->username
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Updated');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        LoginInformation::where('profileID', $user->userid)->delete();
        $user->delete();

        return back()->with('success', 'Deleted');
    }

    /* ================= STUDENTS ================= */

    public function students()
    {
        $students = Student::orderBy('student_ID', 'desc')->get();
        return view('admin.students.index', compact('students'));
    }

    public function studentsData()
    {
        $query = Student::query()->with('loginInformation');

        return DataTables::of($query)
            ->addColumn('actions', function ($student) {
                return '
                    <a href="/admin/students/edit/'.$student->profile_ID.'" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/admin/student-accounts/create/'.$student->profile_ID.'" class="btn btn-sm btn-success">Student Account</a>
                    <a href="/admin/students/delete/'.$student->profile_ID.'" onclick="return confirm(\'Are you sure you want to delete this record?\')" class="btn btn-sm btn-danger">Delete</a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function importStudents(Request $request, StudentImportService $service)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        $service->import($request->file('file')->getPathname());

        return back()->with('success','Students imported successfully');
    }

    public function createStudent()
    {
        return view('admin.students.create');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'class' => 'required'
        ]);

        Student::create([
            'profile_ID' => $request->profile_ID,
            'fullname' => $request->fullname,
            'col_gender' => $request->gender,
            'col_age' => $request->age,
            'col_phone' => $request->phone,
            'col_current_class' => $request->class,
            'col_section' => $request->section,
            'branch' => $request->branch,
        ]);

        $generatedUsername = substr($request->col_phone, 0, 3) . Str::random(3);
        $generatedPassword = Str::random(6);

        LoginInformation::create([
            'profileID' => $request->profile_ID,
            'username' => $generatedUsername,
            'password' => Hash::make($generatedPassword),
            'temp' => $generatedPassword,
        ]);

        return redirect()->route('admin.students')->with('success', 'Student created');
    }

    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $student->update($request->all());

        return redirect()->route('admin.students')->with('success', 'Updated');
    }

    public function deleteStudent($id)
    {
        Student::findOrFail($id)->delete();
        return back()->with('success', 'Deleted');
    }

    /* ================= SUBJECTS ================= */

    public function subjects()
    {
        $subjects = Subject::orderBy('subject_ID', 'desc')->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function subjectsData()
    {
        $query = Subject::query();

        return DataTables::of($query)
            ->addColumn('actions', function ($subject) {
                return '
                    <a href="/admin/subjects/edit/'.$subject->subject_ID.'" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/admin/subjects/delete/'.$subject->subject_ID.'" onclick="return confirm(\'Are you sure you want to delete this record?\')" class="btn btn-sm btn-danger">Delete</a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function storeSubject(Request $request)
    {
        $request->validate(['name' => 'required']);

        Subject::create([
            'subject_name' => $request->name,
            'status' => 1
        ]);

        return back()->with('success', 'Subject added');
    }

    public function editSubject($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'));
    }

    public function updateSubject(Request $request, $id)
    {
        Subject::findOrFail($id)->update([
            'subject_name' => $request->name
        ]);

        return back()->with('success', 'Updated');
    }

    public function deleteSubject($id)
    {
        Subject::findOrFail($id)->delete();
        return back();
    }

    /* ================= BRANCHES ================= */

    public function branches()
    {
        $branches = Branch::orderBy('branch_ID', 'desc')->get();
        return view('admin.branches.index', compact('branches'));
    }

    public function storeBranch(Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'section_name' => 'required'
        ]);

        Branch::create([
            'branch_name' => $request->branch_name,
            'section_name' => $request->section_name,
            'branch_status' => 1
        ]);

        return back()->with('success', 'Branch created');
    }

    public function editBranch($id)
    {
        $branch = Branch::findOrFail($id);
        return view('admin.branches.edit', compact('branch'));
    }

    public function updateBranch(Request $request, $id)
    {
        Branch::findOrFail($id)->update([
            'branch_name' => $request->branch_name,
            'section_name' => $request->section_name
        ]);

        return back()->with('success', 'Updated');
    }

    public function deleteBranch($id)
    {
        Branch::findOrFail($id)->delete();
        return back();
    }
}
