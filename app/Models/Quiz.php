<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quiz';

    protected $fillable = [
        'eid',
        'subject_ID',
        'class_level',
        'title',
        'sahi',
        'wrong',
        'total',
        'time',
        'intro',
        'status',
        'result_status'
    ];

    public $timestamps = false;

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class, 'examID', 'eid');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_ID', 'subject_ID');
    }
}
