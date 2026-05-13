<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Student;
use App\Models\LoginInformation;
use Illuminate\Support\Str;

class StudentImportService
{
    public function import($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $rows = $sheet->toArray();

        foreach ($rows as $index => $row) {

            if ($index == 0) {
                continue; // skip header
            }

            $fullname = $row[0];
            $gender = $row[1];
            $age = $row[2];
            $phone = $row[3];
            $class = $row[4];
            $section = $row[5];
            $branch = $row[6];

            if (LoginInformation::where('username',$phone)->exists()) {
                continue;
            }

            # Generate 1 8-character unique ID for profileID, e.g. "a1b2c3d4"
            $profileID = Str::random(8);
            $password = Str::random(8);

            Student::create([
                'profile_ID' => $profileID,
                'fullname' => $fullname,
                'col_gender' => $gender,
                'col_age' => $age,
                'col_phone' => $phone,
                'col_current_class' => $class,
                'col_section' => $section,
                'branch' => $branch,
                'record_status' => 1
            ]);

            LoginInformation::create([
                'profileID' => $profileID,
                'username' => $profileID, // profile ID as username
                'password' => bcrypt($password),
                'temp' => $password,
                'status' => 1
            ]);
        }
    }
}
