<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lecturer::create([
            'nidn' => '1234567890',
            'name' => 'Dr. John Smith',
            'password' => Hash::make('password'),
            'telepon' => '081234567890',
            'alamat' => 'Jl. Pendidikan No. 123',
            'role_id' => 3, // Pastikan role_id ini sudah ada
        ]);

        Lecturer::create([
            'nidn' => '0987654321',
            'name' => 'Prof. Jane Wilson',
            'password' => Hash::make('password'),
            'telepon' => '089876543210',
            'alamat' => 'Jl. Akademik No. 456',
            'role_id' => 3,
        ]);
    }
}
