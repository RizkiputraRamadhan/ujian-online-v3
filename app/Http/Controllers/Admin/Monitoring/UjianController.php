<?php

namespace App\Http\Controllers\Admin\Monitoring;

use Exception;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Sekolah;
use App\Models\BankSoal;
use App\Models\Settings;
use App\Models\Kehadiran;
use App\Models\Notifikasi;
use App\Models\BankJawaban;
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
            'sekolah' => Sekolah::orderBy('nama', 'ASC')->get(),
        ];

        return view('admin.monitoring.ujian.index', $data)->with('sb', 'Ujian');
    }

    public function getall(Request $request)
    {
        if (!empty($request->get('s')) && !empty($request->get('k'))) {
            return DataTables::of(Jadwal::select('jadwal.id', 'mapel.nama_mapel', 'tahun_ajaran.tahun', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'guru.nama AS pengawas', 'jadwal.id')->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')->join('guru', 'guru.id', '=', 'jadwal.guru_id')->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')->where('jadwal.kelas_id', $request->get('k'))->orderBy('tanggal', 'ASC')->get())
                ->addIndexColumn()
                ->editColumn('tanggal', function (Jadwal $j) {
                    return Carbon::createFromFormat('Y-m-d', $j->tanggal)->isoFormat('dddd, D MMMM Y');
                })
                ->addColumn('mulai_selesai', function (Jadwal $j) {
                    return $j?->jam_mulai . ' - ' . $j?->jam_selesai;
                })
                ->editColumn('pengawas', function (Jadwal $j) {
                    return strtoupper($j->pengawas);
                })
                ->addColumn('status_jadwal', function (Jadwal $j) {
                    $now = Carbon::now();
                    $mulai = Carbon::parse($j->tanggal . ' ' . $j->jam_mulai);
                    $selesai = Carbon::parse($j->tanggal . ' ' . $j->jam_selesai);
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
                    return '
                    <a href="' .
                        url('admin/monitoring/ujian/detail/' . $j->id . '/' . request()->get('k') . '/' . request()->get('s')) .
                        '" class="badge badge-primary edit">Atur Ujian</a>
                ';
                })
                ->rawColumns(['action', 'mulai_selesai', 'status_jadwal'])
                ->make(true);
        }
    }

    public function view_ujian(Request $request)
    {

        $jadwal = Jadwal::where('id', $request->segment(5))->first();

        $data = [
            'notifikasi' => Notifikasi::orderBy('id', 'desc')->get(),
            'setting' => Settings::orderBy('id', 'desc')->first(),
            'jadwal' => Jadwal::select('kelas.jurusan', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'mapel.nama_mapel', 'tahun_ajaran.tahun', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'guru.nama AS pengawas', 'jadwal.id', 'mapel.id AS mapel_id')->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')->join('guru', 'guru.id', '=', 'jadwal.guru_id')->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id')->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')->where('jadwal.id', $request->segment(5))->first(),
            'siswa' => Siswa::where('kelas_id', $jadwal?->kelas_id)
                ->orderBy('nis', 'ASC')
                ->get(),
        ];
        return view('admin.monitoring.ujian.detail', $data)->with('sb', 'Ujian');
    }

    public function create_or_update_kehadiran(Request $request)
    {
        try {
            if ($request->siswa_id == null) {
                return response()->json(
                    [
                        'message' => 'Checklist minimal satu siswa',
                    ],
                    400,
                );
            } else {
                foreach ($request->siswa_id as $s) {
                    if (Kehadiran::get($request->jadwal_id, $s) == null) {
                        // Create
                        Kehadiran::create([
                            'no_peserta' => mt_rand(10000, 99999),
                            'status_kehadiran' => $request->status_kehadiran,
                            'status_ujian' => 'BELUM_DIMULAI',
                            'status_blokir' => 'N',
                            'kelas_id' => $request->kelas_id,
                            'jadwal_id' => $request->jadwal_id,
                            'siswa_id' => $s,
                        ]);
                    } else {
                        // Update
                        Kehadiran::where('siswa_id', $s)
                            ->where('jadwal_id', $request->jadwal_id)
                            ->update([
                                'status_kehadiran' => $request->status_kehadiran,
                            ]);
                    }
                }

                return response()->json(
                    [
                        'message' => count($request->siswa_id) . ' siswa telah diatur kehadirannya',
                    ],
                    200,
                );
            }
        } catch (Exception $e) {
            return response()->json(
                [
                    'message' => "Terjadi kesalahan di sisi server aplikasi $e",
                ],
                400,
            );
        }
    }

    public function blokir(Request $request)
    {
        $siswa = Siswa::where('id', $request->id)->first();
        Kehadiran::where('id', $request->id)->update([
            'status_blokir' => $request->status_blokir,
        ]);

        Notifikasi::create([
            'informasi' => 'Melanggar peraturan ujian',
            'siswa_id' => $request->id,
            'nama' => $siswa->nama,
        ]);

        return redirect('/siswa')->with('blokir', 'Anda diblokir karna melanggar peraturah diatas !!');
    }

    public function update_status_blokir_ujian(Request $request)
    {
        //dd($request->all());
        Kehadiran::where('id', $request->id)->update([
            'status_blokir' => $request->status_blokir,
        ]);
        $siswa = Kehadiran::where('id', $request->id)->first();
        if ($request->status_blokir === 'N') {
            Notifikasi::where('siswa_id', $siswa->siswa_id)->delete();
        }
                return response()->json(
            [
                'message' => 'Status blokir peserta ujian diperbaruhi',
            ],
            200,
        );
    }

    public function reset_ujian(Request $request)
    {
        BankJawaban::where('kehadiran_id', $request->id)->delete();
        Kehadiran::where('id', $request->id)->update([
            'status_ujian' => 'BELUM_DIMULAI',
        ]);
        return response()->json(
            [
                'message' => 'Jawaban ujian berhasil direset',
            ],
            200,
        );
    }

    public function previewUjian(Request $request)
    {
        $jadwal = Jadwal::where('id', $request->segment(5))->first();
        $soal = BankSoal::where('mapel_id', $jadwal?->mapel_id)
            ->get()
            ->toArray();
        $kehadiran = Kehadiran::where('id', $request->segment(8))->first();

        $data = [
            'jadwal' => Jadwal::select('kelas.jurusan', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'mapel.nama_mapel', 'tahun_ajaran.tahun', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'guru.nama AS pengawas', 'jadwal.id')->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')->join('guru', 'guru.id', '=', 'jadwal.guru_id')->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id')->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')->where('jadwal.id', $request->segment(5))->first(),
            'siswa' => Siswa::where('id', $kehadiran?->siswa_id)->first(),
            'soal' => $soal,
            'sekolah' => Sekolah::where('id', $request->segment(7))->first(),
            'kehadiran' => $kehadiran,
            'mapel' => Mapel::where('id', $jadwal?->mapel_id)->first(),
        ];
        //dd($data);

        return view('preview.index', $data);
    }

    public function settings(Request $request)
    {
        $settings = Settings::where('id', 1)->first();
        if ($settings->blok_kecurangan == 'N') {
            try {
                Settings::where('id', $settings->id)->update([
                    'blok_kecurangan' => 'Y',
                ]);
                return redirect()->back()->with('message', 'Pengaturan ujian anti cheattings aktif');
            } catch (Exception $e) {
                return redirect()->back()->with('gagal', 'Terjadi kesalahan');
            }
        } elseif ($settings->blok_kecurangan == 'Y') {
            try {
                Settings::where('id', $settings->id)->update([
                    'blok_kecurangan' => 'N',
                ]);
                return redirect()->back()->with('message', 'Pengaturan ujian anti cheattings non aktif');
            } catch (Exception $e) {
                return redirect()->back()->with('gagal', 'Terjadi kesalahan');
            }
        }
    }
}
