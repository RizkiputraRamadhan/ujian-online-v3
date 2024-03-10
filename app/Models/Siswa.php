<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Foundation\SiswaFoundation as Authenticatable;;

class Siswa extends Authenticatable
{
    use HasFactory;
    protected $table = 'siswa';
    protected $fillable = [
        'id', 'nis', 'nip_nik_nisn', 'nama', 'password', 'jenis_kelamin', 'ttl', 'password_view', 'kelas_id', 'sekolah_id', 'created_at', 'updated_at'
    ];
    protected $hidden = ['password'];
}
