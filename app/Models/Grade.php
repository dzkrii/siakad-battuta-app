<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'schedule_id',
        'setting_id',
        'nilai_absensi',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas'
    ];

    protected $appends = ['nilai_akhir', 'grade_huruf'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    // Menghitung nilai akhir berdasarkan bobot
    public function getNilaiAkhirAttribute()
    {
        $bobot_absensi = 0.1; // 10%
        $bobot_tugas = 0.5;   // 50%
        $bobot_uts = 0.15;     // 15%
        $bobot_uas = 0.25;     // 25%

        return ($this->nilai_absensi * $bobot_absensi) +
            ($this->nilai_tugas * $bobot_tugas) +
            ($this->nilai_uts * $bobot_uts) +
            ($this->nilai_uas * $bobot_uas);
    }

    // Konversi nilai angka ke huruf
    public function getGradeHurufAttribute()
    {
        $nilai = $this->getNilaiAkhirAttribute();

        if ($nilai >= 80) return 'A';
        if ($nilai >= 75) return 'B+';
        if ($nilai >= 71) return 'B';
        if ($nilai >= 56) return 'C+';
        if ($nilai >= 51) return 'C';
        if ($nilai >= 40) return 'D';
        return 'E';
    }
}
