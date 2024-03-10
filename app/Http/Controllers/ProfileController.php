<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    public function updateAdmin(Request $request)
    {
        if (
            Guru::where('nip_nik_nisn', $request->nip_nik_nisn)->first() != null ||
            Siswa::where('nip_nik_nisn', $request->nip_nik_nisn)->first() != null
        ) {
            return response()->json([
                'message' => "Silahkan ganti NIP/NIK dengan yang lain"
            ], 400);
        } else {
            if (!empty($request->password)) {
                Admin::where('id', $request->id)->update([
                    'password' => Hash::make($request->password)
                ]);
            }

            Admin::where('id', $request->id)->update([
                'nip_nik_nisn' => $request->nip_nik_nisn,
                'nama' => $request->nama
            ]);

            return response()->json([
                'message' => "Data profile berhasil diupdate, silahkan keluar akun dahulu untuk melihat efeknya"
            ], 200);
        }
    }

    public function updateGuru(Request $request)
    {
        if (!empty($request->password)) {
            Guru::where('id', $request->id)->update([
                'password' => Hash::make($request->password),
                'password_view' => $request->guru
            ]);
        }

        return response()->json([
            'message' => "Data profile berhasil diupdate, silahkan keluar akun dahulu untuk melihat efeknya"
        ], 200);
    }

    public function profileSiswa(Request $request)
    {
        $data = [
            'siswa' => Siswa::where('id', $request->session()->get('id'))->first(),
            'kelas' => Kelas::where('id', $request->session()->get('kelas_id'))->first(),
            'sekolah' => Sekolah::where('id', $request->session()->get('sekolah_id'))->first()
        ];

        return view('siswa.profile.index', $data);
    }
}
