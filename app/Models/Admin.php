<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';

    // Primary key
    protected $primaryKey = 'sn';

    // No timestamps in your DB
    public $timestamps = false;

    // Allow mass assignment
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    | admin.admin_id = users.userid
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id', 'userid');
    }
}