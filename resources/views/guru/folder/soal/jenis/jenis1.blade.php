@extends('master')
@section('title', 'Data Soal - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="section-header">
                    <h5><i class="fa-solid fa-folder-open" style="color: orange;"></i> {{ $folder->nama }} pilihan ganda</h5> <br>

                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-primary btn-sm " data-toggle="modal" data-target="#addModal">
                            Buat Soal Baru
                        </button>
                    </div>
                </div>
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Migrasi Soal Untuk Ujian</h4>
                        <button class="w-4 btn btn-primary tombolAdd">Open</button>
                    </div>
                    <div class="p-2">
                        <div class="shadow p-3 mb-5 bg-body-tertiary rounded mt-2 modalFolderAdd" id="modalFolderAdd"
                            style="display: none;">
                            <h6>Silahkan pilih dan tentukan soalnya</h6>
                            <hr>
                            <form action="/guru/folder/migrasi" method="post">
                                @csrf
                                <input type="text" class="d-none" name="folder" value="{{ $folder->id }}">
                                <div class="content-container">
                                    <div class="mb-3 mt-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Mapel yang diujikan</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="mapel_id" id="mapel">
                                                    <option value="">Pilih</option>
                                                    @foreach ($mapel as $row)
                                                        <option value="{{ $row->id }}" data-kkm="{{ $row->kkm }}"
                                                            data-jumlah-soal="{{ $row->jumlah_soal }}"
                                                            data-semester="{{ $row->semester }}">
                                                            {{ $row->nama_mapel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">KKM</label>
                                            <div class="col-sm-9">
                                                <input type="text" value="" id="kkm"
                                                    class="form-control bg-white" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Jumlah Soal</label>
                                            <div class="col-sm-9">
                                                <input type="text" value="" id="jumlah_soal"
                                                    class="form-control bg-white" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Semester</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="semester" class="form-control bg-white" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Jenis Soal</label>
                                            <div class="col-sm-9">
                                                <input type="text" value="Pilihan Ganda" id="jenis"
                                                    class="form-control bg-white" readonly>
                                                <input type="text" class="d-none" value="1" name="jenis_soal"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Jumlah Soal yang akan dimigrasi</label>
                                            <div class="col-sm-9">
                                                <input type="number" value="" name="jumlah"
                                                    class="form-control bg-white">
                                            </div>
                                        </div>

                                    </div>
                                    <button
                                        class="w-4 btn btn-primary d-flex justify-content-end align-content-end ml-auto">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header" role="button" data-toggle="collapse"
                            data-target="#panel-detail-mapel">
                            <h4>Lihat Detail</h4>
                        </div>
                        <div class="accordion-body collapse bg-white" id="panel-detail-mapel" data-parent="#accordion">
                            <div class="mb-3 mt-3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Folder</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $folder->nama }}" name="" id=""
                                            class="form-control bg-white" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Mapel</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $folder->nama_mapel }}" name=""
                                            id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kelas</label>
                                    <div class="col-sm-9">
                                        @foreach (json_decode($folder->nama_kelas) as $i => $klsId)
                                            @foreach ($kelas as $row)
                                                @if ($row->id == $klsId)
                                                <div class="ml-4">
                                                    <input type="checkbox" id="kelas_{{ $row->id }}"
                                                        value="{{ $row->id }}" class="form-check-input" checked
                                                        disabled>
                                                    <label for="kelas_{{ $row->id }}" class="form-check-label">Kelas
                                                        {{ $row->tingkat_kelas }} ({{ $row->jurusan }})</label><br>
                                                </div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Ketentuan</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="jawaban_singkat" id="jawaban_singkat" rows="3" style="height: 100px;"
                                            disabled>{!! $folder->ketentuan !!}</textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                @php $no=1; @endphp
                <form method="post" action="delete">
                    @csrf
                    @method('DELETE')
                    @foreach ($soal as $s)
                        <div class="card" style="margin-top: -20px;">
                            <div class="card-header">
                                <h4>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="id[]" class="custom-control-input"
                                            id="customCheck{{ $s->id }}" value="{{ $s->id }}">
                                        <label class="custom-control-label" for="customCheck{{ $s->id }}">
                                            SOAL NO <span class="badge badge-primary"
                                                style="margin-top: -5px;">{{ $no++ }}</span>
                                        </label>
                                    </div>
                                </h4>
                                <div class="card-header-form">
                                    <div class="dropdown d-inline dropleft">
                                        <a href="1/{{ $s->id }}" type="button"
                                            class="btn btn-primary btn-sm edit">Edit Soal</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @php echo $s->soal; @endphp
                                <hr>
                                <div class="custom-control custom-radio">
                                    <input type="radio" disabled {{ $s->kunci == 1 ? 'checked' : '' }}
                                        id="jawab{{ $s->id }}1" name="{{ $s->id }}"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="jawab{{ $s->id }}1">
                                        @php echo $s->pil_1; @endphp
                                    </label>
                                </div>
                                <hr>
                                <div class="custom-control custom-radio">
                                    <input type="radio" disabled {{ $s->kunci == 2 ? 'checked' : '' }}
                                        id="jawab{{ $s->id }}2" name="{{ $s->id }}"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="jawab{{ $s->id }}2">
                                        @php echo $s->pil_2; @endphp
                                    </label>
                                </div>
                                <hr>
                                <div class="custom-control custom-radio">
                                    <input type="radio" disabled {{ $s->kunci == 3 ? 'checked' : '' }}
                                        id="jawab{{ $s->id }}3" name="{{ $s->id }}"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="jawab{{ $s->id }}3">
                                        @php echo $s->pil_3; @endphp
                                    </label>
                                </div>
                                <hr>
                                <div class="custom-control custom-radio">
                                    <input type="radio" disabled {{ $s->kunci == 4 ? 'checked' : '' }}
                                        id="jawab{{ $s->id }}4" name="{{ $s->id }}"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="jawab{{ $s->id }}4">
                                        @php echo $s->pil_4; @endphp
                                    </label>
                                </div>
                                <hr>
                                <div class="custom-control custom-radio">
                                    <input type="radio" disabled {{ $s->kunci == 5 ? 'checked' : '' }}
                                        id="jawab{{ $s->id }}5" name="{{ $s->id }}"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="jawab{{ $s->id }}5">
                                        @php echo $s->pil_5; @endphp
                                    </label>
                                </div>

                            </div>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-danger">
                        Hapus Soal Terchecklist
                    </button>
                </form>
            </div>
        </section>
    </div>


    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal">Tambah Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="needs-validation" novalidate="" action="">
                    @csrf
                    <div class="modal-body">
                        <div id="contentForm" style="display: block;">
                            <ul class="nav nav-tabs mb-0" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="soal-tab-add" data-toggle="tab"
                                        data-target="#soal-add" type="button" role="tab" aria-controls="soal-add"
                                        aria-selected="true">
                                        Soal
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="pil-tab-a" data-toggle="tab" data-target="#pil-a-add"
                                        type="button" role="tab" aria-controls="pil-a-add" aria-selected="false">
                                        Pilihan A
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="pil-tab-b" data-toggle="tab" data-target="#pil-b-add"
                                        type="button" role="tab" aria-controls="contact" aria-selected="false">
                                        Pilihan B
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="pil-tab-c" data-toggle="tab" data-target="#pil-c-add"
                                        type="button" role="tab" aria-controls="contact" aria-selected="false">
                                        Pilihan C
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="pil-tab-d" data-toggle="tab" data-target="#pil-d-add"
                                        type="button" role="tab" aria-controls="contact" aria-selected="false">
                                        Pilihan D
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="pil-tab-e" data-toggle="tab" data-target="#pil-e-add"
                                        type="button" role="tab" aria-controls="contact" aria-selected="false">
                                        Pilihan E
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="soal-add" role="tabpanel"
                                    aria-labelledby="soal-tab-add">
                                    <textarea name="soal" class="summernote"></textarea>
                                    <div id="pilihan_1" class="form-group mb-0" style="margin-top: -20px">
                                        <label for="">Jawaban Benar</label>
                                        <select name="kunci" id="kunci" class="form-control">
                                            <option value="">-- PILIH JAWABAN YANG BENAR --</option>
                                            <option value="1">- PILIHAN A -</option>
                                            <option value="2">- PILIHAN B -</option>
                                            <option value="3">- PILIHAN C -</option>
                                            <option value="4">- PILIHAN D -</option>
                                            <option value="5">- PILIHAN E -</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="pil-a-add" role="tabpanel" aria-labelledby="pil-tab-a">
                                    <textarea name="pil_1" class="summernote"></textarea>
                                </div>
                                <div class="tab-pane fade" id="pil-b-add" role="tabpanel" aria-labelledby="pil-tab-b">
                                    <textarea name="pil_2" class="summernote"></textarea>
                                </div>
                                <div class="tab-pane fade" id="pil-c-add" role="tabpanel" aria-labelledby="pil-tab-c">
                                    <textarea name="pil_3" class="summernote"></textarea>
                                </div>
                                <div class="tab-pane fade" id="pil-d-add" role="tabpanel" aria-labelledby="pil-tab-d">
                                    <textarea name="pil_4" class="summernote"></textarea>
                                </div>
                                <div class="tab-pane fade" id="pil-e-add" role="tabpanel" aria-labelledby="pil-tab-e">
                                    <textarea name="pil_5" class="summernote"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
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
        @elseif (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: '{{ session('warning') }}',
                showConfirmButton: false,
                timer: 3500
            });
        @endif
        $(document).ready(function() {
            $('.addModal').on('shown.bs.modal', function() {
                $('.summernote').summernote();
            });
            $(".tombolAdd").click(function() {
                $("#modalFolderAdd").toggle();
            });
        });

        var mapelSelect = document.getElementById('mapel');
        var kkmInput = document.getElementById('kkm');
        var jumlahSoalInput = document.getElementById('jumlah_soal');
        var semesterInput = document.getElementById('semester');

        // Mendengarkan perubahan pada select mapel
        mapelSelect.addEventListener('change', function() {
            // Mendapatkan data KKM dan jumlah soal dari opsi yang dipilih
            var selectedOption = mapelSelect.options[mapelSelect.selectedIndex];
            var kkm = selectedOption.getAttribute('data-kkm');
            var jumlahSoal = selectedOption.getAttribute('data-jumlah-soal');
            var semester = selectedOption.getAttribute('data-semester');

            // Mengisi nilai KKM dan jumlah soal sesuai dengan data yang dipilih
            kkmInput.value = kkm;
            semesterInput.value = semester;
            jumlahSoalInput.value = jumlahSoal;
        });
    </script>
@endsection
