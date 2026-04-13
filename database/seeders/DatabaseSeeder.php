<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // AI collect the above staff user data into an array and run query iteratively to create users
        $staffUsers = [
            [
                'fullname' => 'Super Admin',
                'phone' => '0900000000',
                'branch' => 'Main',
                'role' => 'superadmin',
                'email' => 'superadmin@example.com',
            ],
            [
                'fullname' => 'Admin User',
                'phone' => '0911111111',
                'branch' => 'Main',
                'role' => 'admin',
                'email' => 'admin@example.com',
            ],
            [
                'fullname' => 'Teacher User',
                'phone' => '0922222222',
                'branch' => 'Main',
                'role' => 'teacher',
                'email' => 'teacher@example.com',
            ]
        ];

        foreach ($staffUsers as $user) {
            $id = (string) Str::uuid();

            User::create([
                'userid' => $id,
                'fullname' => $user['fullname'],
                'phone' => $user['phone'],
                'branch' => $user['branch'],
                'role' => $user['role'],
                'status' => 1
            ]);

            Admin::create([
                'admin_id' => $id,
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'temp' => 'password',
                'login_status' => 1
            ]);
        }
    }
}
