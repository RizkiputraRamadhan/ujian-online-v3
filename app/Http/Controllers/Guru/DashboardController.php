<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Mapel;
use App\Models\Sekolah;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = [
            'sekolah' => Sekolah::join('tahun_ajaran', 'tahun_ajaran.id', '=', 'sekolah.tahunajaran_id')
                ->where('sekolah.id', $request->session()->get('sekolah_id'))
                ->first(),
            'mapel' => Mapel::where('guru_id', $request->session()->get('id'))->get(),
            'today' => Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->isoFormat('dddd, D MMMM Y')
        ];
        return view('guru.dashboard.index', $data)->with('sb', 'Dashboard');
    }

    public function jadwal_hari_ini()
    {
        return DataTables::of(
            Jadwal::select('sekolah.nama', 'mapel.nama_mapel', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'kelas.jurusan', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'jadwal.id AS jadwal_id', 'kelas_id', 'sekolah.id AS sekolah_id', 'tahun_ajaran.tahun', 'jadwal.id')
                ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')
                ->join('kelas', 'kelas.id', '=', 'jadwal.kelas_id')
                ->join('sekolah', 'sekolah.id', '=', 'kelas.sekolah_id')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->where('jadwal.tanggal', date('Y-m-d'))
                ->where('jadwal.guru_id', session()->get('id'))
                ->orderBy('jadwal.jam_mulai', "ASC")
                ->get()
        )
            ->addIndexColumn()
            ->addColumn('mulai_selesai', function (Jadwal $j) {
                return $j->jam_mulai . " - " . $j->jam_selesai;
            })
            ->addColumn('kelas', function (Jadwal $j) {
                return $j?->tingkat_kelas . " (" . $j?->urusan_kelas . ") JURUSAN " . $j?->jurusan;
            })
            ->addColumn('status_jadwal', function (Jadwal $j) {
                $now = Carbon::now();
                $mulai = Carbon::parse($j->tanggal . " " . $j->jam_mulai);
                $selesai = Carbon::parse($j->tanggal . " " . $j->jam_selesai);
                if ($now->between($mulai, $selesai)) {
                    // Mulai
                    return '<i class="text-success">Berlangsung</i>';
                } else {
                    // Selesai or Belum Mulai
                    if ($selesai->between($now, $mulai)) {
                        return '<i class="text-danger">Selesai</i>';
                    } else {
                        return '<i class="text-primary">Belum Mulai</i>';
                    }
                }
            })
            ->addColumn('action', function (Jadwal $j) {
                $now = Carbon::now();
                $mulai = Carbon::parse($j->tanggal . " " . $j->jam_mulai);
                $selesai = Carbon::parse($j->tanggal . " " . $j->jam_selesai);
                if ($now->between($mulai, $selesai)) {
                    // Mulai
                    return '
                    <a href="' . url('guru/ujian/detail/' . $j->id . '/' . $j->kelas_id) . '" class="badge badge-primary">Awasi Ujian</a>
                    ';
                } else {
                    // Selesai or Belum Mulai
                    if ($selesai->between($now, $mulai)) {
                        return '-';
                    } else {
                        return '-';
                    }
                }
            })
            ->rawColumns(['action', 'mulai_selesai', 'kelas', 'status_jadwal'])
            ->make(true);
    }
}
