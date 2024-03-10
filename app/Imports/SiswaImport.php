<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class SiswaImport implements ToModel
{
    private $sekolah_id, $kelas_id;

    public function __construct($sekolah_id, $kelas_id)
    {
        $this->sekolah_id = $sekolah_id;
        $this->kelas_id = $kelas_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }

        if (!isset($row[1]) || !isset($row[2]) || !isset($row[3]) || !isset($row[4]) || !isset($row[5])) {
            return null;
        }

        if (Siswa::where('nip_nik_nisn', $row[2])->first() != null) {
            return null;
        }

        $password = Str::random(6);

        return new Siswa([
            'nis' => $row[1],
            'nip_nik_nisn' => $row[2],
            'nama' => $row[3],
            'jenis_kelamin' => $row[4],
            'ttl' => $row[5],
            'password' => Hash::make($password),
            'password_view' => $password,
            'sekolah_id' => $this->sekolah_id,
            'kelas_id' => $this->kelas_id,
        ]);
    }
}
