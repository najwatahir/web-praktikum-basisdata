<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'nim',
        'question_id',
        'query',
        'is_correct',
        'score',
        'attempt',
        'feedback',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'nim', 'nim');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}