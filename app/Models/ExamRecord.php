<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRecord extends Model
{
    protected $table = 'exam_record';

    protected $fillable = [
        'std_id',
        'exam_id',
        'Question_id',
        'option_id'
    ];

    public $timestamps = false;
}
