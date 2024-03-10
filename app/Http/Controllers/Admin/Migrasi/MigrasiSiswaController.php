<?php

namespace App\Http\Controllers\Admin\Migrasi;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MigrasiSiswaController extends Controller
{
    public function index()
    {
        $data = [
            'sekolah_asal' => Sekolah::all(),
            'sekolah_tujuan' => Sekolah::whereNot('id', @$_GET['sekolah_id'])->get(),
            'kelas' => Kelas::where('sekolah_id', @$_GET['sekolah_id'])->get(),
            'siswa' => Siswa::where('sekolah_id', @$_GET['sekolah_id'])->where('kelas_id', @$_GET['kelas_id'])->get(),
        ];
        return \view('admin.migrasi.siswa.index', $data)->with('sb', "Migrasi Siswa");
    }

    public function migrasiSiswa(Request $request)
    {
        if ($request->siswa_id == null) {
            return \response()->json([
                'message' => "Checklist minimal satu siswa"
            ]);
        } else {
            $sukses = 0;
            foreach ($request->siswa_id as $s) {
                $siswa = Siswa::find($s);
                # Password
                $password = Str::random(6);
                # Cek
                $cekDuplikasi = Siswa::where('sekolah_id', $request->sekolah_tujuan_id)
                    ->where('kelas_id', $request->kelas_tujuan_id)
                    ->where('nis', $siswa?->nis)
                    ->where('nip_nik_nisn', $siswa?->nip_nik_nisn)
                    ->where('nama', $siswa?->nama)
                    ->where('jenis_kelamin', $siswa?->jenis_kelamin)
                    ->where('ttl', $siswa?->ttl)
                    ->first();

                if ($cekDuplikasi == null) {
                    # Belum ada
                    Siswa::create([
                        'sekolah_id' => $request->sekolah_tujuan_id,
                        'kelas_id' => $request->kelas_tujuan_id,
                        'nis' => $siswa->nis,
                        'nip_nik_nisn' => $siswa->nip_nik_nisn,
                        'nama' => $siswa->nama,
                        'jenis_kelamin' => $siswa->jenis_kelamin,
                        'ttl' => $siswa->ttl,
                        'password' => \bcrypt($password),
                        'password_view' => $password,
                    ]);
                    $sukses++;
                }
            }
            $sekolah = Sekolah::find($request->sekolah_tujuan_id);

            return \response()->json([
                'message' => "$sukses data siswa berhasil dicopy ke sekolah " . $sekolah?->nama
            ]);
        }
    }
}
