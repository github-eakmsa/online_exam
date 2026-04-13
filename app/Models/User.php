<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'sn';

    protected $fillable = [
        'userid',
        'fullname',
        'phone',
        'branch',
        'role',
        'status'
    ];

    public $timestamps = false;

    // public function login()
    // {
    //     return $this->belongsTo(LoginInformation::class, 'userid', 'profileID');
    // }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'admin_id', 'userid');
    }
}
