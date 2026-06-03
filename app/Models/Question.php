<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'schema_sql',
        'expected_sql',
        'expected_output',
        'poin',
        'urutan',
        'order_matters',
        'aktif',
    ];

    protected $casts = [
        'expected_output' => 'array',
        'order_matters'   => 'boolean',
        'aktif'           => 'boolean',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function testCases()
{
    return $this->hasMany(TestCase::class);
}
}