<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $primaryKey = 'subject_ID';

    protected $fillable = ['subject_name', 'status'];

    public $timestamps = false;
}
