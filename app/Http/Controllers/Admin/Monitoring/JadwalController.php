<?php

namespace App\Http\Controllers\Admin\Monitoring;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use Exception;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class JadwalController extends Controller
{
    //
    public function index()
    {
        $data = [
            'sekolah' => Sekolah::orderBy('nama', "ASC")->get(),
            'tahun' => TahunAjaran::orderBy('tahun', "DESC")->get(),
        ];
        return view('admin.monitoring.jadwal.index', $data)->with('sb', "Jadwal");
    }

    public function getall(Request $request)
    {
        if (!empty($request->s) && !empty($request->ta)) {
            return DataTables::of(
                Mapel::select('mapel.id', 'mapel.nama_mapel', 'guru.nama')
                    ->join('guru', 'guru.id', '=', 'mapel.guru_id')
                    ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                    ->where('guru.sekolah_id', $request->s)
                    ->where('mapel.tahunajaran_id', $request->ta)
                    ->orderBy('tahun_ajaran.tahun', "DESC")
                    ->get()
            )
                ->addIndexColumn()
                ->addColumn('status_jadwal', function (Mapel $m) {
                    $jadwal_inserted = Jadwal::where('mapel_id', $m->id)->get();
                    $jadwal_total = Mapel::select('mapel.id')->join('mapel_kelas', 'mapel_kelas.mapel_id', '=', 'mapel.id')->where('mapel.id', $m->id)->get();
                    return (count($jadwal_inserted) == count($jadwal_total)) ? '<i class="text-success">Lengkap</i>' : '<i class="text-danger">Belum Lengkap</i>';
                })
                ->addColumn('total_kelas', function (Mapel $m) {
                    $jadwal_total = Mapel::select('mapel.id')->join('mapel_kelas', 'mapel_kelas.mapel_id', '=', 'mapel.id')->where('mapel.id', $m->id)->get();
                    return count($jadwal_total) . " Kelas";
                })
                ->addColumn('action', function (Mapel $m) {
                    return '
                    <a href="' . url('admin/monitoring/jadwal/setting/' . $m->id . '/' . request()->get('s') . '/' . request()->get('ta')) . '" class="badge badge-primary edit">Lihat Jadwal</a>
                ';
                })
                ->rawColumns(['action', 'status_jadwal', 'total_kelas'])
                ->make(true);
        }
    }

    public function create_view(Request $request)
    {
        $data = [
            'mapel' => Mapel::select('mapel.id', 'mapel.nama_mapel', 'mapel.acak_soal', 'mapel.kkm', 'mapel.jumlah_soal', 'mapel.semester', 'guru.nama AS nama_guru', 'sekolah.level', 'sekolah.nama AS nama_sekolah', 'tahun_ajaran.tahun')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->join('guru', 'guru.id', '=', 'mapel.guru_id')
                ->join('sekolah', 'sekolah.id', '=', 'guru.sekolah_id')
                ->where('mapel.id', $request->segment(5))
                ->first(),
            'kelas' => Kelas::where('sekolah_id', $request->segment(6))->get(),
            'guru' => Guru::where('sekolah_id', $request->segment(6))->orderBy('nama', "ASC")->get()
        ];

        return view('admin.monitoring.jadwal.add', $data)->with('sb', "Jadwal");
    }

    public function detail_jadwal(Request $request)
    {
        return DataTables::of(
            Kelas::select('kelas.jurusan', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'kelas.id')
                ->join('mapel_kelas', 'mapel_kelas.kelas_id', '=', 'kelas.id')
                ->where('mapel_kelas.mapel_id', $request->get('mapel_id'))
                ->get()
        )
            ->addIndexColumn()
            ->addColumn('nama_kelas', function (Kelas $k) {
                return "KELAS " . $k->tingkat_kelas . " (" . $k->urusan_kelas . ") (" . $k->jurusan . ")";
            })
            ->addColumn('tanggal', function (Kelas $k) {
                $jadwal = Jadwal::where('kelas_id', $k->id)->where('mapel_id', request()->get('mapel_id'))->first();
                return ($jadwal == null) ? "-" : Carbon::createFromFormat('Y-m-d', $jadwal?->tanggal)->isoFormat('D MMMM Y');
            })
            ->addColumn('mulai_selesai', function (Kelas $k) {
                $jadwal = Jadwal::where('kelas_id', $k->id)->where('mapel_id', request()->get('mapel_id'))->first();
                return ($jadwal == null) ? "-" : $jadwal?->jam_mulai . " - " . $jadwal?->jam_selesai;
            })
            ->addColumn('lama_ujian', function (Kelas $k) {
                $jadwal = Jadwal::where('kelas_id', $k->id)->where('mapel_id', request()->get('mapel_id'))->first();
                return ($jadwal == null) ? "-" : $jadwal->lama_ujian . " Menit";
            })
            ->addColumn('pengawas', function (Kelas $k) {
                $jadwal = Jadwal::select('guru.nama')
                    ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
                    ->where('kelas_id', $k->id)
                    ->where('mapel_id', request()->get('mapel_id'))
                    ->first();
                return ($jadwal == null) ? "-" : $jadwal?->nama;
            })
            ->addColumn('action', function (Kelas $k) {
                $kelas = "KELAS " . $k->tingkat_kelas . " (" . $k->urusan_kelas . ") (" . $k->jurusan . ")";
                return '
                <a href="#" data-kelas_name="' . $kelas . '" data-kelas_id="' . $k->id . '" data-mapel_id="' . request()->get('mapel_id') . '" class="badge badge-primary edit">Atur Jadwal</a>
            ';
            })
            ->rawColumns(['action', 'pengawas', 'lama_ujian', 'mulai_selesai', 'tanggal', 'nama_kelas'])
            ->make(true);
    }

    public function get_detail_jadwal(Request $request)
    {
        return response()->json([
            'data' => Jadwal::where('kelas_id', $request->kelas_id)->where('mapel_id', $request->mapel_id)->first(),
        ], 200);
    }

    public function create_or_update(Request $request)
    {
        try {

            if (strtotime($request->jam_mulai) > strtotime($request->jam_selesai)) {
                return response()->json([
                    'message' => "Jam mulai dan jam selesai ujian tidak valid"
                ], 400);
            } else {
                $start = Carbon::createFromFormat('H:i', $request->jam_mulai);
                $finish = Carbon::createFromFormat('H:i', $request->jam_selesai);
                $diff = $start->diffInMinutes($finish);

                $jadwal = Jadwal::where('kelas_id', $request->kelas_id)->where('mapel_id', $request->mapel_id)->first();

                if ($jadwal == null) {
                    Jadwal::create([
                        'tanggal' => $request->tanggal,
                        'jam_mulai' => $request->jam_mulai,
                        'jam_selesai' => $request->jam_selesai,
                        'guru_id' => $request->guru_id,
                        'kelas_id' => $request->kelas_id,
                        'mapel_id' => $request->mapel_id,
                        'lama_ujian' => $diff,
                    ]);
                } else {
                    Jadwal::where('id', $jadwal?->id)->update([
                        'tanggal' => $request->tanggal,
                        'jam_mulai' => $request->jam_mulai,
                        'jam_selesai' => $request->jam_selesai,
                        'guru_id' => $request->guru_id,
                        'kelas_id' => $request->kelas_id,
                        'mapel_id' => $request->mapel_id,
                        'lama_ujian' => $diff,
                    ]);
                }
                return response()->json([
                    'message' => "Jadwal berhasil disimpan",
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => "Terjadi kesalahan sistem saat membuat jadwal ujian"
            ], 400);
        }
    }
}
