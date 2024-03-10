<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\GuruFoundation as Authenticatable;;

class Guru extends Authenticatable
{
    use HasFactory;
    protected $table = 'guru';
    protected $fillable = [
        'id', 'nip_nik_nisn', 'nama', 'password', 'sekolah_id', 'password_view', 'created_at', 'updated_at'
    ];
    protected $hidden = ['password'];

    static function get($guru_id)
    {
        return static::where('id', $guru_id)->first();
    }
}
