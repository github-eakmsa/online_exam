<?php

namespace Database\Seeders;

use App\Models\LoginInformation;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'fullname' => 'Abel Tesfaye',
                'gender' => 'Male',
                'age' => 16,
                'phone' => '0911111111',
                'class' => '10',
                'section' => 'A',
                'branch' => 'Main'
            ],
            [
                'fullname' => 'Sara Ahmed',
                'gender' => 'Female',
                'age' => 15,
                'phone' => '0922222222',
                'class' => '9',
                'section' => 'B',
                'branch' => 'Main'
            ]
        ];

        foreach ($students as $student) {

            $profileID = Str::uuid()->toString();
            $password = 'password'; // Default password for all students
            $hashedPassword = Hash::make($password); // Default password for all students


            Student::createOrFirst([
                'profile_ID' => $profileID,
                'fullname' => $student['fullname'],
                'col_gender' => $student['gender'],
                'col_age' => $student['age'],
                'col_phone' => $student['phone'],
                'col_current_class' => $student['class'],
                'col_section' => $student['section'],
                'branch' => $student['branch'],
                'record_status' => 1
            ]);

            LoginInformation::createOrFirst([
                'profileID' => $profileID,
                'username' => $student['phone'],
                'password' => $hashedPassword,
                'temp' => $password,
                'status' => 1
            ]);
        }
    }
}
