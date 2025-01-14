<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudyProgram::create([
            'nama_prodi' => 'Teknik Informatika',
            'faculty_id' => 1, // Pastikan faculty_id ini sudah ada di tabel faculties
        ]);

        StudyProgram::create([
            'nama_prodi' => 'Sistem Informasi',
            'faculty_id' => 1,
        ]);

        StudyProgram::create([
            'nama_prodi' => 'Teknologi Informasi',
            'faculty_id' => 1,
        ]);

        StudyProgram::create([
            'nama_prodi' => 'Kewirausahaan',
            'faculty_id' => 2,
        ]);

        StudyProgram::create([
            'nama_prodi' => 'Akuntansi',
            'faculty_id' => 2,
        ]);

        StudyProgram::create([
            'nama_prodi' => 'Manajemen',
            'faculty_id' => 2,
        ]);

        StudyProgram::create([
            'nama_prodi' => 'Hukum',
            'faculty_id' => 3,
        ]);

        StudyProgram::create([
            'nama_prodi' => 'PGSD',
            'faculty_id' => 3,
        ]);

        StudyProgram::create([
            'nama_prodi' => 'PGPAUD',
            'faculty_id' => 3,
        ]);
    }
}
