@extends('master')
@section('title', 'Data Mapel - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <form class="needs-validation" method="POST"
                        id="formUpdate" novalidate="">
                        <div class="card-header">
                            <h4><i class="fa-solid fa-book-open-reader far"></i> Form Update Mapel</h4>
                        </div>
                        @foreach($mapel as $m)
                        <input type="hidden" name="id" value="{{$m->id}}">
                        <div class="card-body">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Pilih Sekolah</label>
                                <div class="col-sm-9">
                                    <select name="sekolah_id" id="sekolah_id" class="form-control" required="">
                                        <option value="">- PILIH SEKOLAH -</option>
                                        @foreach ($sekolah as $s)
                                            <option {{($guru_selected?->sekolah_id == $s->id) ? "selected" : ""}} value="{{ $s->id }}">- {{ $s->nama }} ( T.A
                                                {{ $s->tahun }} ) (SEMESTER {{$s->semester}}) -</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih Sekolah
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Pilih Kelas</label>
                                <div class="col-sm-9">
                                    <select name="kelas_id[]" multiple="multiple" id="kelas_id" class="form-control" data-height="100%"
                                        required="">
                                        @foreach($kelas as $k)
                                            <option
                                            {{(\App\Models\MapelKelas::validate($m->id, $k->id) != null) ? "selected" : ""}}
                                            value="{{$k->id}}">- KELAS {{$k->tingkat_kelas}} ( {{$k->urusan_kelas}} ) ( {{$k->jurusan}} )</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih kelas untuk mapel ini
                                    </div>
                                </div>
                            </div><br>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Guru Pengampu</label>
                                <div class="col-sm-9">
                                    <select name="guru_id" id="guru_id" class="form-control select2" required="">
                                        @foreach($guru_all as $g)
                                        <option {{($g->id == $guru_selected?->id) ? "selected" : ""}} value="{{$g->id}}">{{$g->nama}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Masukkan Guru Pengampu
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Mapel</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$m->nama_mapel}}" placeholder="Masukkan Nama Mapel" name="nama_mapel"
                                        class="form-control" required="">
                                    <div class="invalid-feedback">
                                        Masukkan Nama Mapel
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">KKM</label>
                                <div class="col-sm-9">
                                    <input type="number" value="{{$m->kkm}}" name="kkm" id="" placeholder="Masukkan KKM" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        Masukkan KKM Mapel
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Jumlah Soal</label>
                                <div class="col-sm-9">
                                    <input type="number" value="{{$m->jumlah_soal}}" name="jumlah_soal" id="" required="" placeholder="Masukkan Jumlah Soal" class="form-control">
                                    <div class="invalid-feedback">
                                        Masukkan Jumlah Soal
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Acak Soal</label>
                                <div class="col-sm-9">
                                    <select required="" name="acak_soal" id="" class="form-control">
                                        <option value="">- PILIH INPUTAN -</option>
                                        <option {{($m->acak_soal == "Y") ? "selected" : ""}} value="Y">- ACAK SOAL -</option>
                                        <option {{($m->acak_soal == "N") ? "selected" : ""}} value="N">- JANGAN ACAK SOAL -</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih Acak Soal
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Umumkan Nilai</label>
                                <div class="col-sm-9">
                                    <select required="" name="umumkan_nilai" id="" class="form-control">
                                        <option value="">- PILIH INPUTAN -</option>
                                        <option {{($m->umumkan_nilai == "Y") ? "selected" : ""}} value="Y">- UMUMKAN NILAI -</option>
                                        <option {{($m->umumkan_nilai == "N") ? "selected" : ""}} value="N">- JANGAN UMUMKAN NILAI -</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih Umumkan Nilai
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#sekolah_id').on('change', function(){
                $('#guru_id').find('option').remove().end();
                $('#kelas_id').find('option').remove().end();

                $.ajax({
                    data: {
                        'id': $(this).val(),
                    },
                    type: 'GET',
                    url: "{{ url('admin/master-data/mapel/kelas-guru') }}",
                    success: function(data) {
                        $.each(data.guru, function(i, data) {
                            $('#guru_id').append($('<option>', {
                                value: data.id,
                                text: '-  ' + data.nama +
                                    ' ( ' + data.nip_nik_nisn +
                                    ' ) '
                            }));
                        });
                        $.each(data.kelas, function(i, data) {
                            $('#kelas_id').append($('<option>', {
                                value: data.id,
                                text: '-  KELAS ' + data.tingkat_kelas +
                                    ' ( ' + data.urusan_kelas +
                                    ' ) ' + '( '+data.jurusan+' )'
                            }));
                        });
                    },
                    error: function(err) {
                        alert(err);
                        console.log(err);
                    }
                });
            });
            $('#formUpdate').submit(function(e) {
                e.preventDefault()
                $.ajax({
                    data: $(this).serialize(),
                    type: 'PUT',
                    url: "{{ url('admin/master-data/mapel') }}",
                    beforeSend: function() {
                        $.LoadingOverlay("show", {
                            image: "",
                            fontawesome: "fa fa-cog fa-spin"
                        });
                    },
                    complete: function() {
                        $.LoadingOverlay("hide", {
                            image: "",
                            fontawesome: "fa fa-cog fa-spin"
                        });
                    },
                    success: function(data) {
                        swal(data.message)
                            .then((result) => {
                                location.reload();
                            });
                    },
                    error: function(err) {
                        alert(err);
                        console.log(err);
                    }
                });
            });
        });
    </script>
@endsection
