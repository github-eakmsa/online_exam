<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $primaryKey = 'student_ID';

    protected $fillable = [
        'profile_ID',
        'fullname',
        'col_gender',
        'col_age',
        'col_phone',
        'col_current_class',
        'col_section',
        'branch',
        'record_status'
    ];

    public $timestamps = false;

    public function loginInformation()
    {
        return $this->hasOne(LoginInformation::class, 'profileID', 'profile_ID');
    }
}
