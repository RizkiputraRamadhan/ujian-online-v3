@extends('master')
@section('title', 'Edit Data Sekolah - ')
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
                    <form enctype="multipart/form-data" class="needs-validation" method="POST"
                        action="{{ url('admin/master-data/sekolah/update') }}" novalidate="">
                        <div class="card-header">
                            <h4><i class="fa-solid fa-school text-primary"></i> Form Edit Data Sekolah</h4>
                        </div>
                        @foreach ($sekolah as $s)
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="id" value="{{$s->id}}">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Instansi</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $s->instansi }}" placeholder="Masukkan Instansi"
                                            name="instansi" class="form-control" required="">
                                        <div class="invalid-feedback">
                                            Masukkan Instansi
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Sekolah</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $s->nama }}"
                                            placeholder="Masukkan Nama Sekolah" name="nama" class="form-control"
                                            required="">
                                        <div class="invalid-feedback">
                                            Masukkan Nama Sekolah
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Tahun Ajaran Aktif</label>
                                    <div class="col-sm-9">
                                        <select name="tahunajaran_id" class="form-control" required="">
                                            <option value="">- PILIH TAHUN AJARAN -</option>
                                            @foreach ($tahun_ajaran as $ta)
                                                <option {{ $ta->id == $s->tahunajaran_id ? 'selected' : '' }}
                                                    value="{{ $ta->id }}">- {{ $ta->tahun }} -</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih Tahun Ajaran Aktif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Semester Aktif</label>
                                    <div class="col-sm-9">
                                        <select name="semester" class="form-control" required="">
                                            <option value="">- PILIH SEMESTER -</option>
                                            <option {{ $s->semester == 'GANJIL' ? 'selected' : '' }} value="GANJIL">-
                                                GANJIL -</option>
                                            <option {{ $s->semester == 'GENAP' ? 'selected' : '' }} value="GENAP">-
                                                GENAP -</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih Semester Aktif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Level Sekolah</label>
                                    <div class="col-sm-9">
                                        <select name="level" class="form-control" required="">
                                            <option value="">- PILIH LEVEL SEKOLAH -</option>
                                            <option {{ $s->level == 'MI' ? 'selected' : '' }} value="MI">- MI -
                                            </option>
                                            <option {{ $s->level == 'MTS' ? 'selected' : '' }} value="MTS">- MTS -
                                            </option>
                                            <option {{ $s->level == 'MA' ? 'selected' : '' }} value="MA">- MA -
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih Level Sekolah
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nomor Telpon</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $s->no_telp }}"
                                            placeholder="Masukkan Nomor Telpon" name="no_telp" class="form-control"
                                            required="">
                                        <div class="invalid-feedback">
                                            Masukkan Nomor Telpon
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email Sekolah</label>
                                    <div class="col-sm-9">
                                        <input type="email" value="{{ $s->email }}"
                                            placeholder="Masukkan Email Sekolah" name="email" class="form-control"
                                            required="">
                                        <div class="invalid-feedback">
                                            Masukkan Email Sekolah
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Alamat Sekolah</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $s->alamat }}"
                                            placeholder="Masukkan Alamat Sekolah" name="alamat" class="form-control"
                                            required="">
                                        <div class="invalid-feedback">
                                            Masukkan Alamat Sekolah
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">NIP Kamad</label>
                                    <div class="col-sm-9">
                                        <input type="number" value="{{ $s->nip_kamad }}" name="nip_kamad"
                                            placeholder="Masukkan NIP Kamad" class="form-control">
                                        <div class="valid-feedback">
                                            Inputan Ini Optional
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Kamad</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $s->nama_kamad }}" name="nama_kamad"
                                            required="" placeholder="Masukkan Nama Kamad" class="form-control">
                                        <div class="invalid-feedback">
                                            Masukkan Nama Kamad
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
    <div class="modal fade" id="prevModal" tabindex="-1" aria-labelledby="prevModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="prevModal">Preview Logo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="#" alt="" class="img-fluid logo-prev" width="200" srcset="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.show-logo').click(function(e) {
            e.preventDefault();
            $('.logo-prev').attr('src', "{{ url('assets/logo') }}" + '/' + $(this).data('logo'))
            $('#prevModal').modal('show');
        });
    </script>
@endsection
