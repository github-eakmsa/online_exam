<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\LoginInformation;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentAccountController extends Controller
{

    public function index()
    {
        $accounts = LoginInformation::paginate(20);

        return view('admin.student_accounts.index',compact('accounts'));
    }

    public function studentsAccountData()
    {
        $query = LoginInformation::query()->with('student');

        return DataTables::of($query)
            ->addColumn('actions', function ($student) {
                return '
                    <a href="/admin/student-accounts/reset-password/'. $student->id .'"
                    class="btn btn-warning btn-sm" onclick="return confirm(\'Are you sure to reset password?\')">
                    Reset Password
                    </a>

                    <a href="/admin/student-accounts/toggle-status/'. $student->id .'"
                    class="btn btn-info btn-sm" onclick="return confirm(\'Are you sure to toggle status?\')">
                    Toggle Status
                    </a>

                    <a href="/admin/student-accounts/delete/'. $student->id .'"
                    class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure to delete this record?\')">
                    Delete
                    </a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create($profileID)
    {
        $student = Student::where('profile_ID',$profileID)->firstOrFail();

        return view('admin.student_accounts.create',compact('student'));
    }

    public function store()
    {
        $profileID = request('profileID');

        LoginInformation::create([
            'profileID' => $profileID,
            'username' => request('username'),
            'password' => bcrypt(request('password')),
            'status' => 1
        ]);

        return redirect('/admin/student-accounts');
    }

    public function resetPassword($id)
    {
        $account = LoginInformation::findOrFail($id);

        $account->update([
            'password' => bcrypt('123456')
        ]);

        return back()->with('success','Password reset to 123456');
    }

    public function toggleStatus($id)
    {
        $account = LoginInformation::findOrFail($id);

        $account->status = $account->status ? 0 : 1;
        $account->save();

        return back();
    }

    public function delete($id)
    {
        LoginInformation::destroy($id);

        return back();
    }

}
