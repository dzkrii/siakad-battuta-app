<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_fakultas',
    ];

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class, 'faculty_id');
    }
}
