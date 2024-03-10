@extends('master')
@section('title', 'Data Mapel - ')
@section('content')
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa-regular fa-folder-open" style="color: #cfbe03; font-size: 20px;" ></i> Edit Data Folder {{ $edit->nama }}</h4>
                    </div>
                    <div class="p-2">
                        <div class="shadow p-3 mb-5 bg-body-tertiary rounded mt-2">
                            <form action="" method="post">
                                @csrf
                                <div class="content-container">
                                    <div class="mb-3 mt-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama Folder</label>
                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $edit->nama }}" name="nama"
                                                    id="" class="form-control bg-white">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Mapel</label>
                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $edit->nama_mapel }}" name="mapel"
                                                    id="" class="form-control bg-white">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Pilih Kelas</label>
                                            <div class="col-sm-9">
                                                <div id="kelasPilihan"></div>
                                                <div class="scrollable-div" style="max-height: 200px; overflow-y: auto;">
                                                    @foreach ($kelas as $i => $row)
                                                        <div class="p-1">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="kelas_id[]" id="kelas_{{ $i }}"
                                                                    value="{{ $row->id }}"
                                                                    @if (in_array($row->id, json_decode($edit->nama_kelas))) checked @endif>
                                                                <label for="kelas_{{ $i }}"
                                                                    class="custom-control-label" for="customCheck1">Kelas
                                                                    {{ $row->tingkat_kelas }} ({{ $row->jurusan }})</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="invalid-feedback">
                                                    Pilih kelas untuk folder ini
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Ketentuan</label>
                                            <div class="col-sm-9">
                                                <textarea name="ket" id="" class="form-control bg-white summernote" cols="30" rows="20">{{ $edit->ketentuan }}</textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        class="w-4 btn btn-primary d-flex justify-content-end align-content-end ml-auto">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @elseif (session('gagal'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('gagal') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
@endsection
