<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $table = 'exam_questions';

    protected $fillable = ['examID', 'quesID', 'status'];

    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class, 'quesID', 'qid');
    }
}
