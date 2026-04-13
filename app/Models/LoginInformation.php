<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class LoginInformation extends Authenticatable
{
    use Notifiable;

    protected $table = 'login_information';

    protected $fillable = [
        'profileID',
        'username',
        'password',
        'temp',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    // العلاقة مع users
    public function student()
    {
        return $this->hasOne(Student::class, 'profile_ID', 'profileID');
    }

    // Helper: get role
    public function getRoleAttribute()
    {
        return optional($this->user)->role;
    }
}
