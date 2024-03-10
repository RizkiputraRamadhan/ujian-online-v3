<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\SoalImport;
use App\Models\BankSoal;
use App\Models\Kelas;
use App\Models\Mapel;
use Exception;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BankSoalController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = [
            'mapel' => Mapel::select('mapel.id', 'mapel.nama_mapel', 'mapel.acak_soal', 'mapel.kkm', 'mapel.jumlah_soal', 'mapel.semester', 'guru.nama AS nama_guru', 'sekolah.level', 'sekolah.nama AS nama_sekolah', 'tahun_ajaran.tahun')->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'mapel.tahunajaran_id')->join('guru', 'guru.id', '=', 'mapel.guru_id')->join('sekolah', 'sekolah.id', '=', 'guru.sekolah_id')->where('mapel.id', $request->segment(5))->first(),
            'kelas' => Kelas::where('sekolah_id', $request->segment(6))->get(),
            'soal' => BankSoal::where('mapel_id', $request->segment(5))->orderBy('id', 'ASC')->get(),
            'allsMapel' => Mapel::all(),
        ];
        return view('admin.master_data.soal.index', $data)->with('sb', 'Data Mapel');
    }
    public function create(Request $request)
    {
        //dd($request->all());
        if (count(BankSoal::where('mapel_id', $request->mapel_id)->get()) == Mapel::where('id', $request->mapel_id)->first()?->jumlah_soal) {
            return response()->json(
                [
                    'message' => 'Telah memenuhi batas input soal pada mapel ini',
                ],
                400,
            );
        } else {
            if ($request->jenis_soal == 1) {
                if ($request->kunci === null) {
                    return response()->json(
                        [
                            'message' => 'Belum memilih jawaban benar',
                        ],
                        400,
                    );
                }
                try {
                    BankSoal::create([
                        'soal' => $request->soal ? $request->soal : ' ',
                        'jenis_soal' => $request->jenis_soal ? $request->jenis_soal : ' ',
                        'pil_1' => $request->pil_1 ? $request->pil_1 : ' ',
                        'pil_2' => $request->pil_2 ? $request->pil_2 : ' ',
                        'pil_3' => $request->pil_3 ? $request->pil_3 : ' ',
                        'pil_4' => $request->pil_4 ? $request->pil_4 : ' ',
                        'pil_5' => $request->pil_5 ? $request->pil_5 : ' ',
                        'mapel_id' => $request->mapel_id ? $request->mapel_id : ' ',
                        'kunci' => $request->kunci ? $request->kunci : ' ',
                    ]);
                    return response()->json(
                        [
                            'message' => 'Soal pilihan ganda berhasil dibuat',
                        ],
                        200,
                    );
                } catch (Exception $e) {
                    return response()->json(
                        [
                            'message' => 'Terjadi kesalahan saat input soal, periksa kembali inputan anda, pastikan semua soal dan pilihan sudah terisi',
                        ],
                        400,
                    );
                }
            } elseif ($request->jenis_soal == 2) {
                if ($request->kunci === null) {
                    return response()->json(
                        [
                            'message' => 'Belum memilih jawaban benar',
                        ],
                        400,
                    );
                }
                try {
                    BankSoal::create([
                        'soal' => $request->soal ? $request->soal : ' ',
                        'kunci' => json_encode($request->kunci),
                        'jenis_soal' => $request->jenis_soal ? $request->jenis_soal : ' ',
                        'pil_1' => $request->pil_1 ? $request->pil_1 : ' ',
                        'pil_2' => $request->pil_2 ? $request->pil_2 : ' ',
                        'pil_3' => $request->pil_3 ? $request->pil_3 : ' ',
                        'pil_4' => $request->pil_4 ? $request->pil_4 : ' ',
                        'pil_5' => $request->pil_5 ? $request->pil_5 : ' ',
                        'mapel_id' => $request->mapel_id ? $request->mapel_id : ' ',
                    ]);
                    return response()->json(
                        [
                            'message' => 'Soal Checkbox berhasil dibuat',
                        ],
                        200,
                    );
                } catch (Exception $e) {
                    return response()->json(
                        [
                            'message' => 'Terjadi kesalahan saat input soal, periksa kembali inputan anda, pastikan semua soal dan pilihan sudah terisi',
                        ],
                        400,
                    );
                }
            } elseif ($request->jenis_soal == 3) {
                if ($request->jenis_hrf === null || $request->jenis_inp === null) {
                    return response()->json(
                        [
                            'message' => 'Setting jawaban belum dichecklist',
                        ],
                        400,
                    );
                } elseif ($request->jawaban_singkat == null) {
                    return response()->json(
                        [
                            'message' => 'Jawaban belum ditentukan',
                        ],
                        400,
                    );
                }

                try {
                    BankSoal::create([
                        'soal' => $request->soal ? $request->soal : ' ',
                        'jenis_soal' => $request->jenis_soal ? $request->jenis_soal : ' ',
                        'jawaban_singkat' => $request->jawaban_singkat ? $request->jawaban_singkat : ' ',
                        'mapel_id' => $request->mapel_id ? $request->mapel_id : ' ',
                        'jenis_hrf' => json_encode($request->jenis_hrf) ? json_encode($request->jenis_hrf) : ' ',
                        'jenis_inp' => json_encode($request->jenis_inp) ? json_encode($request->jenis_inp) : ' ',
                    ]);
                    return response()->json(
                        [
                            'message' => 'Soal essy berhasil dibuat',
                        ],
                        200,
                    );
                } catch (Exception $e) {
                    return response()->json(
                        [
                            'message' => 'Terjadi kesalahan saat input soal, periksa kembali inputan anda, pastikan semua soal dan pilihan sudah terisi',
                        ],
                        400,
                    );
                }
            } elseif ($request->jenis_soal == 4) {
                if ($request->soal == null) {
                    return response()->json(
                        [
                            'message' => 'Soal Belum diisi.',
                        ],
                        400,
                    );
                }
                try {
                    BankSoal::create([
                        'soal' => $request->soal ? $request->soal : ' ',
                        'jenis_soal' => $request->jenis_soal ? $request->jenis_soal : ' ',
                        'mapel_id' => $request->mapel_id ? $request->mapel_id : ' ',
                        'kunci' => $request->kunci,
                    ]);
                    return response()->json(
                        [
                            'message' => 'Soal true and false berhasil dibuat',
                        ],
                        200,
                    );
                } catch (Exception $e) {
                    return response()->json(
                        [
                            'message' => 'Terjadi kesalahan saat input soal, periksa kembali inputan anda, pastikan semua soal dan pilihan sudah terisi',
                        ],
                        400,
                    );
                }
            } elseif ($request->jenis_soal == 5) {
                if ($request->soal == null) {
                    return response()->json(
                        [
                            'message' => 'Soal Belum diisi.',
                        ],
                        400,
                    );
                }

                $soal_jdh_array_filtered = array_filter($request->soal_jdh_array, function ($value) {
                    return $value !== null;
                });
                $jawaban_jdh_filtered = array_filter($request->jawaban_jdh, function ($value) {
                    return $value !== null;
                });
                $kunci_filtered = array_filter($request->kunci_jdh, function ($value) {
                    return $value !== 'pilih';
                });
                if (empty($soal_jdh_array_filtered) || empty($jawaban_jdh_filtered) || empty($kunci_filtered)) {
                    return response()->json(
                        [
                            'message' => 'Ada yang terlewat Belum diisi.',
                        ],
                        400,
                    );
                }

                $jawaban_jdh = json_encode($jawaban_jdh_filtered);
                $soal_jdh_array = json_encode($soal_jdh_array_filtered);
                $kunci = json_encode($kunci_filtered);
                try {
                    BankSoal::create([
                        'soal' => $request->soal ? $request->soal : ' ',
                        'jenis_soal' => $request->jenis_soal ? $request->jenis_soal : ' ',
                        'jawaban_jdh' => $jawaban_jdh,
                        'soal_jdh_array' => $soal_jdh_array,
                        'mapel_id' => $request->mapel_id ? $request->mapel_id : ' ',
                        'kunci' => $kunci,
                    ]);

                    return response()->json(
                        [
                            'message' => 'Soal berhasil dibuat',
                        ],
                        200,
                    );
                } catch (Exception $e) {
                    return response()->json(
                        [
                            'message' => 'Terjadi kesalahan saat input soal, periksa kembali inputan anda, pastikan semua soal dan pilihan sudah terisi',
                        ],
                        400,
                    );
                }
            }
        }
    }

    public function get(Request $request)
    {
        //dd($request->all());
        return response()->json(BankSoal::where('id', $request->id)->first(), 200);
    }

    public function update(Request $request)
    {
        //dd($request->all());
        if ($request->jenis_soal == 1) {
            if ($request->kunci === null) {
                return response()->json(
                    [
                        'message' => 'Belum memilih jawaban benar',
                    ],
                    400,
                );
            }
            try {
                BankSoal::where('id', $request->id)->update([
                    'soal' => $request->soal ? $request->soal : ' ',
                    'jenis_soal' => $request->jenis_soal ? $request->jenis_soal : ' ',
                    'pil_1' => $request->pil_1 ? $request->pil_1 : ' ',
                    'pil_2' => $request->pil_2 ? $request->pil_2 : ' ',
                    'pil_3' => $request->pil_3 ? $request->pil_3 : ' ',
                    'pil_4' => $request->pil_4 ? $request->pil_4 : ' ',
                    'pil_5' => $request->pil_5 ? $request->pil_5 : ' ',
                    'kunci' => $request->kunci ? $request->kunci : ' ',
                ]);
                return response()->json(
                    [
                        'message' => 'Soal pilihan ganda berhasil diupdate',
                    ],
                    200,
                );
            } catch (Exception $e) {
                return response()->json(
                    [
                        'message' => 'Terjadi kesalahan saat input soal, periksa kembali inputan anda, pastikan semua soal dan pilihan sudah terisi',
                    ],
                    400,
                );
            }
        } elseif ($request->jenis_soal == 2) {
            if ($request->kunci === null) {
                return response()->json(
                    [
                        'message' => 'Belum memilih jawaban benar',
                    ],
                    400,
                );
            }
            try {
                BankSoal::where('id', $request->id)->update([
                    'soal' => $request->soal ? $request->soal : ' ',
                    'kunci' => json_encode($request->kunci),
                    'jenis_soal' => $request->jenis_soal ? $request->jenis_soal : ' ',
                    'pil_1' => $request->pil_1 ? $request->pil_1 : ' ',
                    'pil_2' => $request->pil_2 ? $request->pil_2 : ' ',
                    'pil_3' => $request->pil_3 ? $request->pil_3 : ' ',
                    'pil_4' => $request->pil_4 ? $request->pil_4 : ' ',
                    'pil_5' => $request->pil_5 ? $request->pil_5 : ' ',
                ]);
                return response()->json(
                    [
                        'message' => 'Soal Checkbox berhasil diupdate',
                    ],
                    200,
                );
            } catch (Exception $e) {
                return response()->json(
                    [
                        'message' => 'Terjadi kesalahan saat input soal, periksa kembali inputan anda, pastikan semua soal dan pilihan sudah terisi',
                    ],
                    400,
                );
            }
        } elseif ($request->jenis_soal == 3) {
            if ($request->jenis_hrf === null || $request->jenis_inp === null) {
                return response()->json(
                    [
                        'message' => 'Setting jawaban belum dichecklist',
                    ],
                    400,
                );
            } elseif ($request->jawaban_singkat == null) {
                return response()->json(
                    [
                        'message' => 'Jawaban belum ditentukan',
                    ],
                    400,
                );
            }
            BankSoal::where('id', $request->id)->update([
                'soal' => $request->soal,
                'jenis_soal' => $request->jenis_soal,
                'jawaban_singkat' => $request->jawaban_singkat,
                'jenis_hrf' => json_encode($request->jenis_hrf),
                'jenis_inp' => json_encode($request->jenis_inp),
            ]);
            return response()->json(
                [
                    'message' => 'Soal essy berhasil diedit',
                ],
                200,
            );
        } elseif ($request->jenis_soal == 4) {
            if ($request->soal == null) {
                return response()->json(
                    [
                        'message' => 'Soal Belum diisi.',
                    ],
                    400,
                );
            }
            try {
                BankSoal::where('id', $request->id)->update([
                    'soal' => $request->soal ? $request->soal : ' ',
                    'jenis_soal' => $request->jenis_soal ? $request->jenis_soal : ' ',
                    'kunci' => $request->kunci,
                ]);
                return response()->json(
                    [
                        'message' => 'Soal true and false berhasil diupdate',
                    ],
                    200,
                );
            } catch (Exception $e) {
                return response()->json(
                    [
                        'message' => 'Terjadi kesalahan saat update soal, periksa kembali inputan anda, pastikan semua soal dan pilihan sudah terisi',
                    ],
                    400,
                );
            }
        } elseif ($request->jenis_soal == 5) {
            if ($request->soal == null) {
                return response()->json(
                    [
                        'message' => 'Soal Belum diisi.',
                    ],
                    400,
                );
            }

            $soal_jdh_array_filtered = array_filter($request->soal_jdh_array, function ($value) {
                return $value !== null;
            });
            $jawaban_jdh_filtered = array_filter($request->jawaban_jdh, function ($value) {
                return $value !== null;
            });
            $kunci_filtered = array_filter($request->kunci_jdh, function ($value) {
                return $value !== 'pilih';
            });
            if (empty($soal_jdh_array_filtered) || empty($jawaban_jdh_filtered) || empty($kunci_filtered)) {
                return response()->json(
                    [
                        'message' => 'Ada yang terlewat Belum diisi.',
                    ],
                    400,
                );
            }

            // Debug atau tampilkan jumlah elemen
            $jawaban_jdh = json_encode($jawaban_jdh_filtered);
            $soal_jdh_array = json_encode($soal_jdh_array_filtered);
            $kunci = json_encode($kunci_filtered);
            try {
                BankSoal::where('id', $request->id)->update([
                    'soal' => $request->soal ? $request->soal : ' ',
                    'jenis_soal' => $request->jenis_soal ? $request->jenis_soal : ' ',
                    'jawaban_jdh' => $jawaban_jdh,
                    'soal_jdh_array' => $soal_jdh_array,
                    'kunci' => $kunci,
                ]);

                return response()->json(
                    [
                        'message' => 'Soal mencocokan berhasil diupdate',
                    ],
                    200,
                );
            } catch (Exception $e) {
                return response()->json(
                    [
                        'message' => 'Terjadi kesalahan saat input soal, periksa kembali inputan anda, pastikan semua soal dan pilihan sudah terisi',
                    ],
                    400,
                );
            }
        }
    }

    public function delete(Request $request)
    {
        if ($request->id == null) {
            return response()->json(
                [
                    'message' => 'Checklist minimal satu soal',
                ],
                400,
            );
        } else {
            $total = count($request->id);
            foreach ($request->id as $id) {
                BankSoal::where('id', $id)->delete();
            }
            return response()->json(
                [
                    'message' => "$total soal berhasil dihapus",
                ],
                200,
            );
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Ekstensi file salah',
                ],
                200,
            );
        } else {
            try {
                Excel::import(new SoalImport($request->id), $request->file('file'));
                return response()->json(
                    [
                        'message' => 'Import data soal berhasil',
                    ],
                    200,
                );
            } catch (Exception $e) {
                return response()->json(
                    [
                        'message' => 'Terjadi kesalahan saat import data ' . $e->getMessage(),
                    ],
                    200,
                );
            }
        }
    }
    public function bankSoal(Request $request)
    {
        $data = [
            'mapelOld' => Mapel::where('id', $request->segment(7))->first(),
            'banksoal' => BankSoal::where('mapel_id', $request->segment(7))->get(),
            'mapelNew' => Mapel::where('id', $request->segment(5))->first(),
            'segment' => $request->segment(5),
        ];
        //dd($data);

        return view('admin.master_data.soal.bank_soal', $data)->with('sb', 'Data Mapel');
    }
    public function CreateBankSoal(Request $request)
    {
        $soal = BankSoal::where('id', $request->soalID)->first();
        $mapelID = Mapel::where('id', $request->segment(5))->first();
        if (count(BankSoal::where('mapel_id', $request->segment(5))->get()) == Mapel::where('id', $request->segment(5))->first()?->jumlah_soal) {
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
