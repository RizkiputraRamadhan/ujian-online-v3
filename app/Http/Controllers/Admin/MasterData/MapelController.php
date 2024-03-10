<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\MapelKelas;
use App\Models\Sekolah;
use Exception;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class MapelController extends Controller
{
    //
    public function index()
    {
        $data = [
            'sekolah' => Sekolah::orderBy('nama', "ASC")->get(),
        ];

        return view('admin.master_data.mapel.index', $data)->with('sb', "Data Mapel");
    }

    public function create_view()
    {
        $data = [
            'sekolah' => Sekolah::select('sekolah.id', 'sekolah.nama', 'tahun_ajaran.tahun', 'sekolah.semester')
                ->join('tahun_ajaran', 'sekolah.tahunajaran_id', '=', 'tahun_ajaran.id')
                ->orderBy('nama', "ASC")
                ->get()
        ];

        return view('admin.master_data.mapel.add', $data)->with('sb', "Data Mapel");
    }

    public function getkelasguru(Request $request)
    {
        return response()->json([
            'guru' => Guru::where('sekolah_id', $request->id)->orderBy('nama', "ASC")->get(),
            'kelas' => Kelas::where('sekolah_id', $request->id)->orderBy('tingkat_kelas', "ASC")->get()
        ], 200);
    }

    public function create(Request $request)
    {
        try {
            $sekolah = Sekolah::where('id', $request->sekolah_id)->first();
            $kode = Str::random(6);

            Mapel::create([
                'nama_mapel' => $request->nama_mapel,
                'kkm' => $request->kkm,
                'jumlah_soal' => $request->jumlah_soal,
                'acak_soal' => $request->acak_soal,
                'umumkan_nilai' => $request->umumkan_nilai,
                'kode' => $kode,
                'semester' => $sekolah?->semester,
                'guru_id' => $request->guru_id,
                'tahunajaran_id' => $sekolah?->tahunajaran_id,
            ]);

            foreach ($request->kelas_id as $kelas) {
                MapelKelas::create([
                    'kelas_id' => $kelas,
                    'mapel_id' => Mapel::where('kode', $kode)->first()?->id
                ]);
            }

            return redirect()->to('admin/master-data/mapel/add')->with('message', "Berhasil menambahkan mapel");
        } catch (Exception $e) {
            return redirect()->to('admin/master-data/mapel/add')->with('message', "Terjadi kesalahan saat menambah mapel");
        }
    }

    public function getall(Request $request)
    {

        if (!empty($request->id)) {
            return DataTables::of(
                Mapel::select('mapel.id', 'tahun_ajaran.tahun', 'mapel.nama_mapel', 'guru.nama', 'mapel.acak_soal', 'mapel.jumlah_soal')
                    ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                    ->join('guru', 'guru.id', '=', 'mapel.guru_id')
                    ->where('guru.sekolah_id', $request->id)
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
                            <li><a class="dropdown-item" href="' . url('admin/master-data/soal/view/' . $m->id . '/' . request()->get('id')) . '">Buat Soal</a></li>
                            <li><a class="dropdown-item" href="' . url('admin/master-data/mapel/update/' . $m->id . '/' . request()->get('id')) . '">Edit</a></li>
                            <li><a data-id="' . $m->id . '" class="dropdown-item hapus" href="#">Hapus</a></li>
                        </ul>
                    </div>
                ';
                })
                ->rawColumns(['action', 'status_soal'])
                ->make(true);
        }
    }

    public function get(Request $request)
    {
        $mapel = Mapel::where('id', $request->segment(5))->first();
        $guru = Guru::where('id', $mapel?->guru_id)->first();

        $data = [
            'sekolah' => Sekolah::select('sekolah.id', 'sekolah.nama', 'tahun_ajaran.tahun', 'sekolah.semester')
                ->join('tahun_ajaran', 'sekolah.tahunajaran_id', '=', 'tahun_ajaran.id')
                ->orderBy('nama', "ASC")
                ->get(),
            'mapel' => Mapel::where('id', $request->segment(5))->get(),
            'guru_selected' => $guru,
            'guru_all' => Guru::where('sekolah_id', $guru?->sekolah_id)->get(),
            'kelas' => Kelas::where('sekolah_id', $guru?->sekolah_id)->get(),
        ];

        return view('admin.master_data.mapel.edit', $data)->with('sb', "Data Mapel");
    }

    public function update(Request $request)
    {
        try {
            $sekolah = Sekolah::where('id', $request->sekolah_id)->first();

            Mapel::where('id', $request->id)->update([
                'nama_mapel' => $request->nama_mapel,
                'kkm' => $request->kkm,
                'jumlah_soal' => $request->jumlah_soal,
                'acak_soal' => $request->acak_soal,
                'umumkan_nilai' => $request->umumkan_nilai,
                'semester' => $sekolah?->semester,
                'guru_id' => $request->guru_id,
                'tahunajaran_id' => $sekolah?->tahunajaran_id,
            ]);

            MapelKelas::where('mapel_id', $request->id)->delete();

            foreach ($request->kelas_id as $kelas) {
                MapelKelas::create([
                    'kelas_id' => $kelas,
                    'mapel_id' => $request->id,
                ]);
            }

            return response()->json([
                'message' => "Data mapel berhasil diupdate",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Terjadi kesalahan saat update data mapel",
            ], 200);
        }
    }

    public function delete(Request $request)
    {
        Mapel::where('id', $request->id)->delete();
        return response()->json([
            'message' => "Data mapel berhasil dihapus",
        ], 200);
    }
}
