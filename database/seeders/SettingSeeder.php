<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Ganjil',
            'status' => 'Tidak Aktif'
        ]);

        Setting::create([
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Genap',
            'status' => 'Aktif'
        ]);
    }
}
