<?php

namespace App\Http\Controllers\Guru;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Sekolah;
use App\Models\BankSoal;
use App\Models\Settings;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class NilaiController extends Controller
{
    //
    public function index()
    {
        $data = [
            'setting' => Settings::where('id', '1')->first(),
        ];
        return view('guru.nilai.index', $data)->with('sb', "Nilai Ujian");
    }

    public function getmapel(Request $request)
    {
        return DataTables::of(
            Mapel::select('mapel.id', 'mapel.nama_mapel', 'guru.nama', 'tahun_ajaran.tahun')
                ->join('guru', 'guru.id', '=', 'mapel.guru_id')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->where('guru.sekolah_id', $request->session()->get('sekolah_id'))
                ->where('mapel.guru_id', $request->session()->get('id'))
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
                <a href="' . url('guru/nilai/jadwal/' . $m->id) . '" class="badge badge-primary edit">Lihat Jadwal</a>
            ';
            })
            ->rawColumns(['action', 'status_jadwal', 'total_kelas'])
            ->make(true);
    }

    public function detail_view_jadwal(Request $request)
    {
        if (Mapel::where('id', $request->segment(4))->where('guru_id', $request->session()->get('id'))->first() == null) {
            abort(403);
        }

        $data = [
            'mapel' => Mapel::select('mapel.id', 'mapel.nama_mapel', 'mapel.acak_soal', 'mapel.kkm', 'mapel.jumlah_soal', 'mapel.semester', 'guru.nama AS nama_guru', 'sekolah.level', 'sekolah.nama AS nama_sekolah', 'tahun_ajaran.tahun')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->join('guru', 'guru.id', '=', 'mapel.guru_id')
                ->join('sekolah', 'sekolah.id', '=', 'guru.sekolah_id')
                ->where('mapel.id', $request->segment(4))
                ->where('mapel.guru_id', $request->session()->get('id'))
                ->first(),
            'kelas' => Kelas::where('sekolah_id', $request->session()->get('sekolah_id'))->get(),
            'guru' => Guru::where('sekolah_id', $request->session()->get('sekolah_id'))->orderBy('nama', "ASC")->get(),
            'setting' => Settings::where('id', '1')->first(),
        ];

        return view('guru.nilai.detail_jadwal', $data)->with('sb', "Nilai Ujian");
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
                return ($jadwal == null) ? "-" : Carbon::createFromFormat('Y-m-d', $jadwal?->tanggal)->isoFormat('dddd, D MMMM Y');
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
                $jadwal = Jadwal::where('kelas_id', $k->id)->where('mapel_id', request()->get('mapel_id'))->first();

                return ($jadwal != null) ? '<a href="' . url('guru/nilai/view/' . request()->get('mapel_id') . '/' . $jadwal?->id) . '" class="badge badge-primary">Lihat Nilai</a>' : "-";
            })
            ->addColumn('status_jadwal', function (Kelas $k) {
                $jadwal = Jadwal::where('kelas_id', $k->id)->where('mapel_id', request()->get('mapel_id'))->first();
                if ($jadwal == null) {
                    return '-';
                } else {
                    $now = Carbon::now();
                    $mulai = Carbon::parse($jadwal?->tanggal . " " . $jadwal->jam_mulai);
                    $selesai = Carbon::parse($jadwal->tanggal . " " . $jadwal->jam_selesai);
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
                }
            })
            ->rawColumns(['action', 'pengawas', 'lama_ujian', 'mulai_selesai', 'tanggal', 'nama_kelas', 'status_jadwal'])
            ->make(true);
    }

    public function view_hasil_ujian(Request $request)
    {
        $jadwal = Jadwal::where('id', $request->segment(5))->first();

        if (Mapel::where('id', $request->segment(4))->where('guru_id', $request->session()->get('id'))->first() == null) {
            abort(403);
        }

        $data = [
            'jadwal' => Jadwal::select('kelas.jurusan', 'mapel.kkm', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'mapel.nama_mapel', 'tahun_ajaran.tahun', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'guru.nama AS pengawas', 'jadwal.id', 'kelas.id AS kelas_id', 'jadwal.mapel_id')
                ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')
                ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
                ->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->where('jadwal.id', $request->segment(5))
                ->first(),
            'siswa' => Siswa::where('kelas_id', $jadwal?->kelas_id)->orderBy('nis', "ASC")->get()
        ];

        return view('guru.nilai.view_nilai', $data)->with('sb', "Nilai Ujian");
    }

    public function previewUjian(Request $request)
    {
        $jadwal = Jadwal::where('id', $request->segment(5))->first();
        $soal = BankSoal::where('mapel_id', $jadwal?->mapel_id)->get()->toArray();
        $kehadiran = Kehadiran::where('id', $request->segment(8))->first();

        $data = [
            'jadwal' => Jadwal::select('kelas.jurusan', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'mapel.nama_mapel', 'tahun_ajaran.tahun', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'guru.nama AS pengawas', 'jadwal.id')
                ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')
                ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
                ->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id')
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')
                ->where('jadwal.id', $request->segment(5))
                ->first(),
            'siswa' => Siswa::where('id', $kehadiran?->siswa_id)->first(),
            'soal' => $soal,
            'sekolah' => Sekolah::where('id', $request->segment(7))->first(),
            'kehadiran' => $kehadiran,
            'mapel' => Mapel::where('id',  $jadwal?->mapel_id)->first(),
            'setting' => Settings::where('id', '1')->first(),
        ];

        return view('preview.index', $data);
    }
}
