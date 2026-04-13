<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'branch_ID';

    protected $fillable = [
        'branch_name',
        'section_name',
        'branch_status'
    ];

    public $timestamps = false;
}
