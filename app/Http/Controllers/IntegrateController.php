<?php

namespace App\Http\Controllers;

use App\Models\BankJawaban;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\MapelKelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class IntegrateController extends Controller
{

    public function getSekolah()
    {
        $data = Sekolah::select('sekolah.id', 'sekolah.nama', 'sekolah.semester', 'tahun_ajaran.tahun')
            ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'sekolah.tahunajaran_id')
            ->orderBy('sekolah.id', 'desc')
            ->get();

        return \response()->json([
            'data' => $data
        ]);
    }

    public function getKelas(Request $request)
    {
        $data = Kelas::where('sekolah_id', $request->sekolah_id)
            ->get()
            ->map(function ($kelas) {
                $kelas['total_mapel'] = count(MapelKelas::where('kelas_id', $kelas['id'])->get());
                return $kelas;
            });

        return \response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function createSiswa(Request $request)
    {
        try {

            if (empty($request->value)) {
                return \response()->json([
                    'message' => "Minimal checklist satu siswa yang akan didaftarkan ke aplikasi CBT"
                ], Response::HTTP_BAD_REQUEST);
            }

            for ($i = 0; $i < \count($request->value); $i++) {
                $value = \explode('*', $request->value[$i]);
                $nisn = $value[0]; // nisn atau nik
                $nama = $value[1]; // nama
                $jenisKelamin = $value[2]; // jenis kelamin
                $ttl = $value[3]; // ttl

                $password = Str::random(6);

                Siswa::create([
                    'sekolah_id' => $request->sekolah_id,
                    'kelas_id' => $request->kelas_id,
                    'nis' => "-",
                    'nip_nik_nisn' => $nisn,
                    'nama' => $nama,
                    'jenis_kelamin' => ($jenisKelamin == "LAKI_LAKI") ? "L" : "P",
                    'ttl' => $ttl,
                    'password' => Hash::make($password),
                    'password_view' => $password,
                ]);
            }

            return \response()->json([
                'message' => "$i akun siswa berhasil didaftarkan kedalam aplikasi CBT"
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return \response()->json([
                'message' => "Ada NISN Sudah Digunakan : " . $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getStatusCBT(Request $request)
    {
        try {
            $result = array();
            foreach ($request->nik as $nik) {
                $siswa = Siswa::where('nip_nik_nisn', $nik)->first();
                $result[] = [
                    'nik' => $nik,
                    'akun_cbt' => $siswa == null ? false : true,
                    'status_ujian' => BankJawaban::getStatusUjianIntegrate($siswa?->id),
                    'nilai' => BankJawaban::getNilaiCBTIntegrate($siswa?->id),
                ];
            }
            return \response()->json([
                'data' => $result
            ]);
        } catch (Exception $e) {
            return \response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getDetailCbt(Request $request)
    {
        $siswa = Siswa::where('nip_nik_nisn', $request->nik)->first();
        $kelas = Kelas::find($siswa?->kelas_id);
        $data = [
            'nik_siswa' => $siswa?->nip_nik_nisn,
            'nama_siswa' => $siswa?->nama,
            'password' => $siswa?->password_view,
            'sekolah' => Sekolah::find($siswa?->sekolah_id)?->nama,
            'kelas' => ucfirst(str_replace('_', ' ', "Kelas $kelas?->tingkat_kelas ( $kelas?->urusan_kelas ) ( Jurusan $kelas?->jurusan )")),
            'rata_rata_nilai' => BankJawaban::getNilaiCBTIntegrate($siswa?->id),
            'ujian' => BankJawaban::getStatusUjianIntegrateBySiswa($siswa?->id)
        ];

        return response()->json([
            'data' => $data
        ]);
    }

    public function deleteAkunSiswa(Request $request)
    {
        Siswa::where('nip_nik_nisn', $request->nik)->delete();
        return response()->json([
            'message' => "Akun CBT Siswa Berhasil Dihapus"
        ]);
    }
}
