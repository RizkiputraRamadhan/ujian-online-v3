<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Sekolah;
use App\Models\BankSoal;
use App\Models\Settings;
use App\Models\Kehadiran;
use App\Models\BankJawaban;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class UjianController extends Controller
{
    //
    public function index(Request $request)
    {
        $jadwal = Jadwal::where('id', $request->segment(4))->where('kelas_id', $request->session()->get('kelas_id'))->first();
        $kehadiran = Kehadiran::where('jadwal_id', $request->segment(4))->where('siswa_id', $request->session()->get('id'))->first();
        $button_status = false;
        $request->session()->remove('soal_id');

        if ($jadwal == null) {
            abort(403);
        }

        if (($kehadiran?->status_kehadiran == 'HADIR' && $kehadiran?->status_ujian != 'SELESAI' && $kehadiran?->status_ujian == 'BELUM_DIMULAI') || $kehadiran?->status_ujian == 'MENGERJAKAN') {
            $now = Carbon::now();
            $mulai = Carbon::parse($jadwal?->tanggal . ' ' . $jadwal?->jam_mulai);
            $selesai = Carbon::parse($jadwal?->tanggal . ' ' . $jadwal?->jam_selesai);
            if ($now->between($mulai, $selesai) && $kehadiran?->status_blokir == 'N') {
                // Mulai
                $button_status = true;
            }
        }

        $data = [
            'jadwal' => Jadwal::select('kelas.jurusan', 'kelas.tingkat_kelas', 'kelas.urusan_kelas', 'mapel.nama_mapel', 'tahun_ajaran.tahun', 'jadwal.tanggal', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'guru.nama AS pengawas', 'jadwal.id', 'mapel.guru_id')->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')->join('guru', 'guru.id', '=', 'jadwal.guru_id')->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id')->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')->where('jadwal.id', $request->segment(4))->first(),
            'kehadiran' => $kehadiran,
            'mapel' => Mapel::where('id', $jadwal?->mapel_id)->first(),
            'button_status' => $button_status,
            'setting' => Settings::where('id', '1')->first(),

        ];

        return view('siswa.ujian.detail', $data);
    }

    public function view_ujian(Request $request)
    {
        $jadwal = Jadwal::where('id', $request->segment(4))->where('kelas_id', $request->session()->get('kelas_id'))->first();
        $kehadiran = Kehadiran::where('jadwal_id', $request->segment(4))->where('siswa_id', $request->session()->get('id'))->where('no_peserta', $request->segment(5))->first();
        $mapel = Mapel::where('id', $jadwal?->mapel_id)->first();

        if ($jadwal == null || $kehadiran == null) {
            abort(403);
        }

        if (($kehadiran?->status_kehadiran == 'HADIR' && $kehadiran?->status_ujian != 'SELESAI' && $kehadiran?->status_ujian == 'BELUM_DIMULAI') || $kehadiran?->status_ujian == 'MENGERJAKAN') {
            $now = Carbon::now();
            $mulai = Carbon::parse($jadwal?->tanggal . ' ' . $jadwal?->jam_mulai);
            $selesai = Carbon::parse($jadwal?->tanggal . ' ' . $jadwal?->jam_selesai);
            if ($now->between($mulai, $selesai) && $kehadiran?->status_blokir == 'N') {
            } else {
                abort(403);
            }
        } else {
            abort(403);
        }

        // ubah status_ujian menjadi mengerjakan
        Kehadiran::where('id', $kehadiran?->id)->update([
            'status_ujian' => 'MENGERJAKAN',
        ]);

        $soal_id = [];
        //generate nomor acak
        if (!$request->session()->get('soal_id')) {
            $soal = BankSoal::where('mapel_id', $jadwal?->mapel_id)
                ->get()
                ->toArray();
            if ($mapel?->acak_soal == 'Y') {
                shuffle($soal);
            }
            $no = 1;
            foreach ($soal as $s) {
                $soal_id[] = [
                    'id' => $s['id'],
                    'key' => Str::random(6),
                    'no' => $no++,
                ];
            }
            $request->session()->put('soal_id', $soal_id);
        }

        if (!empty($request->session()->get('soal_id'))) {
            $soal_id = $request->session()->get('soal_id');
        }

        if (empty($request->get('next')) && empty($request->get('prev')) && empty($request->get('key')) && !empty($request->session()->get('soal_id'))) {
            // No 1
            $data = $this->generatePaging(@$soal_id[0]['id'], $jadwal?->mapel_id);
        } elseif (!empty($request->prev)) {
            // Previous
            $data = $this->generatePaging($request->prev, $jadwal?->mapel_id);
        } elseif (!empty($request->next)) {
            // Next
            $data = $this->generatePaging($request->next, $jadwal?->mapel_id);
        }
        if (!isset($data['soals'])) {
            abort(404);
        }

        $data = [
            'total_soal' => BankSoal::where('mapel_id', $jadwal?->mapel_id)->get(),
            'soal' => $data['soals'],
            'mapel' => $mapel,
            'jadwal' => $jadwal,
            'kehadiran' => $kehadiran,
            'sekolah' => Sekolah::where('id', $request->session()->get('sekolah_id'))->first(),
            'prev' => $data['prev'],
            'next' => $data['next'],
            'key_next' => $data['key_next'],
            'key_prev' => $data['key_prev'],
            'no' => $data['no'],
            'soal_id' => $soal_id,
            'setting' => Settings::where('id', '1')->first(),
        ];
        // dd($data);

        return view('siswa.ujian.view_ujian', $data);
    }

    private function generatePaging($index, $mapel_id)
    {
        if (!empty(request()->session()->get('soal_id'))) {
            $soal_id = request()->session()->get('soal_id');
        }

        $soal = BankSoal::where('mapel_id', $mapel_id)->get()->toArray();
        $n = 0;
        $p = 0;
        $key_next = 0;
        $key_prev = 0;

        if (BankSoal::where('id', $index)->where('mapel_id', $mapel_id)->first() == null) {
            abort(403);
        }

        for ($i = 0; $i < count($soal_id); $i++) {
            if ($soal_id[$i]['id'] == $index) {
                $next_soal = BankSoal::where('id', @$soal_id[$i + 1]['id'])->first();
                $prev_soal = BankSoal::where('id', @$soal_id[$i - 1]['id'])->first();

                if ($prev_soal == null) {
                    $p = 0;
                    $key_prev = 0;
                } else {
                    $p = @$soal_id[$i - 1]['id'];
                    $key_prev = $this->getKey(@$soal_id[$i - 1]['id']);
                }

                if ($next_soal == null) {
                    $n = 0;
                    $key_next = 0;
                } else {
                    $n = @$soal_id[$i + 1]['id'];
                    $key_next = $this->getKey(@$soal_id[$i + 1]['id']);
                }

                $soals = BankSoal::where('id', $index)->get()->toArray();

                // kecuali soal 1
                if (!empty(request()->get('key_prev'))) {
                    if (@$soal_id[$i]['key'] != request()->get('key_prev')) {
                        abort(403);
                    }
                }

                if (!empty(request()->get('key_next'))) {
                    if (@$soal_id[$i]['key'] != request()->get('key_next')) {
                        abort(403);
                    }
                }

                return [
                    'prev' => $p,
                    'key_next' => $key_next,
                    'key_prev' => $key_prev,
                    'next' => $n,
                    'soals' => $soals,
                    'no' => $this->getNomor($index),
                ];
            }
        }
    }

    private function getKey($id)
    {
        if (!empty(request()->session()->get('soal_id'))) {
            $soal_id = request()->session()->get('soal_id');
        }

        for ($i = 0; $i < count($soal_id); $i++) {
            if ($soal_id[$i]['id'] == $id) {
                return $soal_id[$i]['key'];
            }
        }
    }

    private function getNomor($id)
    {
        if (!empty(request()->session()->get('soal_id'))) {
            $soal_id = request()->session()->get('soal_id');
        }

        for ($i = 0; $i < count($soal_id); $i++) {
            if ($soal_id[$i]['id'] == $id) {
                return $soal_id[$i]['no'];
            }
        }
    }

    public function saveJawaban(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'banksoal_id' => 'required|integer', // Ubah sesuai kebutuhan
            'jawaban' => 'nullable', // Ubah sesuai kebutuhan
            'mapel_id' => 'required|integer', // Ubah sesuai kebutuhan
            'kehadiran_id' => 'required|integer', // Ubah sesuai kebutuhan
        ]);

        // Periksa apakah jawaban adalah array atau bukan
        if (is_array($validatedData['jawaban'])) {
            $jawaban = json_encode($validatedData['jawaban']); // Gabungkan array menjadi string
        } else {
            $jawaban = $validatedData['jawaban']; // Gunakan nilai tunggal jika bukan array
        }

        // Simpan jawaban ke database
        $check = BankJawaban::where('banksoal_id', $validatedData['banksoal_id'])
            ->where('siswa_id', $request->session()->get('id'))
            ->where('mapel_id', $validatedData['mapel_id'])
            ->where('kehadiran_id', $validatedData['kehadiran_id'])
            ->first();

        if ($check == null) {
            BankJawaban::create([
                'jawaban' => $jawaban,
                'banksoal_id' => $validatedData['banksoal_id'],
                'siswa_id' => $request->session()->get('id'),
                'mapel_id' => $validatedData['mapel_id'],
                'kehadiran_id' => $validatedData['kehadiran_id'],
            ]);
        } else {
            BankJawaban::where('id', $check?->id)->update([
                'jawaban' => $jawaban,
                'banksoal_id' => $validatedData['banksoal_id'],
                'siswa_id' => $request->session()->get('id'),
                'mapel_id' => $validatedData['mapel_id'],
                'kehadiran_id' => $validatedData['kehadiran_id'],
            ]);
        }

        // Periksa status blokir
        $status_blokir = Kehadiran::where('id', $validatedData['kehadiran_id'])->first();

        // Kirim respons JSON
        return response()->json(
            [
                'message' => 'Progress tersimpan',
                'status' => $status_blokir?->status_blokir == 'Y' ? true : false,
            ],
            200,
        );
    }

    public function setJawabanYakinRaguRagu(Request $request)
    {
        $check = BankJawaban::where('banksoal_id', $request->banksoal_id)
            ->where('siswa_id', $request->session()->get('id'))
            ->where('mapel_id', $request->mapel_id)
            ->where('kehadiran_id', $request->kehadiran_id)
            ->first();

        BankJawaban::where('id', $check?->id)->update([
            'status_jawaban' => $request->status_jawaban == 'ragu_ragu' ? 'ragu_ragu' : 'yakin',
        ]);

        $status_blokir = Kehadiran::where('id', $request->kehadiran_id)->first();

        if ($check == null) {
            return response()->json(
                [
                    'message' => 'Pilih jawaban dulu yha',
                    'status' => $status_blokir?->status_blokir == 'Y' ? true : false,
                ],
                400,
            );
        }

        return response()->json(
            [
                'message' => 'Progress tersimpan',
                'status' => $status_blokir?->status_blokir == 'Y' ? true : false,
            ],
            200,
        );
    }

    public function preview(Request $request)
    {

        $jadwal = Jadwal::where('id', $request->segment(4))->where('kelas_id', $request->session()->get('kelas_id'))->first();
        $kehadiran = Kehadiran::where('jadwal_id', $request->segment(4))->where('siswa_id', $request->session()->get('id'))->where('no_peserta', $request->segment(5))->first();

        if ($jadwal == null || $kehadiran == null) {
            abort(403);
        }

        $request->session()->remove('soal_id');

        if (($kehadiran?->status_kehadiran == 'HADIR' && $kehadiran?->status_ujian != 'SELESAI' && $kehadiran?->status_ujian == 'BELUM_DIMULAI') || $kehadiran?->status_ujian == 'MENGERJAKAN') {
            $now = Carbon::now();
            $mulai = Carbon::parse($jadwal?->tanggal . ' ' . $jadwal?->jam_mulai);
            $selesai = Carbon::parse($jadwal?->tanggal . ' ' . $jadwal?->jam_selesai);
            if ($now->between($mulai, $selesai) && $kehadiran?->status_blokir == 'N') {
            } else {
                abort(403);
            }
        } else {
            abort(403);
        }

        $data = [
            'jadwal' => $jadwal,
            'soal' => BankSoal::where('mapel_id', $jadwal?->mapel_id)->get(),
            'soal_dijawab' => BankJawaban::jawabCounter('dijawab', $kehadiran?->id, $jadwal?->mapel_id, $request->session()->get('id')),
            'soal_tidak_dijawab' => BankJawaban::jawabCounter('tidak_dijawab', $kehadiran?->id, $jadwal?->mapel_id, $request->session()->get('id')),
        ];

        return view('siswa.ujian.preview_ujian', $data);
    }

    public function submit_jawaban(Request $request)
    {
        $request->session()->remove('soal_id');
        $request->session()->forget('checkbox_data');
        Kehadiran::where('jadwal_id', $request->jadwal_id)
            ->where('siswa_id', $request->session()->get('id'))
            ->where('no_peserta', $request->no_peserta)
            ->update([
                'status_ujian' => 'SELESAI',
                'status_kehadiran' => 'HADIR',
                'status_blokir' => 'N',
            ]);

        return redirect()->to('siswa')->with('message', 'Anda telah berhasil menyelesaikan ujian');
    }
}
