<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $data = [
            'sekolah' => Sekolah::all(),
            'guru' => Guru::all(),
            'kelas' => Kelas::all(),
            'mapel' => Mapel::all(),
            'today' => Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->isoFormat('dddd, D MMMM Y')
        ];
        return view('admin.dashboard.index', $data)->with('sb', 'Dashboard');
    }

    public function master_data()
    {
        return DataTables::of(
            Sekolah::orderBy('nama', 'ASC')->get()
        )
            ->addIndexColumn()
            ->addColumn('total_guru', function (Sekolah $s) {
                return count(Guru::where('sekolah_id', $s->id)->get());
            })
            ->addColumn('total_siswa', function (Sekolah $s) {
                return count(Siswa::where('sekolah_id', $s->id)->get());
            })
            ->addColumn('total_kelas', function (Sekolah $s) {
                return count(Kelas::where('sekolah_id', $s->id)->get());
            })
            ->rawColumns(['total_guru', 'total_siswa', 'total_kelas'])
            ->make(true);
    }

    public function jadwal_hari_ini()
    {
        return DataTables::of(
            Jadwal::select('sekolah.nama', 'mapel.nama_mapel', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'kelas.jurusan', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'jadwal.id AS jadwal_id', 'kelas.id AS kelas_id', 'sekolah.id AS sekolah_id')
                ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')
                ->join('kelas', 'kelas.id', '=', 'jadwal.kelas_id')
                ->join('sekolah', 'sekolah.id', '=', 'kelas.sekolah_id')
                ->where('jadwal.tanggal', date('Y-m-d'))
                ->orderBy('sekolah.nama', "ASC")
                ->get()
        )
            ->addIndexColumn()
            ->addColumn('mulai_selesai', function (Jadwal $j) {
                return $j->jam_mulai . " - " . $j->jam_selesai;
            })
            ->addColumn('kelas', function (Jadwal $j) {
                return $j?->tingkat_kelas . " (" . $j?->urusan_kelas . ") JURUSAN " . $j?->jurusan;
            })
            ->addColumn('action', function (Jadwal $j) {
                return '
                <a href="' . url('admin/monitoring/ujian/detail/' . $j->jadwal_id . '/' . $j->kelas_id . '/' . $j->sekolah_id) . '" class="badge badge-primary">Lihat Ujian</a>
            ';
            })
            ->rawColumns(['action', 'mulai_selesai', 'kelas'])
            ->make(true);
    }
}
