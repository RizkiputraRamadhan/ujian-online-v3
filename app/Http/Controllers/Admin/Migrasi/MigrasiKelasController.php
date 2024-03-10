<?php

namespace App\Http\Controllers\Admin\Migrasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Sekolah;

class MigrasiKelasController extends Controller
{
    public function index()
    {
        $data = [
            'sekolah_asal' => Sekolah::all(),
            'sekolah_tujuan' => Sekolah::whereNot('id', @$_GET['sekolah_id'])->get(),
            'kelas' => Kelas::where('sekolah_id', @$_GET['sekolah_id'])->get(),
        ];
        return \view('admin.migrasi.kelas.index', $data)->with('sb', "Migrasi Kelas");
    }

    public function migrasiKelas(Request $request)
    {
        if ($request->kelas_id == null) {
            return \response()->json([
                'message' => "Checklist minimal satu kelas"
            ]);
        } else {
            $sukses = 0;
            foreach ($request->kelas_id as $k) {
                $kelas = Kelas::find($k);
                # Cek
                $cekDuplikasi = Kelas::where('sekolah_id', $request->sekolah_id)
                    ->where('jurusan', $kelas?->jurusan)
                    ->where('tingkat_kelas', $kelas?->tingkat_kelas)
                    ->where('urusan_kelas', $kelas?->urusan_kelas)
                    ->first();
                if ($cekDuplikasi == null) {
                    # Belum ada
                    Kelas::create([
                        'jurusan' => $kelas?->jurusan,
                        'tingkat_kelas' => $kelas?->tingkat_kelas,
                        'urusan_kelas' => $kelas?->urusan_kelas,
                        'sekolah_id' => $request->sekolah_id
                    ]);
                    $sukses++;
                }
            }
            $sekolah = Sekolah::find($request->sekolah_id);

            return \response()->json([
                'message' => "$sukses data kelas berhasil dicopy ke sekolah " . $sekolah?->nama
            ]);
        }
    }
}
