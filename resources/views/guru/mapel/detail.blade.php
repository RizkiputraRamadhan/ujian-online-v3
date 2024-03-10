@extends('master')
@section('title', 'Detail Mapel - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
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

                <div class="card">
                    <form class="needs-validation" method="POST"
                        novalidate="">
                        <div class="card-header">
                            <h4>Data Mapel</h4>
                        </div>
                        @foreach($mapel as $m)
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sekolah</label>
                                <div class="col-sm-9">
                                    <select name="sekolah_id" disabled id="sekolah_id" class="form-control bg-white" required="">
                                        <option value="">- PILIH SEKOLAH -</option>
                                        @foreach ($sekolah as $s)
                                            <option {{($guru_selected?->sekolah_id == $s->id) ? "selected" : ""}} value="{{ $s->id }}">- {{ $s->nama }} ( T.A
                                                {{ $s->tahun }} ) (SEMESTER {{$s->semester}}) -</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kelas Diampu</label>
                                <div class="col-sm-9">
                                    <select name="kelas_id[]" disabled multiple="multiple" id="kelas_id" class="form-control bg-white" data-height="100%"
                                        required="">
                                        @foreach($kelas as $k)
                                            @if(\App\Models\MapelKelas::validate($m->id, $k->id) != null)
                                                <option
                                                {{(\App\Models\MapelKelas::validate($m->id, $k->id) != null) ? "selected" : ""}}
                                                value="{{$k->id}}">- KELAS {{$k->tingkat_kelas}} ( {{$k->urusan_kelas}} ) ( {{$k->jurusan}} )</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div><br>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Guru Pengampu</label>
                                <div class="col-sm-9">
                                    <select name="guru_id" disabled id="guru_id" class="form-control bg-white" required="">
                                        @foreach($guru_all as $g)
                                        <option {{($g->id == $guru_selected?->id) ? "selected" : ""}} value="{{$g->id}}">{{$g->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Mapel</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly value="{{$m->nama_mapel}}" placeholder="Masukkan Nama Mapel" name="nama_mapel"
                                        class="form-control bg-white" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">KKM</label>
                                <div class="col-sm-9">
                                    <input type="number" readonly value="{{$m->kkm}}" name="kkm" id="" placeholder="Masukkan KKM" class="form-control bg-white" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Jumlah Soal</label>
                                <div class="col-sm-9">
                                    <input type="number" readonly value="{{$m->jumlah_soal}}" name="jumlah_soal" id="" required="" placeholder="Masukkan Jumlah Soal" class="form-control bg-white">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Acak Soal</label>
                                <div class="col-sm-9">
                                    <select required="" disabled name="acak_soal" id="" class="form-control bg-white">
                                        <option value="">- PILIH INPUTAN -</option>
                                        <option {{($m->acak_soal == "Y") ? "selected" : ""}} value="Y">- ACAK SOAL -</option>
                                        <option {{($m->acak_soal == "N") ? "selected" : ""}} value="N">- JANGAN ACAK SOAL -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Umumkan Nilai</label>
                                <div class="col-sm-9">
                                    <select required="" disabled name="umumkan_nilai" id="" class="form-control bg-white">
                                        <option value="">- PILIH INPUTAN -</option>
                                        <option {{($m->umumkan_nilai == "Y") ? "selected" : ""}} value="Y">- UMUMKAN NILAI -</option>
                                        <option {{($m->umumkan_nilai == "N") ? "selected" : ""}} value="N">- JANGAN UMUMKAN NILAI -</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
