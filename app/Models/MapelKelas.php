<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelKelas extends Model
{
    use HasFactory;
    protected $table = 'mapel_kelas';
    protected $guarded = [];

    static function validate($mapel_id, $kelas_id)
    {
        return static::where('mapel_id', $mapel_id)->where('kelas_id', $kelas_id)->first();
    }
}
