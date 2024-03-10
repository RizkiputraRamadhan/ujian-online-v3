@extends('siswa.master')
@section('title', 'Detail Ujian - ')
@section('content')
    <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="{{ url('siswa') }}" class="nav-link"><i class="fa-solid fa-globe"></i><span>Jadwal
                            Ujian</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('siswa/profile') }}" class="nav-link"><i class="fa-solid fa-user"></i><span>Profil
                            Saya</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-content">
        @if ($setting->blok_kecurangan == 'Y')
            <div class="alert alert-light alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Keterangan Fitur Anti Cheattings</div>
                    1. Tidak diperbolehkan berganti browser pada saat memulai ujian<br>
                    2. Tidak diperbolehkan menambah tab baru pada browser ujian<br>
                    3. Tidak diperbolehkan membuka aplikasi lain selain halaman ujian<br>
                    4. Tidak diperbolehkan screenshot halaman ujian<br>
                    5. Jika melanggar pasal 1,2,3,4 maka akan <b>TERBLOKIR OTOMATIS</b><br>
                </div>
            </div>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Fitur anti cheatting diaktifkan
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <section class="section">
            <div class="section-body" style="margin-top: -10px;">
                <div class="card">
                    <div class="card-header">
                        <h4>Perhatikan baik-baik informasi dibawah</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tahun Ajaran</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ $jadwal?->tahun }}" name="" id=""
                                    class="form-control bg-white" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mapel</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ $jadwal?->nama_mapel }}" name="" id=""
                                    class="form-control bg-white" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tanggal Ujian</label>
                            <div class="col-sm-9">
                                @if ($jadwal != null)
                                    <input type="text"
                                        value="{{ Illuminate\Support\Carbon::createFromFormat('Y-m-d', $jadwal?->tanggal)->isoFormat('D MMMM Y') }}"
                                        name="" id="" class="form-control bg-white" readonly>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mulai / Selesai</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ $jadwal?->jam_mulai . ' - ' . $jadwal?->jam_selesai }}"
                                    name="" id="" class="form-control bg-white" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Guru Pengampu</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ \App\Models\Guru::get($jadwal?->guru_id)?->nama }}"
                                    name="" id="" class="form-control bg-white" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Guru Pengawas</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ $jadwal?->pengawas }}" name="" id=""
                                    class="form-control bg-white" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kehadiran</label>
                            <div class="col-sm-9">
                                <input type="text"
                                    value="{{ $kehadiran?->status_kehadiran == null ? 'BELUM DIATUR PENGAWAS' : $kehadiran?->status_kehadiran }}"
                                    name="" id="" class="form-control bg-white" readonly>
                            </div>
                        </div>
                        @if ($kehadiran?->status_ujian == 'SELESAI' && $mapel?->umumkan_nilai == 'Y')
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nilai Anda</label>
                                <div class="col-sm-9">
                                    <input type="text"
                                        value="{{ \App\Models\BankJawaban::getNilai($kehadiran?->id, $mapel?->id, request()->session()->get('id')) }}"
                                        name="" id="" class="form-control bg-white" readonly>
                                    <small class="text-success">
                                        <b>Total Benar
                                            {{ \App\Models\BankJawaban::getBenar($kehadiran?->id, $mapel?->id, request()->session()->get('id')) }}
                                        </b>
                                    </small>
                                    <small class="text-danger">
                                        <b>Total Salah
                                            {{ \App\Models\BankJawaban::getSalah($kehadiran?->id, $mapel?->id, request()->session()->get('id')) }}
                                        </b>
                                    </small>
                                    <small class="text-warning">
                                        <b>Total Tidak Dijawab
                                            {{ \App\Models\BankJawaban::getTidakDijawab($kehadiran?->id, $mapel?->id, request()->session()->get('id')) }}
                                        </b>
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Status Ujian</label>
                                @php $nilai = \App\Models\BankJawaban::getNilai($kehadiran?->id, $mapel?->id, request()->session()->get('id')) @endphp
                                <div class="col-sm-9">
                                    <input type="text"
                                        value="{{ $nilai >= $mapel?->kkm ? 'LULUS UJIAN' : 'MENGULANG' }}"
                                        name="" id="" class="form-control bg-white" readonly>
                                    <small class="text-black">
                                        <b>KKM MAPEL : {{ $mapel?->kkm }}</b>
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        @if ($button_status && $kehadiran?->status_kehadiran == 'HADIR')
                            <a href="{{ url('siswa/ujian/view/' . $jadwal?->id . '/' . $kehadiran?->no_peserta) }}"
                                type="button" class="btn btn-primary" style="float: right;">
                                {{ $kehadiran?->status_ujian == 'MENGERJAKAN' ? 'Lanjutkan' : 'Mulai Ujian' }}
                            </a>
                        @endif
                        @if ($kehadiran?->status_blokir == 'Y')
                            <i class="text-danger">Anda diblokir dari ujian ini</i>
                        @endif
                        @if ($kehadiran?->status_ujian == 'SELESAI')
                            <i class="text-success">Ujian telah anda selesaikan</i>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
