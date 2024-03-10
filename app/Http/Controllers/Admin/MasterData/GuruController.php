<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Models\Sekolah;
use App\Models\Guru;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    //
    public function index()
    {
        $data = [
            'sekolah' => Sekolah::orderBy('nama', "ASC")->get(),
        ];
        return view('admin.master_data.guru.index', $data)->with('sb', "Data Guru");
    }

    public function create(Request $request)
    {

        if (Guru::where('nip_nik_nisn', $request->nip_nik_nisn)->first() != null) {
            return redirect()->to('admin/master-data/guru')->with('message', "NIP/NIK telah digunakan");
        } else {
            Guru::create([
                'nip_nik_nisn' => $request->nip_nik_nisn,
                'nama' => $request->nama,
                'password_view' => $request->password,
                'password' => Hash::make($request->password),
                'sekolah_id' => $request->sekolah_id
            ]);
            return redirect()->to('admin/master-data/guru')->with('message', "Data Guru Berhasil Disimpan");
        }
    }

    public function update(Request $request)
    {
        Guru::where('id', $request->id)->update([
            'nip_nik_nisn' => $request->nip_nik_nisn,
            'nama' => $request->nama,
            'password_view' => $request->password,
            'password' => Hash::make($request->password),
            'sekolah_id' => $request->sekolah_id,
        ]);
        return redirect()->to('admin/master-data/guru')->with('message', "Data guru berhasil diupdate");
    }

    public function delete(Request $request)
    {
        Guru::where('id', $request->id)->delete();
        return response()->json([
            'message' => "Data guru berhasil dihapus",
        ], 200);
    }

    public function get(Request $request)
    {
        return response()->json(
            Guru::where('id', $request->id)->first(),
            200
        );
    }

    public function getall(Request $request)
    {
        if (!empty($request->id)) {
            $query = Guru::select("nip_nik_nisn", "guru.nama", "guru.id", "sekolah.nama AS sekolah_name", "guru.password_view")
                ->join('sekolah', 'sekolah.id', 'guru.sekolah_id')
                ->where('guru.sekolah_id', $request->id)
                ->orderBy('sekolah_name', "ASC")
                ->get();
        } else {
            $query = Guru::select("nip_nik_nisn", "guru.nama", "guru.id", "sekolah.nama AS sekolah_name", "guru.password_view")
                ->join('sekolah', 'sekolah.id', 'guru.sekolah_id')
                ->orderBy('sekolah_name', "ASC")
                ->get();
        }

        return DataTables::of(
            $query
        )
            ->addIndexColumn()
            ->addColumn('action', function (Guru $g) {
                return '
            <div class="dropdown d-inline dropleft">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu">
                    <li><a data-id="' . $g->id . '" class="dropdown-item edit" href="#">Edit</a></li>
                    <li><a data-id="' . $g->id . '" class="dropdown-item hapus" href="#">Hapus</a></li>
                </ul>
            </div>
        ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            return redirect()->to('admin/master-data/guru')->with('message', "Ekstensi file salah");
        } else {
            try {
                Excel::import(new GuruImport($request->sekolah_id), $request->file('file'));
                return redirect()->to('admin/master-data/guru')->with('message', "Import data guru berhasil");
            } catch (Exception $e) {
                return redirect()->to('admin/master-data/guru')->with('message', "Terjadi kesalahan saat import data");
            }
        }
    }
}
