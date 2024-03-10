<?php

namespace App\Http\Controllers\Guru;

use Exception;
use App\Models\Soal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Folder;
use App\Models\Jadwal;
use App\Models\Sekolah;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class FolderBsController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::orderBy('id', 'desc')->get(),
        ];
        //dd($data);
        return view('guru.folder.index', $data)->with('sb', 'Bank Soal');
    }
    public function create(Request $request)
    {
        try {
            Folder::create([
                'nama' => $request->nama,
                'nama_mapel' => $request->mapel,
                'nama_kelas' => json_encode($request->kelas_id),
                'ketentuan' => $request->ket,
            ]);

            return redirect()->back()->with('success', 'Folder Bank Soal berhasil dibuat');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat Folder Bank Soal dibuat');
        }
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'edit' => Folder::where('id', $id)->first(),
        ];
        //dd($data);
        return view('guru.folder.edit', $data)->with('sb', 'Bank Soal');
    }

    public function update(Request $request, $id)
    {
        try {
            $folder = Folder::find($id);

            $folder->nama = $request->nama;
            $folder->nama_mapel = $request->mapel;
            $folder->nama_kelas = json_encode($request->kelas_id);
            $folder->ketentuan = $request->ket;

            $folder->save();

            return redirect('/guru/folder')->with('success', 'Folder Bank Soal berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat Folder Bank Soal diperbarui');
        }
    }

    public function delete($id)
    {
        $folder = Folder::findOrFail($id);
        $folder->delete();
        return redirect()->back()->with('success', 'Folder berhasil dihapus');
    }

    //proses migrasi
    public function migrasi(Request $request)
    {
        //dd($request->all());
        $soalInFolder = Soal::where('folder_bs', $request->folder)
            ->where('jenis_soal', $request->jenis_soal)
            ->get();
        $jumlahSoal = $request->jumlah;

        if ($jumlahSoal > count($soalInFolder)) {
            return redirect()->back()->with('warning', 'Jumlah soal yang diminta melebihi jumlah soal yang tersedia di folder.');
        }

        if (count(BankSoal::where('mapel_id', $request->mapel_id)->get()) == Mapel::where('id', $request->mapel_id)->first()?->jumlah_soal) {
            return redirect()->back()->with('warning', 'Soal Sudah Penuh.');
        }

        $soalAcak = $soalInFolder->random($jumlahSoal);
        //dd($soalAcak);
        if ($request->jenis_soal == 1) {
            foreach ($soalAcak as $soal) {
                try {
                    BankSoal::create([
                        'soal' => $soal->soal,
                        'jenis_soal' => $soal->jenis_soal,
                        'pil_1' => $soal->pil_1,
                        'pil_2' => $soal->pil_2,
                        'pil_3' => $soal->pil_3,
                        'pil_4' => $soal->pil_4,
                        'pil_5' => $soal->pil_5 ? $soal->pil_5 : ' ',
                        'mapel_id' => $request->mapel_id,
                        'kunci' => $soal->kunci,
                    ]);
                } catch (Exception $e) {
                    return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menyalin soal ke bank soal. Periksa kembali inputan Anda.');
                }
            }
            return redirect()->back()->with('success', 'Soal berhasil disalin ke bank soal.');
        } elseif ($request->jenis_soal == 2) {
            foreach ($soalAcak as $soal) {
                try {
                    BankSoal::create([
                        'soal' => $soal->soal,
                        'jenis_soal' => $soal->jenis_soal,
                        'pil_1' => $soal->pil_1,
                        'pil_2' => $soal->pil_2,
                        'pil_3' => $soal->pil_3,
                        'pil_4' => $soal->pil_4,
                        'pil_5' => $soal->pil_5 ? $soal->pil_5 : ' ',
                        'mapel_id' => $request->mapel_id,
                        'kunci' => $soal->kunci,
                    ]);
                } catch (Exception $e) {
                    return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menyalin soal ke bank soal. Periksa kembali inputan Anda.');
                }
            }
            return redirect()->back()->with('success', 'Soal berhasil disalin ke bank soal.');
        } elseif ($request->jenis_soal == 3) {
            foreach ($soalAcak as $soal) {
                try {
                    BankSoal::create([
                        'soal' => $soal->soal,
                        'jenis_soal' => $soal->jenis_soal,
                        'jawaban_singkat' => $soal->jawaban_singkat,
                        'mapel_id' => $request->mapel_id,
                        'jenis_hrf' => $soal->jenis_hrf,
                        'jenis_inp' => $soal->jenis_inp,
                    ]);
                } catch (Exception $e) {
                    return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menyalin soal ke bank soal. Periksa kembali inputan Anda.');
                }
            }
            return redirect()->back()->with('success', 'Soal berhasil disalin ke bank soal.');
        } elseif ($request->jenis_soal == 4) {
            foreach ($soalAcak as $soal) {
                try {
                    BankSoal::create([
                        'soal' => $soal->soal,
                        'jenis_soal' => $soal->jenis_soal,
                        'mapel_id' => $request->mapel_id,
                        'kunci' => $soal->kunci,
                    ]);
                } catch (Exception $e) {
                    return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menyalin soal ke bank soal. Periksa kembali inputan Anda.');
                }
            }
            return redirect()->back()->with('success', 'Soal berhasil disalin ke bank soal.');
        } elseif ($request->jenis_soal == 5) {
            foreach ($soalAcak as $soal) {
                try {
                    BankSoal::create([
                        'soal' => $soal->soal,
                        'jenis_soal' => $soal->jenis_soal,
                        'jawaban_jdh' => $soal->jawaban_jdh,
                        'soal_jdh_array' => $soal->soal_jdh_array,
                        'mapel_id' => $request->mapel_id,
                        'kunci' => $soal->kunci,
                    ]);
                } catch (Exception $e) {
                    return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menyalin soal ke bank soal. Periksa kembali inputan Anda.');
                }
            }
            return redirect()->back()->with('success', 'Soal berhasil disalin ke bank soal.');
        }
    }
}
