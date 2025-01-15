<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'nim',
        'name',
        'study_program_id',
        'password',
        'foto',
        'telepon',
        'alamat',
        'angkatan',
        'status',
        'role_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
