<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'sn';

    protected $fillable = [
        'qid',
        'grade_level',
        'subject',
        'qns',
        'choice',
        'created_by',
        'exam_type',
        'status',
        'question_type',
        'question_image'
    ];

    public $timestamps = false;

    public function options()
    {
        return $this->hasMany(Option::class, 'qid', 'qid');
    }

    public function answer()
    {
        return $this->hasOne(Answer::class, 'qid', 'qid');
    }
}
