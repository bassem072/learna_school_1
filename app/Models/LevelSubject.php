<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelSubject extends Model
{
    use HasFactory;

    protected $table =  'level_subject';

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'level_teacher', 'level_subject_id', 'teacher_id');
    }

    
}
