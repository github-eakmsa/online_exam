<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginInformation;
use App\Models\Student;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\User;
use Log;

class LoginController extends Controller
{
    /* ================= STAFF LOGIN ================= */

    public function staffLoginForm()
    {
        return view('auth.login');
    }

    public function staffLogin(Request $request)
    {
        $login = Admin::where('email', $request->email)->first();

        Log::info('Login attempt for email: ' . $request->email);
        Log::info('Login record found: ' . ($login ? 'Yes' : 'No'));

        if (!$login || !Hash::check($request->password, $login->password)) {
            Log::warning('Failed login attempt for email: ' . $request->email);
            return back()->with('error', 'Invalid credentials');
        }

        Log::info('Successful login for email: ' . $request->email);

        // Get user profile
        $user = User::where('userid', $login->admin_id)->first();

        if (!$user) {
            Log::error('User profile not found for admin_id: ' . $login->admin_id);
            return back()->with('error', 'User profile not found');
        }
        Log::info('User profile found for admin_id: ' . $login->admin_id . ', name: ' . $user->fullname);

        // Store session
        Session::put('staff', [
            'id' => $user->sn,
            'userid' => $user->userid,
            'name' => $user->fullname,
            'role' => $user->role,
            'branch' => $user->branch
        ]);

        return redirect()->route('staff.dashboard');
    }

    public function staffLogout()
    {
        session()->forget('staff');
        return redirect()->route('staff.login');
    }

    /* ================= STUDENT LOGIN ================= */

    public function studentLoginForm()
    {
        return view('student.auth.login');
    }

    public function studentLogin(Request $request)
    {
        $login = LoginInformation::where('username', $request->username)->first();

        if (!$login || !Hash::check($request->password, $login->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        // Get student profile
        $student = Student::where('profile_ID', $login->profileID)->first();

        if (!$student) {
            return back()->with('error', 'Student profile not found');
        }

        // Store session
        Session::put('student', [
            'profileID' => $login->profileID,
            'name' => $student->fullname,
            'class' => $student->col_current_class,
            'section' => $student->col_section,
            'branch' => $student->branch
        ]);

        return redirect()->route('student.dashboard');
    }
    public function studentLogout()
    {
        Session::forget('student');
        return redirect()->route('student.login');
    }

}
