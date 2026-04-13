<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $fillable = [
        'profileID',
        'eid',
        'correct',
        'wrong',
        'unanswered',
        'score',
        'level'
    ];

    public $timestamps = false;

    public function exam()
    {
        return $this->belongsTo(Quiz::class, 'eid', 'id');
    }
}
