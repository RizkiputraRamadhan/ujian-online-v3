@extends('master')
@section('title', 'Data Soal - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="section-header">
                    <h5><i class="fa-solid fa-folder-open" style="color: orange;"></i> {{ $folder->nama }} menjodohkan</h5> <br>

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
                @elseif (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <br>
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
                                                <input type="text" value="Soal Menjodohkan" id="jenis"
                                                    class="form-control bg-white" readonly>
                                                <input type="text" class="d-none" value="5" name="jenis_soal"
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
                                    <div class="col-sm-9 ">
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
                                        <a href="5/{{ $s->id }}" type="button"
                                            class="btn btn-primary btn-sm edit">Edit Soal</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @php echo $s->soal; @endphp
                                <hr>
                                <div class="d-flex">
                                    <div class="form-group p-3">
                                        <b>Soal</b>
                                        <div class="" id="soal_jdh_array">
                                            @foreach (json_decode($s->soal_jdh_array) as $index => $item)
                                                @php
                                                    $bgColor = '';
                                                    switch ($index) {
                                                        case 0:
                                                            $bgColor = 'bg-primary';
                                                            break;
                                                        case 1:
                                                            $bgColor = 'bg-success';
                                                            break;
                                                        case 2:
                                                            $bgColor = 'bg-warning';
                                                            break;
                                                        case 3:
                                                            $bgColor = 'bg-info';
                                                            break;
                                                        case 4:
                                                            $bgColor = 'bg-dark';
                                                            break;
                                                        default:
                                                            $bgColor = 'bg-primary';
                                                            break;
                                                    }
                                                @endphp

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text font-weight-bold text-light {{ $bgColor }}"
                                                            id="basic-addon{{ $index + 1 }}">{{ $index + 1 }}</span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        placeholder="Soal {{ $index + 1 }}"
                                                        aria-label="soal_{{ $index + 1 }}"
                                                        aria-describedby="basic-addon{{ $index + 1 }}"
                                                        value="{{ $item }}" disabled>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="form-group p-3">
                                        <b>Jawaban</b>
                                        <div class="" id="">
                                            @foreach (json_decode($s->jawaban_jdh) as $index => $item)
                                                @php
                                                    $kunci = json_decode($s->kunci)[$index];
                                                    $bgColor = '';

                                                    switch ($kunci) {
                                                        case 1:
                                                            $bgColor = 'bg-primary';
                                                            break;
                                                        case 2:
                                                            $bgColor = 'bg-success';
                                                            break;
                                                        case 3:
                                                            $bgColor = 'bg-warning';
                                                            break;
                                                        case 4:
                                                            $bgColor = 'bg-info';
                                                            break;
                                                        case 5:
                                                            $bgColor = 'bg-dark';
                                                            break;
                                                        default:
                                                            $bgColor = 'bg-primary';
                                                            break;
                                                    }
                                                @endphp
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text font-weight-bold text-light {{ $bgColor }}"
                                                            id="kunci">{{ $kunci }}</span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        placeholder="Soal {{ $index + 1 }}"
                                                        aria-label="soal_{{ $index + 1 }}"
                                                        aria-describedby="basic-addon{{ $index + 1 }}"
                                                        value="{{ $item }}" disabled>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
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
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="soal-add" role="tabpanel"
                                    aria-labelledby="soal-tab-add">
                                    <div id="pilihan_5">
                                        <div class="d-flex m-auto justify-content-center ">
                                            <textarea name="soal" id="soal_jdh" class="summernote"></textarea>
                                            <div class="form-group p-3">
                                                <b>Soal</b>
                                                <div class="" id="soal_jdh_array">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span
                                                                class="input-group-text font-weight-bold bg-success text-light"
                                                                id="basic-addon1">1</span>
                                                        </div>
                                                        <input type="text" name="soal_jdh_array[]"
                                                            class="form-control" placeholder="Soal 1" aria-label="soal_1"
                                                            aria-describedby="basic-addon1" id="soal_jdh_array">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span
                                                                class="input-group-text font-weight-bold bg-primary text-light"
                                                                id="basic-addon1">2</span>
                                                        </div>
                                                        <input type="text" name="soal_jdh_array[]"
                                                            class="form-control" placeholder="Soal 2" aria-label="soal_2"
                                                            aria-describedby="basic-addon1" id="soal_jdh_array">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span
                                                                class="input-group-text font-weight-bold bg-danger text-light"
                                                                id="basic-addon1">3</span>
                                                        </div>
                                                        <input type="text" name="soal_jdh_array[]"
                                                            class="form-control" placeholder="Soal 3" aria-label="soal_3"
                                                            aria-describedby="basic-addon1" id="soal_jdh_array">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span
                                                                class="input-group-text font-weight-bold bg-info text-light"
                                                                id="basic-addon1">4</span>
                                                        </div>
                                                        <input type="text" name="soal_jdh_array[]"
                                                            class="form-control" placeholder="Soal 4" aria-label="soal_4"
                                                            aria-describedby="basic-addon1" id="soal_jdh_array">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span
                                                                class="input-group-text font-weight-bold bg-warning text-light"
                                                                id="basic-addon1">5</span>
                                                        </div>
                                                        <input type="text" name="soal_jdh_array[]"
                                                            class="form-control" placeholder="Soal 5" aria-label="soal_5"
                                                            aria-describedby="basic-addon1" id="soal_jdh_array">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group p-3">
                                                <b>Jawaban</b>
                                                <div class="" id="jawaban_jdh">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <select class="custom-select w-3" id="jawaban_jdh"
                                                                name="kunci_jdh[]">
                                                                <option selected>pilih</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="jawaban "
                                                            aria-label="jawaban 1" aria-describedby="basic-addon1"
                                                            name="jawaban_jdh[]">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <select class="custom-select w-3" name="kunci_jdh[]">
                                                                <option selected>pilih</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="jawaban "
                                                            aria-label="jawaban 2" aria-describedby="basic-addon1"
                                                            name="jawaban_jdh[]">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <select class="custom-select w-3" name="kunci_jdh[]">
                                                                <option selected>pilih</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="jawaban "
                                                            aria-label="jawaban 3" aria-describedby="basic-addon1"
                                                            name="jawaban_jdh[]">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <select class="custom-select w-3" name="kunci_jdh[]">
                                                                <option selected>pilih</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="jawaban "
                                                            aria-label="jawaban 4" aria-describedby="basic-addon1"
                                                            name="jawaban_jdh[]">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <select class="custom-select w-3" name="kunci_jdh[]">
                                                                <option selected>pilih</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="jawaban "
                                                            aria-label="jawaban 5" aria-describedby="basic-addon1"
                                                            name="jawaban_jdh[]">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
