<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faculty::insert([
            ['nama_fakultas' => 'Fakultas Teknologi'],
            ['nama_fakultas' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama_fakultas' => 'Fakultas Hukum dan Pendidikan'],
        ]);
    }
}
