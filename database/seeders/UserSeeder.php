<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LoginInformation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'fullname' => 'Super Admin',
                'username' => 'superadmin',
                'password' => 'password',
                'role' => 'superadmin'
            ],
            [
                'fullname' => 'Admin User',
                'username' => 'admin',
                'password' => 'password',
                'role' => 'admin'
            ],
            [
                'fullname' => 'Teacher User',
                'username' => 'teacher',
                'password' => 'password',
                'role' => 'teacher'
            ],
            [
                'fullname' => 'Student User',
                'username' => 'student',
                'password' => 'password',
                'role' => 'student'
            ],
        ];

        foreach ($users as $u) {

            $profileID = (string) Str::uuid();

            // LOGIN TABLE
            LoginInformation::create([
                'profileID' => $profileID,
                'username' => $u['username'],
                'password' => Hash::make($u['password']),
                'status' => 1,
                'temp' => $u['password']
            ]);

            // USERS TABLE
            User::create([
                'userid' => $profileID,
                'fullname' => $u['fullname'],
                'phone' => '0910000000',
                'branch' => 'Main',
                'role' => $u['role'],
                'status' => 1
            ]);
        }
    }
}
