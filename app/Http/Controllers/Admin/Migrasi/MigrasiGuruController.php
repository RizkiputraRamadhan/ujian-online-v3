<?php

namespace App\Http\Controllers\Admin\Migrasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Sekolah;
use Illuminate\Support\Str;

class MigrasiGuruController extends Controller
{
    public function index()
    {
        $data = [
            'sekolah_asal' => Sekolah::all(),
            'sekolah_tujuan' => Sekolah::whereNot('id', @$_GET['sekolah_id'])->get(),
            'guru' => Guru::where('sekolah_id', @$_GET['sekolah_id'])->get(),
        ];
        return \view('admin.migrasi.guru.index', $data)->with('sb', "Migrasi Guru");
    }

    public function migrasiGuru(Request $request)
    {
        if ($request->guru_id == null) {
            return \response()->json([
                'message' => "Checklist minimal satu guru"
            ]);
        } else {
            $sukses = 0;
            foreach ($request->guru_id as $g) {
                $guru = Guru::find($g);
                # Password
                $password = ($request->password_serentak == null) ? Str::random(6) : $request->password_serentak;
                # Cek
                $cekDuplikasi = Guru::where('sekolah_id', $request->sekolah_id)
                    ->where('nip_nik_nisn', $guru?->nip_nik_nisn)
                    ->where('nama', $guru?->nama)
                    ->first();
                if ($cekDuplikasi == null) {
                    # Belum ada
                    Guru::create([
                        'nip_nik_nisn' => $guru?->nip_nik_nisn,
                        'nama' => $guru?->nama,
                        'password' => bcrypt($password),
                        'password_view' => $password,
                        'sekolah_id' => $request->sekolah_id
                    ]);
                    $sukses++;
                }
            }
            $sekolah = Sekolah::find($request->sekolah_id);

            return \response()->json([
                'message' => "$sukses data guru berhasil dicopy ke sekolah " . $sekolah?->nama
            ]);
        }
    }
}
