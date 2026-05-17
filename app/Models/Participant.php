<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['nim', 'nama', 'kelompok'];

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'nim', 'nim');
    }
}