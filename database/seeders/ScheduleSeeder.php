<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::create([
            'subject_id' => 1, // Pastikan ID ini ada di tabel subjects
            'lecturer_id' => 1, // Pastikan ID ini ada di tabel lecturers
            'setting_id' => 2, // Pastikan ID ini ada di tabel settings
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '09:40',
            'ruangan' => '501'
        ]);

        Schedule::create([
            'subject_id' => 2,
            'lecturer_id' => 2,
            'setting_id' => 2,
            'hari' => 'Selasa',
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:40',
            'ruangan' => '502'
        ]);
    }
}
