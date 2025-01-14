<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'nim' => '12345678',
            'name' => 'John Doe',
            'study_program_id' => 1, // Pastikan study_program_id ini sudah ada
            'password' => Hash::make('password'),
            'telepon' => '081234567890',
            'alamat' => 'Jl. Contoh No. 123',
            'angkatan' => '2023',
            'status' => 'aktif',
            'role_id' => 2, // Pastikan role_id ini sudah ada
        ]);

        Student::create([
            'nim' => '87654321',
            'name' => 'Jane Doe',
            'study_program_id' => 2,
            'password' => Hash::make('password'),
            'telepon' => '089876543210',
            'alamat' => 'Jl. Sample No. 456',
            'angkatan' => '2023',
            'status' => 'aktif',
            'role_id' => 2,
        ]);
    }
}
