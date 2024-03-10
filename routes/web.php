<?php

//----------------------------------------------------------------------
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Guru\SoalController;
use App\Http\Controllers\IntegrateController;
use App\Http\Controllers\Guru\FolderBsController;
use App\Http\Controllers\Guru\MapelController as MapelGuru;
use App\Http\Controllers\Guru\NilaiController as NilaiGuru;
use App\Http\Controllers\Guru\UjianController as UjianGuru;
use App\Http\Controllers\Admin\Migrasi\MigrasiGuruController;
use App\Http\Controllers\Siswa\UjianController as UjianSiswa;
//--------------------------------------------------------------------------
use App\Http\Controllers\Admin\Migrasi\MigrasiKelasController;
use App\Http\Controllers\Admin\Migrasi\MigrasiMapelController;
//----------------------------------------------------------------------
use App\Http\Controllers\Admin\Migrasi\MigrasiSiswaController;
use App\Http\Controllers\Guru\BankSoalController as BankSoalGuru;
use App\Http\Controllers\Guru\DashboardController as DashboardGuru;
use App\Http\Controllers\Admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\Siswa\DashboardController as DashboardSiswa;
//----------------------------------------------------------------------------
use App\Http\Controllers\Admin\MasterData\GuruController as GuruAdmin;
use App\Http\Controllers\Admin\MasterData\KelasController as KelasAdmin;
//----------------------------------------------------------------------
use App\Http\Controllers\Admin\MasterData\MapelController as MapelAdmin;
use App\Http\Controllers\Admin\MasterData\SiswaController as SiswaAdmin;
use App\Http\Controllers\Admin\Monitoring\UjianController as UjianAdmin;
use App\Http\Controllers\Admin\Monitoring\JadwalController as JadwalAdmin;
use App\Http\Controllers\Admin\MasterData\SekolahController as SekolahAdmin;
use App\Http\Controllers\Admin\MasterData\BankSoalController as BankSoalAdmin;
use App\Http\Controllers\Admin\MasterData\TahunAjaranController as TahunAjaranAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index']);
// Login
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);
Route::post('blokir', [UjianAdmin::class, 'blokir']);

// Report
Route::prefix('report')->withoutMiddleware(['guru', 'siswa'])->group(function () {
    // Berita Acara
    Route::get('berita-acara/{jadwal_id}/{kelas_id}/{sekolah_id}', [ReportController::class, 'berita_acara']);
    // Daftar Hadir
    Route::get('daftar-hadir/{jadwal_id}/{kelas_id}/{sekolah_id}', [ReportController::class, 'daftar_hadir_ujian']);
    // Daftar Tidak Hadir
    Route::get('daftar-tidak-hadir/{jadwal_id}/{kelas_id}/{sekolah_id}', [ReportController::class, 'daftar_tidak_hadir_ujian']);
    // Kartu Ujian
    Route::get('kartu-ujian/{kelas_id}/{sekolah_id}', [ReportController::class, 'kartu_ujian']);
    // Nilai All PDF
    Route::get('nilai/{jadwal_id}/{kelas_id}/{sekolah_id}/{mapel_id}', [ReportController::class, 'nilai_pdf']);
    // Nilai Mengulang PDF
    Route::get('mengulang/{jadwal_id}/{kelas_id}/{sekolah_id}/{mapel_id}', [ReportController::class, 'nilai_mengulang']);
    // Nilai Excel
    Route::get('nilai-excel/{jadwal_id}/{kelas_id}/{sekolah_id}/{mapel_id}', [ReportController::class, 'nilai_excel']);
});

// Admin
Route::prefix('admin')->middleware('admin')->group(function () {
    // Dashboard
    Route::prefix('/')->group(function () {
        // Dashboard Index
        Route::get('/', [DashboardAdmin::class, 'index']);
        // Data Master
        Route::get('master-data-table', [DashboardAdmin::class, 'master_data']);
        // Jadwal Hari Ini
        Route::get('jadwal-hari-ini', [DashboardAdmin::class, 'jadwal_hari_ini']);
    });
    // Master Data
    Route::prefix('master-data')->group(function () {
        // Tahun Ajaran
        Route::prefix('tahun-ajaran')->group(function () {
            // Index
            Route::get('/', [TahunAjaranAdmin::class, 'index']);
            // Create
            Route::post('/', [TahunAjaranAdmin::class, 'create']);
            // Get All
            Route::get('all', [TahunAjaranAdmin::class, 'getall']);
            // Get
            Route::post('get', [TahunAjaranAdmin::class, 'get']);
            // Update
            Route::post('update', [TahunAjaranAdmin::class, 'update']);
            // Delete
            Route::delete('/', [TahunAjaranAdmin::class, 'delete']);
        });
        // Sekolah
        Route::prefix('sekolah')->group(function () {
            // Index
            Route::get('/', [SekolahAdmin::class, 'index']);
            // Create View
            Route::get('add', [SekolahAdmin::class, 'create_view']);
            // Create
            Route::post('add', [SekolahAdmin::class, 'create']);
            // Get All
            Route::get('all', [SekolahAdmin::class, 'getall']);
            // Delete
            Route::delete('/', [SekolahAdmin::class, 'delete']);
            // Get
            Route::get('update/{id}', [SekolahAdmin::class, 'get']);
            // Update
            Route::post('update', [SekolahAdmin::class, 'update']);
        });
        // Kelas
        Route::prefix('kelas')->group(function () {
            // Index
            Route::get('/', [KelasAdmin::class, 'index']);
            // Create
            Route::post('/', [KelasAdmin::class, 'create']);
            // Get All
            Route::get('all', [KelasAdmin::class, 'getall']);
            // Get
            Route::post('get', [KelasAdmin::class, 'get']);
            // Update
            Route::post('update', [KelasAdmin::class, 'update']);
            // Delete
            Route::delete('/', [KelasAdmin::class, 'delete']);
        });
        // Guru
        Route::prefix('guru')->group(function () {
            // Index
            Route::get('/', [GuruAdmin::class, 'index']);
            // Get All
            Route::get('all', [GuruAdmin::class, 'getall']);
            // Create
            Route::post('/', [GuruAdmin::class, 'create']);
            // Update
            Route::post('update', [GuruAdmin::class, 'update']);
            // Delete
            Route::delete('/', [GuruAdmin::class, 'delete']);
            // Get
            Route::post('get', [GuruAdmin::class, 'get']);
            // Import
            Route::post('import', [GuruAdmin::class, 'import']);
        });
        // Siswa
        Route::prefix('siswa')->group(function () {
            // Index
            Route::get('/', [SiswaAdmin::class, 'index']);
            // Get Kelas
            Route::get('kelas', [SiswaAdmin::class, 'getkelas']);
            // Create
            Route::post('/', [SiswaAdmin::class, 'create']);
            // Get All
            Route::get('all', [SiswaAdmin::class, 'getall']);
            // Get
            Route::post('get', [SiswaAdmin::class, 'get']);
            // Update
            Route::put('/', [SiswaAdmin::class, 'update']);
            // Delete
            Route::delete('/', [SiswaAdmin::class, 'delete']);
            // Import
            Route::post('import', [SiswaAdmin::class, 'import']);
        });
        // Mapel
        Route::prefix('mapel')->group(function () {
            // Index
            Route::get('/', [MapelAdmin::class, 'index']);
            // Create View
            Route::get('add', [MapelAdmin::class, 'create_view']);
            // Get Kelas Guru
            Route::get('/kelas-guru', [MapelAdmin::class, 'getkelasguru']);
            // Create
            Route::post('add', [MapelAdmin::class, 'create']);
            // Get All
            Route::get('all', [MapelAdmin::class, 'getall']);
            // Update View
            Route::get('update/{mapel_id}/{sekolah_id}', [MapelAdmin::class, 'get']);
            // Update
            Route::put('/', [MapelAdmin::class, 'update']);
            // Delete
            Route::delete('/', [MapelAdmin::class, 'delete']);
        });
        // Soal
        Route::prefix('soal')->group(function () {
            // Index
            Route::get('view/{mapel_id}/{sekolah_id}', [BankSoalAdmin::class, 'index']);
            //bank soal
            Route::get('view/{mapel_id}/{sekolah_id}/{mapelID}/banksoal', [BankSoalAdmin::class, 'bankSoal']);
            Route::post('view/{mapel_id}/{sekolah_id}/{mapelID}/banksoal', [BankSoalAdmin::class, 'CreateBankSoal']);
            // Create
            Route::post('/', [BankSoalAdmin::class, 'create']);
            // Get
            Route::post('get', [BankSoalAdmin::class, 'get']);
            // Update
            Route::put('/', [BankSoalAdmin::class, 'update']);
            // Delete
            Route::delete('/', [BankSoalAdmin::class, 'delete']);
            // Import
            Route::post('import', [BankSoalAdmin::class, 'import']);
        });
    });
    // Monitoring
    Route::prefix('monitoring')->group(function () {
        // Jadwal
        Route::prefix('jadwal')->group(function () {
            // Index
            Route::get('/', [JadwalAdmin::class, 'index']);
            // All
            Route::get('all', [JadwalAdmin::class, 'getall']);
            // Jadwal Setting
            Route::get('setting/{mapel_id}/{sekolah_id}/{tahunajaran_id}', [JadwalAdmin::class, 'create_view']);
            // Get Jadwal Masing2 Kelas
            Route::get('setting/detail', [JadwalAdmin::class, 'detail_jadwal']);
            // Get Detail Jadwal
            Route::post('setting/detail', [JadwalAdmin::class, 'get_detail_jadwal']);
            // Simpan Jadwal
            Route::post('setting', [JadwalAdmin::class, 'create_or_update']);
        });
        // Ujian
        Route::prefix('ujian')->group(function () {
            // Index
            Route::get('/', [UjianAdmin::class, 'index']);
            // All
            Route::get('all', [UjianAdmin::class, 'getall']);
            // Detail Ujian
            Route::get('detail/{jadwal_id}/{kelas_id}/{sekolah_id}', [UjianAdmin::class, 'view_ujian']);
            // Settings Ujian
            Route::post('detail/{jadwal_id}/{kelas_id}/{sekolah_id}', [UjianAdmin::class, 'settings']);
            // Set Kehadiran
            Route::post('kehadiran', [UjianAdmin::class, 'create_or_update_kehadiran']);
            // Blokir-Unblokir
            Route::post('blokir', [UjianAdmin::class, 'update_status_blokir_ujian']);
            // Reset Ujian
            Route::post('reset', [UjianAdmin::class, 'reset_ujian']);
            // Preview Ujian
            Route::get('preview/{jadwal_id}/{nomor_ujian}/{sekolah_id}/{kehadiran_id}', [UjianAdmin::class, 'previewUjian']);
        });
    });
    // Migrasi
    Route::prefix('migrasi')->group(function () {
        # Data Kelas
        Route::prefix('kelas')->group(function () {
            # Index
            Route::get('/', [MigrasiKelasController::class, 'index']);
            # Migrasi Kelas
            Route::post('/', [MigrasiKelasController::class, 'migrasiKelas']);
        });
        # Data Guru
        Route::prefix('guru')->group(function () {
            # Index
            Route::get('/', [MigrasiGuruController::class, 'index']);
            # Migrasi Guru
            Route::post('/', [MigrasiGuruController::class, 'migrasiGuru']);
        });
        # Data Siswa
        Route::prefix('siswa')->group(function () {
            # Index
            Route::get('/', [MigrasiSiswaController::class, 'index']);
            # Migrasi Siswa
            Route::post('/', [MigrasiSiswaController::class, 'migrasiSiswa']);
        });
        # Data Mapel
        Route::prefix('mapel')->group(function () {
            # Index
            Route::get('/', [MigrasiMapelController::class, 'index']);
            # Migrasi Siswa
            Route::post('/', [MigrasiMapelController::class, 'migrasiMapel']);
        });
    });
    // Profile
    Route::post('profile', [ProfileController::class, 'updateAdmin']);
});

// Guru
Route::prefix('guru')->middleware('guru')->group(function () {
    // Dashboard
    Route::prefix('/')->group(function () {
        // Dashboard Index
        Route::get('/', [DashboardGuru::class, 'index']);
        // Jadwal Hari Ini
        Route::get('jadwal-hari-ini', [DashboardGuru::class, 'jadwal_hari_ini']);
    });
     // folder
    Route::prefix('folder')->group(function () {
        // Folder Bank Soal Index
        Route::get('/', [FolderBsController::class, 'index']);
         // Folder Bank Soal create
        Route::post('/', [FolderBsController::class, 'create']);
         // Folder Bank Soal edit
        Route::get('/edit/{id}', [FolderBsController::class, 'edit']);
         // Folder Bank Soal edit
        Route::post('/edit/{id}', [FolderBsController::class, 'update']);
        // Folder Bank Soal delete
        Route::post('/delete/{id}', [FolderBsController::class, 'delete']);

            Route::prefix('soal')->group(function () {
                Route::get('/{id}', [SoalController::class, 'index']);
                Route::get('/{id}/1', [SoalController::class, 'jenis1']);
                Route::get('/{id}/2', [SoalController::class, 'jenis2']);
                Route::get('/{id}/3', [SoalController::class, 'jenis3']);
                Route::get('/{id}/4', [SoalController::class, 'jenis4']);
                Route::get('/{id}/5', [SoalController::class, 'jenis5']);
                //Soal create
                Route::post('/{id}/1', [SoalController::class, 'CreateJenis1']);
                Route::post('/{id}/2', [SoalController::class, 'CreateJenis2']);
                Route::post('/{id}/3', [SoalController::class, 'CreateJenis3']);
                Route::post('/{id}/4', [SoalController::class, 'CreateJenis4']);
                Route::post('/{id}/5', [SoalController::class, 'CreateJenis5']);
                //Soal edit
                Route::get('/{id}/1/{ids}', [SoalController::class, 'EditJenis1']);
                Route::get('/{id}/2/{ids}', [SoalController::class, 'EditJenis2']);
                Route::get('/{id}/3/{ids}', [SoalController::class, 'EditJenis3']);
                Route::get('/{id}/4/{ids}', [SoalController::class, 'EditJenis4']);
                Route::get('/{id}/5/{ids}', [SoalController::class, 'EditJenis5']);
                //Soal updated
                Route::post('/{id}/1/{ids}', [SoalController::class, 'UpdatedJenis1']);
                Route::post('/{id}/2/{ids}', [SoalController::class, 'UpdatedJenis2']);
                Route::post('/{id}/3/{ids}', [SoalController::class, 'UpdatedJenis3']);
                Route::post('/{id}/4/{ids}', [SoalController::class, 'UpdatedJenis4']);
                Route::post('/{id}/5/{ids}', [SoalController::class, 'UpdatedJenis5']);

                //Soal delete
                Route::delete('/{id}/delete', [SoalController::class, 'delete']);
            });

            Route::prefix('migrasi')->group(function () {
                Route::post('/', [FolderBsController::class, 'migrasi']);
                // Folder Bank Soal delete
            });
    });
    // Mapel
    Route::prefix('mapel')->group(function () {
        // Data Mapel
        Route::get('/', [MapelGuru::class, 'index']);
        // Get All
        Route::get('all', [MapelGuru::class, 'getall']);
        // Detail Mapel
        Route::get('detail/{mapel_id}', [MapelGuru::class, 'get']);
    });
    // Soal
    Route::prefix('soal')->group(function () {
        // Index
        Route::get('view/{mapel_id}', [BankSoalGuru::class, 'index']);
        //bank soal
        Route::get('view/{mapel_id}/{mapelID}/banksoal', [BankSoalGuru::class, 'bankSoal']);
        Route::post('view/{mapel_id}/{mapelID}/banksoal', [BankSoalGuru::class, 'CreateBankSoal']);
        // Create
        Route::post('/', [BankSoalAdmin::class, 'create']);
        // Get
        Route::post('get', [BankSoalAdmin::class, 'get']);
        // Update
        Route::put('/', [BankSoalAdmin::class, 'update']);
        // Delete
        Route::delete('/', [BankSoalAdmin::class, 'delete']);
        // Import
        Route::post('import', [BankSoalAdmin::class, 'import']);
    });
    Route::prefix('nilai')->group(function () {
        // Index
        Route::get('mapel', [NilaiGuru::class,  'index']);
        // Get Mapel
        Route::get('mapel/get', [NilaiGuru::class, 'getmapel']);
        // Get Detail Jadwal In Mapel
        Route::get('jadwal/get', [NilaiGuru::class, 'detail_jadwal']);
        // Get Jadwal In Mapel
        Route::get('jadwal/{mapel_id}', [NilaiGuru::class, 'detail_view_jadwal']);
        // Get Nilai Tiap Jadwal
        Route::get('view/{mapel_id}/{jadwal_id}', [NilaiGuru::class, 'view_hasil_ujian']);
        // Preview Ujian
        Route::get('preview/ujian/{jadwal_id}/{nomor_ujian}/{sekolah_id}/{kehadiran_id}', [UjianAdmin::class, 'previewUjian']);
    });
    Route::prefix('ujian')->group(function () {
        // Index
        Route::get('/', [UjianGuru::class, 'index']);
        // Get Jadwal
        Route::get('all', [UjianGuru::class, 'getall']);
        // Detail
        Route::get('detail/{jadwal_id}/{kelas_id}', [UjianGuru::class, 'view_ujian']);
        // Set Kehadiran
        Route::post('kehadiran', [UjianAdmin::class, 'create_or_update_kehadiran']);
        // Blokir-Unblokir
        Route::post('blokir', [UjianAdmin::class, 'update_status_blokir_ujian']);
        // Reset Ujian
        Route::post('reset', [UjianAdmin::class, 'reset_ujian']);
    });
    // Profile
    Route::post('profile', [ProfileController::class, 'updateGuru']);
});


// Siswa
Route::prefix('siswa')->middleware('siswa')->group(function () {
    // Index
    Route::prefix('/')->group(function () {
        // Dashboard View
        Route::get('/', [DashboardSiswa::class, 'index']);
        // Get Ujian
        Route::get('all', [DashboardSiswa::class, 'getjadwal']);
    });
    // Ujian
    Route::prefix('ujian')->group(function () {
        // Detail Ujian
        Route::get('detail/{jadwal_id}', [UjianSiswa::class, 'index']);
        // View Ujian
        Route::get('view/{jadwal_id}/{nomor_ujian}', [UjianSiswa::class, 'view_ujian']);
        // Save Progress
        Route::post('progress', [UjianSiswa::class, 'saveJawaban']);
        // Progres Ragu Ragu
        Route::put('progress', [UjianSiswa::class, 'setJawabanYakinRaguRagu']);
        // Blokir Redirect
        Route::get('blokir', function () {
            return redirect()->to('siswa')->with('message', "Anda diblokir dari ujian");
        });
        // Preview Ujian
        Route::get('preview/{jadwal_id}/{nomor_ujian}', [UjianSiswa::class, 'preview']);
        // Simpan Ujian
        Route::post('submit', [UjianSiswa::class, 'submit_jawaban']);
    });
    // Profile
    Route::get('profile', [ProfileController::class, 'profileSiswa']);
});

// integrate
Route::prefix('integrate')->middleware(['integrate', 'cors'])->group(function () {
    // get sekolah
    Route::get('get-sekolah', [IntegrateController::class, 'getSekolah']);
    // get kelas
    Route::get('get-kelas', [IntegrateController::class, 'getKelas']);
    // create akun siswa
    Route::post('create-siswa', [IntegrateController::class, 'createSiswa']);
    // get status siswa in table
    Route::post('status-cbt', [IntegrateController::class, 'getStatusCBT']);
    // get detail siswa cbt
    Route::post('detail-cbt', [IntegrateController::class, 'getDetailCbt']);
    // hapus akun siswa
    Route::delete('delete-siswa', [IntegrateController::class, 'deleteAkunSiswa']);
});
