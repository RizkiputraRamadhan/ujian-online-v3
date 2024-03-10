<?php

namespace App\Http\Controllers\Admin\Migrasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Sekolah;
use Illuminate\Support\Str;

class MigrasiMapelController extends Controller
{
    public function index()
    {
        $data = [
            'sekolah_asal' => Sekolah::all(),
            'sekolah_tujuan' => Sekolah::whereNot('id', @$_GET['sekolah_id'])->get(),
            'mapel' => Mapel::where('guru_id', @$_GET['guru_id'])->get(),
            'guru_asal' => Guru::where('sekolah_id', @$_GET['sekolah_id'])->get(),
        ];
        return \view('admin.migrasi.mapel.index', $data)->with('sb', "Migrasi Mapel");
    }

    public function migrasiMapel(Request $request)
    {
        if ($request->mapel_id == null) {
            return \response()->json([
                'message' => "Checklist minimal satu mapel"
            ]);
        } else {
            $sukses = 0;
            foreach ($request->mapel_id as $m) {
                $mapel = Mapel::find($m);
                # Kode
                $kode = Str::random(6);
                $sekolah = Sekolah::find($request->sekolah_tujuan_id);
                # Cek
                $cekDuplikasi = Mapel::where('guru_id', $request->guru_tujuan_id)
                    ->where('nama_mapel', $mapel?->nama_mapel)
                    ->where('kkm', $mapel?->kkm)
                    ->where('jumlah_soal', $mapel?->jumlah_soal)
                    ->where('acak_soal', $mapel?->acak_soal)
                    ->where('umumkan_nilai', $mapel?->umumkan_nilai)
                    ->first();

                if ($cekDuplikasi == null) {
                    # Belum ada
                    Mapel::create([
                        'nama_mapel' => $mapel?->nama_mapel,
                        'kkm' => $mapel?->kkm,
                        'jumlah_soal' => $mapel?->jumlah_soal,
                        'acak_soal' => $mapel?->acak_soal,
                        'umumkan_nilai' => $mapel?->umumkan_nilai,
                        'kode' => $kode,
                        'semester' => $sekolah?->semester,
                        'guru_id' => $request->guru_tujuan_id,
                        'tahunajaran_id' => $sekolah?->tahunajaran_id,
                    ]);
                    $sukses++;
                }
            }

            return \response()->json([
                'message' => "$sukses data mapel berhasil dicopy ke sekolah " . $sekolah?->nama
            ]);
        }
    }
}
