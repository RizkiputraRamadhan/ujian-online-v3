<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Sekolah;
use App\Models\Settings;
use Yajra\DataTables\Facades\DataTables;

class MapelController extends Controller
{
    //
    public function index()
    {

        return view('guru.mapel.index')->with('sb', "Data Mapel");
    }

    public function getall(Request $request)
    {

        return DataTables::of(
            Mapel::select('mapel.id', 'tahun_ajaran.tahun', 'mapel.nama_mapel', 'guru.nama', 'mapel.acak_soal', 'mapel.jumlah_soal')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->join('guru', 'guru.id', '=', 'mapel.guru_id')
                ->where('guru.sekolah_id', $request->session()->get('sekolah_id'))
                ->where('mapel.guru_id', $request->session()->get('id'))
                ->orderBy('tahun_ajaran.tahun', "DESC")
                ->get()
        )
            ->addIndexColumn()
            ->editColumn('acak_soal', function (Mapel $m) {
                return ($m->acak_soal == "Y") ? "ACAK" : "TIDAK ACAK";
            })
            ->addColumn('status_soal', function (Mapel $m) {
                $query = BankSoal::where('mapel_id', $m->id)->get();
                return (count($query) == $m->jumlah_soal) ? '<i class="text-success">Lengkap</i>' : '<i class="text-danger">Belum Lengkap</i>';
            })
            ->addColumn('action', function (Mapel $m) {
                return '
                <div class="dropdown d-inline dropleft">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . url('guru/soal/view/' . $m->id) . '">Buat Soal</a></li>
                        <li><a class="dropdown-item" href="' . url('guru/mapel/detail/' . $m->id) . '">Detail Mapel</a></li>
                    </ul>
                </div>
            ';
            })
            ->rawColumns(['action', 'status_soal'])
            ->make(true);
    }

    public function get(Request $request)
    {
        $guru = Guru::where('id', $request->session()->get('id'))->first();
        $data = [
            'sekolah' => Sekolah::select('sekolah.id', 'sekolah.nama', 'tahun_ajaran.tahun', 'sekolah.semester')
                ->join('tahun_ajaran', 'sekolah.tahunajaran_id', '=', 'tahun_ajaran.id')
                ->orderBy('nama', "ASC")
                ->get(),
            'mapel' => Mapel::where('id', $request->segment(4))->where('guru_id', $request->session()->get('id'))->get(),
            'guru_selected' => $guru,
            'guru_all' => Guru::where('sekolah_id', $guru?->sekolah_id)->get(),
            'kelas' => Kelas::where('sekolah_id', $guru?->sekolah_id)->get(),
            'setting' => Settings::where('id', '1')->first(),
        ];

        return view('guru.mapel.detail', $data)->with('sb', "Data Mapel");
    }
}
