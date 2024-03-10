<?php

namespace App\Http\Controllers\Guru;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class UjianController extends Controller
{
    //
    public function index()
    {
        $data = [
            'setting' => Settings::where('id', '1')->first(),
        ];
        return view('guru.ujian.index', $data)->with('sb', "Ujian");
    }

    public function getall(Request $request)
    {
        return DataTables::of(
            Jadwal::select('jadwal.id', 'mapel.nama_mapel', 'tahun_ajaran.tahun', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'guru.nama AS pengawas', 'jadwal.id', 'jadwal.kelas_id')
                ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')
                ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->where('jadwal.guru_id', $request->session()->get('id'))
                ->orderBy('jadwal.tanggal', "ASC")
                ->get()
        )
            ->addIndexColumn()
            ->editColumn('tanggal', function (Jadwal $j) {
                return Carbon::createFromFormat('Y-m-d', $j->tanggal)->isoFormat('dddd, D MMMM Y');
            })
            ->addColumn('mulai_selesai', function (Jadwal $j) {
                return $j?->jam_mulai . " - " . $j?->jam_selesai;
            })
            ->addColumn('kelas', function (Jadwal $j) {
                $kelas = Kelas::where('id', $j->kelas_id)->first();
                return "KELAS " . $kelas->tingkat_kelas . " (" . $kelas->urusan_kelas . ") (" . $kelas->jurusan . ")";
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
            ->rawColumns(['action', 'mulai_selesai', 'status_jadwal', 'kelas'])
            ->make(true);
    }

    public function view_ujian(Request $request)
    {
        $jadwal = Jadwal::where('id', $request->segment(4))->where('guru_id', $request->session()->get('id'))->first();

        if ($jadwal == null) {
            abort(403);
        }

        $data = [
            'jadwal' => Jadwal::select('kelas.jurusan', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'mapel.nama_mapel', 'tahun_ajaran.tahun', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'guru.nama AS pengawas', 'jadwal.id')
                ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')
                ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
                ->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->where('jadwal.id', $request->segment(4))
                ->first(),
            'siswa' => Siswa::where('kelas_id', $jadwal?->kelas_id)->orderBy('nis', "ASC")->get(),
            'setting' => Settings::where('id', '1')->first(),
        ];

        return view('guru.ujian.detail', $data)->with('sb', "Ujian");
    }
}
