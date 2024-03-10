<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\Kelas;
use App\Models\Mapel;
use Exception;

class BankSoalController extends Controller
{
    //
    public function index(Request $request)
    {
        // Forhibidden Rule
        if (Mapel::where('id', $request->segment(4))->where('guru_id', $request->session()->get('id'))->first() == null) {
            abort(403);
        }

        $data = [
            'mapel' => Mapel::select('mapel.id', 'mapel.nama_mapel', 'mapel.acak_soal', 'mapel.kkm', 'mapel.jumlah_soal', 'mapel.semester', 'guru.nama AS nama_guru', 'sekolah.level', 'sekolah.nama AS nama_sekolah', 'tahun_ajaran.tahun')->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')->join('guru', 'guru.id', '=', 'mapel.guru_id')->join('sekolah', 'sekolah.id', '=', 'guru.sekolah_id')->where('mapel.id', $request->segment(4))->where('mapel.guru_id', $request->session()->get('id'))->first(),
            'kelas' => Kelas::where('sekolah_id', $request->session()->get('sekolah_id'))->get(),
            'soal' => BankSoal::where('mapel_id', $request->segment(4))->orderBy('id', 'ASC')->get(),
            'allsMapel' => Mapel::all(),
        ];
        //dd($data);
        return view('guru.soal.index', $data)->with('sb', 'Data Mapel');
    }
    public function bankSoal(Request $request)
    {
        $data = [
            'mapelOld' => Mapel::where('id', $request->segment(5))->first(),
            'banksoal' => BankSoal::where('mapel_id', $request->segment(5))->get(),
            'mapelNew' => Mapel::where('id', $request->segment(4))->first(),
            'segment' => $request->segment(4),
        ];

        return view('guru.soal.bank_soal', $data)->with('sb', 'Data Mapel');
    }
    public function CreateBankSoal(Request $request)
    {
        $soal = BankSoal::where('id', $request->soalID)->first();
        $mapelID = Mapel::where('id', $request->segment(4))->first();
        if (count(BankSoal::where('mapel_id', $request->segment(4))->get()) == Mapel::where('id', $request->segment(4))->first()?->jumlah_soal) {
            return redirect()
            ->back()
            ->with('gagal', "Telah memenuhi batas soal pada mapel $mapelID->nama_mapel");
        }
        //dd($soal);
        if ($soal->jenis_soal == 1) {
            try {
                BankSoal::create([
                    'soal' => $soal->soal,
                    'jenis_soal' => $soal->jenis_soal,
                    'pil_1' => $soal->pil_1,
                    'pil_2' => $soal->pil_2,
                    'pil_3' => $soal->pil_3,
                    'pil_4' => $soal->pil_4,
                    'pil_5' => $soal->pil_5 ? $soal->pil_5 : ' ',
                    'mapel_id' => $mapelID->id,
                    'kunci' => $soal->kunci,
                ]);
                return redirect()
                    ->back()
                    ->with('success', "Soal pilihan ganda berhasil dipindah ke $mapelID->nama_mapel");
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->with('gagal', "Terjadi kesalahan saat migrasi soal ke $mapelID->nama_mapel");
            }
        } elseif ($soal->jenis_soal == 2) {
            try {
                BankSoal::create([
                    'soal' => $soal->soal,
                    'jenis_soal' => $soal->jenis_soal,
                    'pil_1' => $soal->pil_1,
                    'pil_2' => $soal->pil_2,
                    'pil_3' => $soal->pil_3,
                    'pil_4' => $soal->pil_4,
                    'pil_5' => $soal->pil_5 ? $soal->pil_5 : ' ',
                    'mapel_id' => $mapelID->id,
                    'kunci' => $soal->kunci,
                ]);
                return redirect()
                    ->back()
                    ->with('success', "Soal Checkbox berhasil dipindah ke $mapelID->nama_mapel");
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->with('gagal', "Terjadi kesalahan saat migrasi soal ke $mapelID->nama_mapel");
            }
        } elseif ($soal->jenis_soal == 3) {
            try {
                BankSoal::create([
                    'soal' => $soal->soal,
                    'jenis_soal' => $soal->jenis_soal,
                    'jawaban_singkat' => $soal->jawaban_singkat,
                    'mapel_id' => $mapelID->id,
                    'jenis_hrf' => $soal->jenis_hrf,
                    'jenis_inp' => $soal->jenis_inp,
                ]);
                return redirect()
                    ->back()
                    ->with('success', "Soal essay berhasil dipindah ke $mapelID->nama_mapel");
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->with('gagal', "Terjadi kesalahan saat migrasi soal ke $mapelID->nama_mapel");
            }
        } elseif ($soal->jenis_soal == 4) {
            try {
                BankSoal::create([
                    'soal' => $soal->soal,
                    'jenis_soal' => $soal->jenis_soal,
                    'mapel_id' => $mapelID->id,
                    'kunci' => $soal->kunci,
                ]);
                return redirect()
                    ->back()
                    ->with('success', "Soal true and false berhasil dipindah ke $mapelID->nama_mapel");
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->with('gagal', "Terjadi kesalahan saat migrasi soal ke $mapelID->nama_mapel");
            }
        } elseif ($soal->jenis_soal == 5) {
            try {
                BankSoal::create([
                    'soal' => $soal->soal,
                    'jenis_soal' => $soal->jenis_soal,
                    'jawaban_jdh' => $soal->jawaban_jdh,
                    'soal_jdh_array' => $soal->soal_jdh_array,
                    'mapel_id' => $mapelID->id,
                    'kunci' => $soal->kunci,
                ]);

                return redirect()
                    ->back()
                    ->with('success', "Soal menjodohkan berhasil dipindah ke $mapelID->nama_mapel");
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->with('gagal', "Terjadi kesalahan saat migrasi soal ke $mapelID->nama_mapel");
            }
        }
    }
}
