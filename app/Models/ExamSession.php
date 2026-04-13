<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    protected $table = 'exam_sessions';

    // Laravel default id is fine
    protected $primaryKey = 'id';

    // No created_at / updated_at in your schema
    public $timestamps = false;

    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Link to exam (quiz.eid)
    public function exam()
    {
        return $this->belongsTo(Quiz::class, 'exam_id', 'eid');
    }

    // Optional: link to student
    public function student()
    {
        return $this->belongsTo(Student::class, 'profileID', 'profile_ID');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isActive()
    {
        return $this->status == 1;
    }

    public function isExpired()
    {
        return now()->gt($this->expires_at);
    }
}