<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

use function PHPSTORM_META\map;

class SiswaController extends Controller
{
    //
    public function index()
    {
        $data = [
            'sekolah' => Sekolah::orderBy('nama', "ASC")->get(),
        ];
        return view('admin.master_data.siswa.index', $data)->with('sb', "Data Siswa");
    }

    public function getkelas(Request $request)
    {
        return response()->json(
            Kelas::where('sekolah_id', $request->id)->get(),
            200
        );
    }

    public function create(Request $request)
    {
        if (Siswa::where('nip_nik_nisn', $request->nip_nik_nisn)->first() != null) {
            return response()->json([
                'message' => "NISN telah digunakan"
            ], 200);
        } else {

            $password = Str::random(6);

            Siswa::create([
                'sekolah_id' => $request->sekolah_id,
                'kelas_id' => $request->kelas_id,
                'nis' => $request->nis,
                'nip_nik_nisn' => $request->nip_nik_nisn,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'ttl' => $request->ttl,
                'password' => Hash::make($password),
                'password_view' => $password,
            ]);

            return response()->json([
                'message' => "Data siswa berhasil disimpan"
            ], 200);
        }
    }

    public function getall(Request $request)
    {
        return DataTables::of(
            Siswa::select('siswa.id', 'siswa.nip_nik_nisn', 'siswa.nis', 'siswa.nama', 'siswa.password_view', 'kelas.tingkat_kelas', 'sekolah.nama AS sekolah_name')
                ->join('sekolah', 'sekolah.id', '=', 'siswa.sekolah_id')
                ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
                ->where('kelas.id', $request->id)
                ->orderBy('siswa.nama', "ASC")
                ->get()
        )
            ->addIndexColumn()
            ->addColumn('action', function (Siswa $s) {
                return '
            <div class="dropdown d-inline dropleft">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu">
                    <li><a data-id="' . $s->id . '" class="dropdown-item edit" href="#">Edit</a></li>
                    <li><a data-id="' . $s->id . '" class="dropdown-item hapus" href="#">Hapus</a></li>
                </ul>
            </div>
        ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function get(Request $request)
    {
        return response()->json(
            Siswa::where('id', $request->id)->first(),
            200
        );
    }

    public function update(Request $request)
    {
        Siswa::where('id', $request->id)->update([
            'sekolah_id' => $request->sekolah_id,
            'kelas_id' => $request->kelas_id,
            'nis' => $request->nis,
            'nip_nik_nisn' => $request->nip_nik_nisn,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ttl' => $request->ttl,
            'password' => Hash::make($request->password),
            'password_view' => $request->password,
        ]);

        return response()->json([
            'message' => "Data siswa berhasil diupdate"
        ], 200);
    }

    public function delete(Request $request)
    {
        Siswa::where('id', $request->id)->delete();
        return response()->json([
            'message' => "Data siswa berhasil dihapus"
        ], 200);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "Ekstensi file salah"
            ], 200);
        } else {
            try {
                Excel::import(new SiswaImport($request->sekolah_id, $request->kelas_id), $request->file('file'));
                return response()->json([
                    'message' => "Import data siswa berhasil"
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'message' => "Terjadi kesalahan saat import data"
                ], 200);
            }
        }
    }
}
