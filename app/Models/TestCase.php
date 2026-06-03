<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $fillable = [
        'question_id', 
        'nama_test_case', 
        'schema_sql', 
        'expected_output', 
        'bobot_poin', 
        'is_hidden'
    ];

    protected $casts = [
        'expected_output' => 'array',
        'is_hidden' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}