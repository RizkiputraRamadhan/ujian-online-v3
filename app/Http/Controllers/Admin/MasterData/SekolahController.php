<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class SekolahController extends Controller
{
    //
    public function index()
    {
        return view('admin.master_data.sekolah.index')->with('sb', "Data Sekolah");
    }

    public function getall()
    {
        return DataTables::of(
            Sekolah::select('sekolah.id', 'sekolah.nama', 'sekolah.semester', 'tahun_ajaran.tahun')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'sekolah.tahunajaran_id')
                ->orderBy('sekolah.id', 'desc')
                ->get()
        )
            ->addIndexColumn()
            ->addColumn('action', function (Sekolah $s) {
                return '
                <div class="dropdown d-inline dropleft">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item edit" href="' . url('admin/master-data/sekolah/update/' . $s->id) . '">Edit</a></li>
                        <li><a data-id="' . $s->id . '" class="dropdown-item hapus" href="#">Hapus</a></li>
                    </ul>
                </div>
            ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_view()
    {
        $data = [
            'tahun_ajaran' => TahunAjaran::orderby('id', "DESC")->get()
        ];
        return view('admin.master_data.sekolah.add', $data)->with('sb', "Data Sekolah");
    }

    public function create(Request $request)
    {
        try {

            Sekolah::create([
                'instansi' => $request->instansi,
                'nama' => $request->nama,
                'level' => $request->level,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nip_kamad' => $request->nip_kamad,
                'nama_kamad' => $request->nama_kamad,
                'semester' => $request->semester,
                'tahunajaran_id' => $request->tahunajaran_id
            ]);

            return redirect()->to('admin/master-data/sekolah/add')->with('message', "Data sekolah berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->to('admin/master-data/sekolah/add')->with('message', "Terjadi exception pada server " . $e->getMessage());
        }
    }

    public function get(Request $request)
    {
        $data = [
            'sekolah' => Sekolah::where('id', $request->segment(5))->get(),
            'tahun_ajaran' => TahunAjaran::orderby('id', "DESC")->get()
        ];
        return view('admin.master_data.sekolah.edit', $data)->with('sb', "Data Sekolah");
    }

    public function update(Request $request)
    {
        try {

            Sekolah::where('id', $request->id)->update([
                'instansi' => $request->instansi,
                'nama' => $request->nama,
                'level' => $request->level,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nip_kamad' => $request->nip_kamad,
                'nama_kamad' => $request->nama_kamad,
                'semester' => $request->semester,
                'tahunajaran_id' => $request->tahunajaran_id
            ]);

            return redirect()->to('admin/master-data/sekolah/update/' . $request->id)->with('message', "Data sekolah berhasil diupdate");
        } catch (Exception $e) {
            return redirect()->to('admin/master-data/sekolah/update/' . $request->id)->with('message', "Terjadi exception pada server " . $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            Sekolah::where('id', $request->id)->delete();
            return response()->json([
                'message' => "Data sekolah berhasil dihapus"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Ups terdapat data MAPEL pada sekolah ini, hapus Mapel disekolah ini dahulu baru anda dapat menghapus sekolah ini."
            ], 200);
        }
    }
}
