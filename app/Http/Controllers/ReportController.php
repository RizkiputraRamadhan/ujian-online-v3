<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //
    private $kop, $jadwal_kelas_mapel;

    public function __construct()
    {
        $this->kop =  Sekolah::where('id', request()->segment(5))
            ->first();
        $this->jadwal_kelas_mapel = Jadwal::select('jadwal.id', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'jadwal.lama_ujian', 'kelas.jurusan', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'mapel.nama_mapel', 'guru.nama AS pengawas', 'guru.nip_nik_nisn', 'mapel.kkm')
            ->join('kelas', 'kelas.id', '=', 'jadwal.kelas_id')
            ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')
            ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
            ->where('jadwal.id', request()->segment(3))
            ->first();
    }

    public function berita_acara(Request $request)
    {
        $data = [
            'siswa' => Siswa::where('kelas_id', $request->segment(4))->get(),
            'siswa_hadir' => Kehadiran::join('siswa', 'kehadiran.siswa_id', '=', 'siswa.id')
                ->where('kehadiran.jadwal_id', $request->segment(3))
                ->where('kehadiran.status_kehadiran', "HADIR")
                ->get(),
            'siswa_tidak_hadir' => Kehadiran::join('siswa', 'kehadiran.siswa_id', '=', 'siswa.id')
                ->where('kehadiran.jadwal_id', $request->segment(3))
                ->where('kehadiran.status_kehadiran', "TIDAK_HADIR")
                ->get(),
        ];
        return view('report.pdf.berita_acara', $data)->with('kop', $this->kop)->with('jadwal_kelas_mapel', $this->jadwal_kelas_mapel);
    }

    public function daftar_hadir_ujian(Request $request)
    {
        $data = [
            'siswa' => Siswa::where('kelas_id', $request->segment(4))->orderBy('nis', "ASC")->get(),
        ];

        return view('report.pdf.daftar_hadir', $data)->with('kop', $this->kop)->with('jadwal_kelas_mapel', $this->jadwal_kelas_mapel);
    }

    public function daftar_tidak_hadir_ujian(Request $request)
    {
        $data = [
            'siswa' => Siswa::where('kelas_id', $request->segment(4))->orderBy('nis', "ASC")->get(),
        ];

        return view('report.pdf.daftar_tidak_hadir', $data)->with('kop', $this->kop)->with('jadwal_kelas_mapel', $this->jadwal_kelas_mapel);
    }

    public function kartu_ujian(Request $request)
    {
        $data = [
            'siswa' => Siswa::where('kelas_id', $request->segment(3))->orderBy('nis', "ASC")->get()->toArray(),
            'kop' => Sekolah::where('sekolah.id', request()->segment(4))
                ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'sekolah.tahunajaran_id')
                ->first(),
            'kelas' => Kelas::where('id', $request->segment(3))->first()
        ];

        return view('report.pdf.kartu_ujian', $data);
    }

    public function nilai_pdf(Request $request)
    {
        $data = [
            'siswa' => Siswa::where('kelas_id', $request->segment(4))->orderBy('nis', "ASC")->get(),
        ];

        return view('report.pdf.nilai_pdf', $data)->with('kop', $this->kop)->with('jadwal_kelas_mapel', $this->jadwal_kelas_mapel);
    }

    public function nilai_mengulang(Request $request)
    {
        $data = [
            'siswa' => Siswa::where('kelas_id', $request->segment(4))->orderBy('nis', "ASC")->get(),
        ];

        return view('report.pdf.nilai_mengulang', $data)->with('kop', $this->kop)->with('jadwal_kelas_mapel', $this->jadwal_kelas_mapel);
    }

    public function nilai_excel(Request $request)
    {
        return Excel::download(new SiswaExport($request->segment(6), $request->segment(3), $request->segment(4)), 'lap_nilai_' . date('Y-m-d') . '.xlsx');
    }
}
