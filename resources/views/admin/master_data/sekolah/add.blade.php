@extends('master')
@section('title', 'Tambah Data Sekolah - ')
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
                    <form enctype="multipart/form-data" class="needs-validation" method="POST" action="{{url('admin/master-data/sekolah/add')}}" novalidate="">
                        <div class="card-header">
                            <h4><i class="fa-solid fa-school text-primary"></i> Form Tambah Sekolah</h4>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Instansi</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Masukkan Instansi" name="instansi" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        Masukkan Instansi
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Sekolah</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Masukkan Nama Sekolah" name="nama" class="form-control" required="">
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
                                        @foreach($tahun_ajaran as $ta)
                                        <option value="{{$ta->id}}">- {{$ta->tahun}} -</option>
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
                                        <option value="GANJIL">- GANJIL -</option>
                                        <option value="GENAP">- GENAP -</option>
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
                                        <option value="MI">- MI -</option>
                                        <option value="MTS">- MTS -</option>
                                        <option value="MA">- MA -</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih Level Sekolah
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nomor Telpon</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Masukkan Nomor Telpon" name="no_telp" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        Masukkan Nomor Telpon
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email Sekolah</label>
                                <div class="col-sm-9">
                                    <input type="email" placeholder="Masukkan Email Sekolah" name="email" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        Masukkan Email Sekolah
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Alamat Sekolah</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Masukkan Alamat Sekolah" name="alamat" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        Masukkan Alamat Sekolah
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">NIP Kamad</label>
                                <div class="col-sm-9">
                                    <input type="number" name="nip_kamad" placeholder="Masukkan NIP Kamad" class="form-control">
                                    <div class="valid-feedback">
                                        Inputan Ini Optional
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Kamad</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_kamad" required="" placeholder="Masukkan Nama Kamad" class="form-control">
                                    <div class="invalid-feedback">
                                        Masukkan Nama Kamad
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
        $('.table').DataTable();
    </script>
@endsection
