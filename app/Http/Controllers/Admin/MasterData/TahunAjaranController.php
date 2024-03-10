<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Yajra\DataTables\Facades\DataTables;

class TahunAjaranController extends Controller
{
    //
    public function index()
    {
        return view('admin.master_data.tahun_ajaran.index')->with('sb', 'Tahun Ajaran');;
    }

    public function create(Request $request)
    {
        if (TahunAjaran::where('tahun', $request->tahun)->first() != null) {
            return redirect()->to('admin/master-data/tahun-ajaran')->with('message', "Tahun ajaran " . $request->tahun . " sudah ada");
        } else {
            TahunAjaran::create([
                'tahun' => $request->tahun
            ]);
            return redirect()->to('admin/master-data/tahun-ajaran')->with('message', "Tahun ajaran berhasil disimpan");
        }
    }

    public function delete(Request $request)
    {
        TahunAjaran::where('id', $request->id)->delete();
        return response()->json([
            'message' => "Tahun ajaran berhasil dihapus"
        ], 200);
    }

    public function update(Request $request)
    {
        TahunAjaran::where('id', $request->id)->update([
            'tahun' => $request->tahun
        ]);
        return redirect()->to('admin/master-data/tahun-ajaran')->with('message', "Tahun ajaran berhasil diupdate");
    }

    public function getall()
    {
        return DataTables::of(TahunAjaran::orderBy('id', 'desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function (TahunAjaran $th) {
                return '
                    <div class="dropdown d-inline dropleft">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a data-id="' . $th->id . '" class="dropdown-item edit" href="#">Edit</a></li>
                            <li><a data-id="' . $th->id . '" class="dropdown-item hapus" href="#">Hapus</a></li>
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
            TahunAjaran::where('id', $request->id)->first(),
            200
        );
    }
}
