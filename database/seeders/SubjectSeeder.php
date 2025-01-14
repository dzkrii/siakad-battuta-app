<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'kode_mk' => 'MK001',
            'nama_mk' => 'Pemrograman Web',
            'sks' => 3,
            'study_program_id' => 1, // Pastikan study_program_id ini sudah ada
        ]);

        Subject::create([
            'kode_mk' => 'MK002',
            'nama_mk' => 'Basis Data',
            'sks' => 2,
            'study_program_id' => 1,
        ]);

        Subject::create([
            'kode_mk' => 'MK003',
            'nama_mk' => 'Algoritma dan Struktur Data',
            'sks' => 3,
            'study_program_id' => 1,
        ]);
    }
}
