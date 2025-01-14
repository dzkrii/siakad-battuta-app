<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        // Ketika setting baru diaktifkan, nonaktifkan semua setting lainnya
        static::saving(function ($setting) {
            if ($setting->status === 'Aktif') {
                static::where('id', '!=', $setting->id)
                    ->update(['status' => 'Tidak Aktif']);
            }
        });
    }
}
