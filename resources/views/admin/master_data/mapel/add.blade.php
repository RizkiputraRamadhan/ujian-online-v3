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
                        action="{{ url('admin/master-data/mapel/add') }}" novalidate="">
                        <div class="card-header">
                            <h4><i class="fa-solid fa-book-open-reader far"></i> Form Tambah Mapel</h4>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Pilih Sekolah</label>
                                <div class="col-sm-9">
                                    <select name="sekolah_id" id="sekolah_id" class="form-control" required="">
                                        <option value="">- PILIH SEKOLAH -</option>
                                        @foreach ($sekolah as $s)
                                            <option value="{{ $s->id }}">- {{ $s->nama }} ( T.A
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
                                    </select>
                                    <div class="invalid-feedback">
                                        Masukkan Guru Pengampu
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Mapel</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Masukkan Nama Mapel" name="nama_mapel"
                                        class="form-control" required="">
                                    <div class="invalid-feedback">
                                        Masukkan Nama Mapel
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">KKM</label>
                                <div class="col-sm-9">
                                    <input type="number" name="kkm" id="" placeholder="Masukkan KKM" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        Masukkan KKM Mapel
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Jumlah Soal</label>
                                <div class="col-sm-9">
                                    <input type="number" name="jumlah_soal" id="" required="" placeholder="Masukkan Jumlah Soal" class="form-control">
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
                                        <option value="Y">- ACAK SOAL -</option>
                                        <option value="N">- JANGAN ACAK SOAL -</option>
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
                                        <option value="Y">- UMUMKAN NILAI -</option>
                                        <option value="N">- JANGAN UMUMKAN NILAI -</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih Umumkan Nilai
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Simpan</button>
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
        });
    </script>
@endsection
