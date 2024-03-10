<?php

namespace App\Http\Controllers\Guru;

use Exception;
use App\Models\Soal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Folder;
use App\Models\Jadwal;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use Faker\Provider\Barcode;
use Yajra\DataTables\Facades\DataTables;

class SoalController extends Controller
{
    //
    public function index(Request $request, $id)
    {
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'count1' => Soal::where('jenis_soal', 1)->where('folder_bs', $id)->count(),
            'count2' => Soal::where('jenis_soal', 2)->where('folder_bs', $id)->count(),
            'count3' => Soal::where('jenis_soal', 3)->where('folder_bs', $id)->count(),
            'count4' => Soal::where('jenis_soal', 4)->where('folder_bs', $id)->count(),
            'count5' => Soal::where('jenis_soal', 5)->where('folder_bs', $id)->count(),
        ];
        return view('guru.folder.soal.index', $data)->with('sb', 'Bank Soal');
    }

    public function jenis1(Request $request, $id)
    {
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'mapel' => Mapel::all(),
            'banksoal' => BankSoal::all(),
            'soal' => Soal::where('jenis_soal', $request->segment(5))->where('folder_bs', $request->segment(4))->get(),
        ];
        //dd($data);
        return view('guru.folder.soal.jenis.jenis1', $data)->with('sb', 'Bank Soal');
    }

    public function jenis2(Request $request, $id)
    {
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'mapel' => Mapel::all(),
            'banksoal' => BankSoal::all(),
            'soal' => Soal::where('jenis_soal', $request->segment(5))->where('folder_bs', $request->segment(4))->get(),
        ];

        return view('guru.folder.soal.jenis.jenis2', $data)->with('sb', 'Bank Soal');
    }
    public function jenis3(Request $request, $id)
    {
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'mapel' => Mapel::all(),
            'banksoal' => BankSoal::all(),
            'soal' => Soal::where('jenis_soal', $request->segment(5))->where('folder_bs', $request->segment(4))->get(),
        ];
        return view('guru.folder.soal.jenis.jenis3', $data)->with('sb', 'Bank Soal');
    }

    public function jenis4(Request $request, $id)
    {
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'mapel' => Mapel::all(),
            'banksoal' => BankSoal::all(),
            'soal' => Soal::where('jenis_soal', $request->segment(5))->where('folder_bs', $request->segment(4))->get(),
        ];
        return view('guru.folder.soal.jenis.jenis4', $data)->with('sb', 'Bank Soal');
    }

    public function jenis5(Request $request, $id)
    {
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'mapel' => Mapel::all(),
            'banksoal' => BankSoal::all(),
            'soal' => Soal::where('jenis_soal', $request->segment(5))->where('folder_bs', $request->segment(4))->get(),
        ];
        return view('guru.folder.soal.jenis.jenis5', $data)->with('sb', 'Bank Soal');
    }

    //create
    public function CreateJenis1(Request $request, $id)
    {
        try {
            Soal::create([
                'soal' => $request->soal,
                'jenis_soal' => '1',
                'pil_1' => $request->pil_1,
                'pil_2' => $request->pil_2,
                'pil_3' => $request->pil_3,
                'pil_4' => $request->pil_4,
                'pil_5' => $request->pil_5,
                'folder_bs' => $id,
                'kunci' => $request->kunci,
            ]);
            return redirect()->back()->with('message', 'Soal pilihan ganda berhasil dibuat ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat membuat soal');
        }
    }

    public function CreateJenis2(Request $request, $id)
    {
        try {
            Soal::create([
                'soal' => $request->soal,
                'jenis_soal' => '2',
                'pil_1' => $request->pil_1,
                'pil_2' => $request->pil_2,
                'pil_3' => $request->pil_3,
                'pil_4' => $request->pil_4,
                'pil_5' => $request->pil_5,
                'folder_bs' => $id,
                'kunci' => json_encode($request->kunci),
            ]);
            return redirect()->back()->with('message', 'Soal pilihan ganda komplex berhasil dibuat ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat membuat soal');
        }
    }

    public function CreateJenis3(Request $request, $id)
    {
        //dd($request->all());
        try {
            Soal::create([
                'soal' => $request->soal,
                'jenis_soal' => 3,
                'jawaban_singkat' => $request->jawaban_singkat,
                'folder_bs' => $id,
                'jenis_hrf' => json_encode($request->jenis_hrf),
                'jenis_inp' => json_encode($request->jenis_inp),
            ]);
            return redirect()->back()->with('message', 'Soal Essay berhasil dibuat ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat membuat soal');
        }
    }

    public function CreateJenis4(Request $request, $id)
    {
        //dd($request->all());
        try {
            Soal::create([
                'soal' => $request->soal,
                'jenis_soal' => 4,
                'folder_bs' => $id,
                'kunci' => $request->kunci,
            ]);
            return redirect()->back()->with('message', 'Soal True And False berhasil dibuat ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat membuat soal');
        }
    }
    public function CreateJenis5(Request $request, $id)
    {
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
            return redirect()->back()->with('error', 'Ada yang terlewat');
        }

        $jawaban_jdh = json_encode($jawaban_jdh_filtered);
        $soal_jdh_array = json_encode($soal_jdh_array_filtered);
        $kunci = json_encode($kunci_filtered);
        try {
            Soal::create([
                'soal' => $request->soal,
                'jenis_soal' => 5,
                'folder_bs' => $id,
                'kunci' => $kunci,
                'jawaban_jdh' => $jawaban_jdh,
                'soal_jdh_array' => $soal_jdh_array,
            ]);
            return redirect()->back()->with('message', 'Soal menjodohkan berhasil dibuat ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat membuat soal');
        }
    }

    //edit
    public function EditJenis1(Request $request, $id, $ids)
    {
        //dd($ids);
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'soal' => Soal::where('id', $ids)->first(),
        ];
        return view('guru.folder.soal.jenis.edit_jenis1', $data)->with('sb', 'Bank Soal');
    }
    public function EditJenis2(Request $request, $id, $ids)
    {
        //dd($ids);
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'soal' => Soal::where('id', $ids)->first(),
        ];
        return view('guru.folder.soal.jenis.edit_jenis2', $data)->with('sb', 'Bank Soal');
    }
    public function EditJenis3(Request $request, $id, $ids)
    {
        //dd($ids);
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'soal' => Soal::where('id', $ids)->first(),
        ];
        return view('guru.folder.soal.jenis.edit_jenis3', $data)->with('sb', 'Bank Soal');
    }
    public function EditJenis4(Request $request, $id, $ids)
    {
        //dd($ids);
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'soal' => Soal::where('id', $ids)->first(),
        ];
        return view('guru.folder.soal.jenis.edit_jenis4', $data)->with('sb', 'Bank Soal');
    }
    public function EditJenis5(Request $request, $id, $ids)
    {
        //dd($ids);
        $data = [
            'kelas' => Kelas::orderBy('tingkat_kelas', 'asc')->get(),
            'folder' => Folder::where('id', $id)->first(),
            'soal' => Soal::where('id', $ids)->first(),
        ];
        return view('guru.folder.soal.jenis.edit_jenis5', $data)->with('sb', 'Bank Soal');
    }
    //update
    public function UpdatedJenis1(Request $request, $id, $ids)
    {
        //dd($request->all());
        try {
            Soal::where('id', $ids)->update([
                'soal' => $request->soal,
                'pil_1' => $request->pil_1,
                'pil_2' => $request->pil_2,
                'pil_3' => $request->pil_3,
                'pil_4' => $request->pil_4,
                'pil_5' => $request->pil_5,
                'folder_bs' => $id,
                'kunci' => $request->kunci,
            ]);
            return redirect()->back()->with('message', 'Soal pilihan ganda berhasil diedit ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat mengedit soal');
        }
    }
    public function UpdatedJenis2(Request $request, $id, $ids)
    {
        //dd($request->all());
        try {
            Soal::where('id', $ids)->update([
                'soal' => $request->soal,
                'pil_1' => $request->pil_1,
                'pil_2' => $request->pil_2,
                'pil_3' => $request->pil_3,
                'pil_4' => $request->pil_4,
                'pil_5' => $request->pil_5,
                'folder_bs' => $id,
                'kunci' => json_encode($request->kunci),
            ]);
            return redirect()->back()->with('message', 'Soal pilihan ganda komplex berhasil diedit ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat mengedit soal');
        }
    }
    public function UpdatedJenis3(Request $request, $id, $ids)
    {
        //dd($request->all());
        try {
            Soal::where('id', $ids)->update([
                'soal' => $request->soal,
                'jawaban_singkat' => $request->jawaban_singkat,
                'jenis_hrf' => json_encode($request->jenis_hrf),
                'jenis_inp' => json_encode($request->jenis_inp),
                'folder_bs' => $id,
            ]);
            return redirect()->back()->with('message', 'Soal Essay berhasil diedit ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat mengedit soal');
        }
    }
    public function UpdatedJenis4(Request $request, $id, $ids)
    {
        //dd($request->all());
        try {
            Soal::where('id', $ids)->update([
                'soal' => $request->soal,
                'folder_bs' => $id,
                'kunci' => $request->kunci,
            ]);
            return redirect()->back()->with('message', 'Soal True and False berhasil diedit ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat mengedit soal');
        }
    }
    public function UpdatedJenis5(Request $request, $id, $ids)
    {
        //dd($request->all());
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
            return redirect()->back()->with('error', 'Ada yang terlewat');
        }

        $jawaban_jdh = json_encode($jawaban_jdh_filtered);
        $soal_jdh_array = json_encode($soal_jdh_array_filtered);
        $kunci = json_encode($kunci_filtered);
        try {
            Soal::where('id', $ids)->update([
                'soal' => $request->soal,
                'folder_bs' => $id,
                'kunci' => $kunci,
                'jawaban_jdh' => $jawaban_jdh,
                'soal_jdh_array' => $soal_jdh_array,
            ]);
            return redirect()->back()->with('message', 'Soal menjodohkan berhasil diedit ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat membuat soal');
        }
    }

    public function delete(Request $request, $id)
    {
        if (!$request->id) {
            return redirect()->back()->with('message', 'Minimal Pilih 1 soal.');
        } else {
            $total = count($request->id);
            foreach ($request->id as $id) {
                Soal::where('id', $id)->delete();
            }
            return redirect()
                ->back()
                ->with('message', "$total  Berhasil dihapus");
        }
    }
}
