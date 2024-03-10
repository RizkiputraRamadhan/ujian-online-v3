<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Jadwal;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $data = [
            'setting' => Settings::where('id', '1')->first(),
        ];
        return view('siswa.dashboard.index', $data);
    }

    public function getjadwal(Request $request)
    {
        return DataTables::of(
            Jadwal::select('jadwal.id', 'mapel.nama_mapel', 'tahun_ajaran.tahun', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'guru.nama AS pengawas', 'jadwal.id')
                ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')
                ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->where('jadwal.kelas_id', $request->session()->get('kelas_id'))
                ->orderBy('tanggal', "ASC")
                ->get()
        )
            ->addIndexColumn()
            ->editColumn('tanggal', function (Jadwal $j) {
                return Carbon::createFromFormat('Y-m-d', $j->tanggal)->isoFormat('dddd, D MMMM Y');
            })
            ->addColumn('mulai_selesai', function (Jadwal $j) {
                return $j?->jam_mulai . " - " . $j?->jam_selesai;
            })
            ->editColumn('pengawas', function (Jadwal $j) {
                return strtoupper($j->pengawas);
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
                return '
                <a href="' . url('siswa/ujian/detail/' . $j->id) . '" class="badge badge-primary edit">Detail</a>
            ';
            })
            ->rawColumns(['action', 'mulai_selesai', 'status_jadwal'])
            ->make(true);
    }
}
