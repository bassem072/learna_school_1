<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public function education_system()
    {
        return $this->belongsTo(EducationSystem::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'level_teacher', 'level_id', 'teacher_id');
    }
}
