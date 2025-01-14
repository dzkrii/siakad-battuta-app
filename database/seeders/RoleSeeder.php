<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'dosen', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
