<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grade::create([
            'student_id' => 1, // Pastikan ID ini ada di tabel students
            'subject_id' => 1, // Pastikan ID ini ada di tabel subjects
            'schedule_id' => 1, // Pastikan ID ini ada di tabel schedules
            'setting_id' => 1, // Pastikan ID ini ada di tabel settings
            'nilai_absensi' => 90,
            'nilai_tugas' => 85,
            'nilai_uts' => 78,
            'nilai_uas' => 88
        ]);

        Grade::create([
            'student_id' => 2,
            'subject_id' => 1,
            'schedule_id' => 1,
            'setting_id' => 1,
            'nilai_absensi' => 85,
            'nilai_tugas' => 80,
            'nilai_uts' => 75,
            'nilai_uas' => 82
        ]);
    }
}
