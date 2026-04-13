<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\LoginInformation;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentAccountController extends Controller
{

    public function index()
    {
        $accounts = LoginInformation::paginate(20);

        return view('admin.student_accounts.index',compact('accounts'));
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
