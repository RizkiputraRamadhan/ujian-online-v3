<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankJawaban extends Model
{
    use HasFactory;
    protected $table = 'bank_jawaban';
    protected $guarded = [];

    static function jawabSiswa($kehadiran_id, $mapel_id, $siswa_id, $banksoal_id)
    {
        return static::where('kehadiran_id', $kehadiran_id)
            ->where('mapel_id', $mapel_id)
            ->where('siswa_id', $siswa_id)
            ->where('banksoal_id', $banksoal_id)
            ->first();
    }

    static function jawabCounter($type, $kehadiran_id, $mapel_id, $siswa_id)
    {
        $dijawab = 0;
        $tidak_dijawab = 0;
        foreach (BankSoal::where('mapel_id', $mapel_id)->get() as $bs) {
            if (BankJawaban::jawabSiswa($kehadiran_id, $mapel_id, $siswa_id, $bs->id) != null) {
                $dijawab++;
            } else {
                $tidak_dijawab++;
            }
        }
        return ($type == "dijawab") ? $dijawab : $tidak_dijawab;
    }

    static function getNilai($kehadiran_id, $mapel_id, $siswa_id)
    {
        $total_soal = count(BankSoal::where('mapel_id', $mapel_id)->get());
        $benar = 0;
        foreach (BankSoal::where('mapel_id', $mapel_id)->get() as $bs) {
            $jawaban = BankJawaban::jawabSiswa($kehadiran_id, $mapel_id, $siswa_id, $bs->id);
            if($bs->jenis_soal == 1) {
                if ($jawaban?->jawaban == $bs->kunci) {
                    $benar++;
                }
            } elseif($bs->jenis_soal == 2) {
                $kunciArray = $bs->kunci;
                if ($jawaban?->jawaban == $kunciArray) {
                    $benar++;
                }

            } elseif($bs->jenis_soal == 3) {
                $jenis_hrf = in_array('sensitif', json_decode($bs->jenis_hrf)) ? 'sensitif' : 'nonsensitif';
                if($jenis_hrf == 'sensitif') {
                    if (strcmp($jawaban?->jawaban, $bs->jawaban_singkat) === 0) {
                        $benar++;
                     }
                }elseif($jenis_hrf == 'nonsensitif'){
                    if (strcasecmp($jawaban?->jawaban, $bs->jawaban_singkat) === 0) {
                        $benar++;
                     }
                }
            }elseif($bs->jenis_soal == 4) {
                if ($jawaban?->jawaban == $bs->kunci) {
                    $benar++;
                }
            }elseif($bs->jenis_soal == 5) {
                if ($jawaban?->jawaban == $bs->kunci) {
                    $benar++;
                }
            }
        }

        if ($total_soal != 0) {
            return number_format(($benar / $total_soal) * 100, 2, ".", "");
        } else {
            return 0;
        }
    }

    static function getBenar($kehadiran_id, $mapel_id, $siswa_id)
    {
        $benar = 0;
        foreach (BankSoal::where('mapel_id', $mapel_id)->get() as $bs) {
            $jawaban = BankJawaban::jawabSiswa($kehadiran_id, $mapel_id, $siswa_id, $bs->id);
            if($bs->jenis_soal == 1) {
                if ($jawaban?->jawaban == $bs->kunci) {
                    $benar++;
                }
            } elseif($bs->jenis_soal == 2) {
                $kunciArray = $bs->kunci;
                if ($jawaban?->jawaban == $kunciArray) {
                    $benar++;
                }

            } elseif($bs->jenis_soal == 3) {
                $jenis_hrf = in_array('sensitif', json_decode($bs->jenis_hrf)) ? 'sensitif' : 'nonsensitif';
                if($jenis_hrf == 'sensitif') {
                    if (strcmp($jawaban?->jawaban, $bs->jawaban_singkat) === 0) {
                        $benar++;
                     }
                }elseif($jenis_hrf == 'nonsensitif'){
                    if (strcasecmp($jawaban?->jawaban, $bs->jawaban_singkat) === 0) {
                        $benar++;
                     }
                }
            }elseif($bs->jenis_soal == 4) {
                if ($jawaban?->jawaban == $bs->kunci) {
                    $benar++;
                }
            }elseif($bs->jenis_soal == 5) {
                if ($jawaban?->jawaban == $bs->kunci) {
                    $benar++;
                }
            }
        }

        return $benar;
    }

    static function getSalah($kehadiran_id, $mapel_id, $siswa_id)
    {
        $salah = 0;
        foreach (BankSoal::where('mapel_id', $mapel_id)->get() as $bs) {
            $jawaban = BankJawaban::jawabSiswa($kehadiran_id, $mapel_id, $siswa_id, $bs->id);


            if($bs->jenis_soal == 1) {
                if ($jawaban?->jawaban != null) {
                    if ($jawaban?->jawaban != $bs->kunci) {
                        $salah++;
                    }
                }
            } elseif($bs->jenis_soal == 2) {
                $kunciArray = $bs->kunci;
                if ($jawaban?->jawaban != null) {
                    if ($jawaban?->jawaban != $kunciArray) {
                        $salah++;
                    }
                }

            } elseif($bs->jenis_soal == 3) {
                $jenis_hrf = in_array('sensitif', json_decode($bs->jenis_hrf)) ? 'sensitif' : 'nonsensitif';
                 if ($jawaban?->jawaban != null) {
                     if($jenis_hrf == 'sensitif') {
                         if (strcmp($jawaban?->jawaban, $bs->jawaban_singkat) === 0) {

                          }else{
                            $salah++;
                          }
                     }elseif($jenis_hrf == 'nonsensitif'){
                         if (strcasecmp($jawaban?->jawaban, $bs->jawaban_singkat) === 0) {

                          }else{
                            $salah++;
                          }
                     }
                }


            } elseif($bs->jenis_soal == 4) {
                if ($jawaban?->jawaban != null) {
                    if ($jawaban?->jawaban != $bs->kunci) {
                        $salah++;
                    }
                }
            } elseif($bs->jenis_soal == 5) {
                if ($jawaban?->jawaban != null) {
                    if ($jawaban?->jawaban != $bs->kunci) {
                        $salah++;
                    }
                }
            }
        }

        return $salah;
    }

    static function getTidakDijawab($kehadiran_id, $mapel_id, $siswa_id)
    {
        $tidak_dijawab = 0;
        foreach (BankSoal::where('mapel_id', $mapel_id)->get() as $bs) {
            $jawaban = BankJawaban::jawabSiswa($kehadiran_id, $mapel_id, $siswa_id, $bs->id);
            if ($jawaban == null) {
                $tidak_dijawab++;
            }
        }

        return $tidak_dijawab;
    }

    static function getNilaiCBTIntegrate($siswa_id)
    {

        $siswa = Siswa::find($siswa_id);
        $mapelSiswa = MapelKelas::where('kelas_id', $siswa?->kelas_id)->get();
        $totalMapelSiswa = count($mapelSiswa);

        $nilai = 0;

        foreach ($mapelSiswa as $m) {
            $kehadiran = Kehadiran::join('jadwal', 'jadwal.id', '=', 'kehadiran.jadwal_id')
                ->where('kehadiran.kelas_id', $siswa?->kelas_id)
                ->where('kehadiran.siswa_id', $siswa_id)
                ->where('jadwal.mapel_id', $m?->mapel_id)
                ->first(['kehadiran.id']);

            $nilai += static::getNilai($kehadiran?->id, $m?->mapel_id, $siswa_id);
        }

        return ($totalMapelSiswa == 0) ? 0 : number_format(($nilai / $totalMapelSiswa), 2, ".", "");
    }

    static function getStatusUjianIntegrate($siswa_id)
    {
        $siswa = Siswa::find($siswa_id);
        $mapelSiswa = MapelKelas::where('kelas_id', $siswa?->kelas_id)->get();
        $totalMapelSiswa = \count($mapelSiswa);

        $sudahSelesai = 0;
        foreach ($mapelSiswa as $m) {
            $kehadiran = Kehadiran::join('jadwal', 'jadwal.id', '=', 'kehadiran.jadwal_id')
                ->where('kehadiran.kelas_id', $siswa?->kelas_id)
                ->where('kehadiran.siswa_id', $siswa_id)
                ->where('jadwal.mapel_id', $m?->mapel_id)
                ->first(['kehadiran.id', 'kehadiran.status_ujian']);

            if ($kehadiran?->status_ujian == "SELESAI") {
                $sudahSelesai++;
            }
        }

        return ($sudahSelesai == $totalMapelSiswa) ? true : false;
    }

    static function getStatusUjianIntegrateBySiswa($siswa_id)
    {
        $siswa = Siswa::find($siswa_id);
        $mapelSiswa = MapelKelas::where('kelas_id', $siswa?->kelas_id)->get();

        $result = array();

        foreach ($mapelSiswa as $m) {
            $mapel = Mapel::find($m->mapel_id);
            $kehadiran = Kehadiran::join('jadwal', 'jadwal.id', '=', 'kehadiran.jadwal_id')
                ->where('kehadiran.kelas_id', $siswa?->kelas_id)
                ->where('kehadiran.siswa_id', $siswa_id)
                ->where('jadwal.mapel_id', $m?->mapel_id)
                ->first(['kehadiran.id', 'kehadiran.status_ujian']);
            $result[] = [
                'nama_mapel' => $mapel?->nama_mapel,
                'status_ujian' => $kehadiran?->status_ujian,
                'nilai' => static::getNilai($kehadiran?->id, $m?->mapel_id, $siswa_id)
            ];
        }

        return $result;
    }
}
