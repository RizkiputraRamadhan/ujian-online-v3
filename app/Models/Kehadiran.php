<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;
    protected $table = 'kehadiran';
    protected $guarded = [];

    static function get($jadwal_id, $siswa_id)
    {
        return static::where('jadwal_id', $jadwal_id)->where('siswa_id', $siswa_id)->first();
    }
}
