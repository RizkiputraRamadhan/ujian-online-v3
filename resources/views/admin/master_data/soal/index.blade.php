@extends('master')
@section('title', 'Data Soal - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body  p-2 bg-white rounded">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="dropdown d-inline dropleft mb-2" style="float: right;">
                    <button type="button" class="btn btn-primary btn-sm " data-toggle="modal" data-target="#addModal">
                        Buat Soal
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-primary btn-sm tombolAmbil">
                        Ambil Soal Yang Sudah Ada
                    </button>

                    <div class="shadow p-3 mb-5 bg-body-tertiary rounded mt-2 modalAmbil" id="modalAmbil"
                        style="display: none;">
                        <h6>Data Semua Mapel</h6>
                        <hr>
                        <div class="content-container">
                            @foreach ($allsMapel as $index => $am)
                                @if (request()->segment(5) != $am->id)
                                <a href="{{ request()->segment(6) }}/{{ $am->id }}/banksoal" target="_blank"
                                    class="btn btn-primary btn-sm tombolAmbil"
                                    rel="noopener noreferrer">{{ $am->nama_mapel }} {{ $am->tahun->tahun }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header" role="button" data-toggle="collapse"
                            data-target="#panel-detail-mapel">
                            <h4>Lihat Detail Mapel</h4>
                        </div>
                        <div class="accordion-body collapse bg-white" id="panel-detail-mapel" data-parent="#accordion">
                            <div class="mb-3 mt-3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Sekolah</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            value=" {{ $mapel?->nama_sekolah }} ( T.A {{ $mapel?->tahun }} ) (SEMESTER {{ $mapel?->semester }})"
                                            name="" id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Mapel</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $mapel?->nama_mapel }}" name=""
                                            id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Guru</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $mapel?->nama_guru }}" name="" id=""
                                            class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kelas</label>
                                    <div class="col-sm-9">
                                        <select name="" disabled multiple="multiple" id="kelas_id"
                                            class="form-control bg-white" data-height="100%" required="">
                                            @foreach ($kelas as $k)
                                                <option
                                                    {{ \App\Models\MapelKelas::validate($mapel?->id, $k->id) != null ? 'selected' : '' }}
                                                    value="{{ $k->id }}">- KELAS {{ $k->tingkat_kelas }} (
                                                    {{ $k->urusan_kelas }} ) ( {{ $k->jurusan }} ) -</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Acak Soal</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            value="{{ $mapel?->acak_soal == 'Y' ? 'SOAL ACAK' : 'TIDAK ACAK' }}"
                                            name="" id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">KKM</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $mapel?->kkm }}" name="" id=""
                                            class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label">Jumlah Soal</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $mapel?->jumlah_soal }}" name=""
                                            id="" class="form-control bg-white" readonly>
                                        <i><small class="form-text text-danger mt-3" style="margin-bottom: -10px">
                                                {{ count($soal) != $mapel?->jumlah_soal ? 'Soal Belum Lengkap, Total soal telah dibuat ' . count($soal) : '' }}
                                            </small>
                                            <small class="form-text text-success mt-3" style="margin-bottom: -10px">
                                                {{ count($soal) == $mapel?->jumlah_soal ? 'Soal Telah Lengkap' : '' }}
                                            </small> </i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                @if (count($soal) == 0)
                    <center>
                        <i class="text-small">
                            - Soal Belum Ada, Silahkan buat soal dahulu pada menu buat soal -
                        </i>
                    </center>
                @else
                    <br>
                    @php $no=1; @endphp
                    <form action="#" method="post" id="formDelete">
                        @csrf
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
                                            <a href="#" data-id="{{ $s->id }}" type="button"
                                                class="btn btn-primary btn-sm edit">Edit Soal</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @php echo $s->soal; @endphp
                                    <hr>
                                    @if ($s->jenis_soal == 1)
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
                                        @if ($mapel?->level == 'MA')
                                            <div class="custom-control custom-radio">
                                                <input type="radio" disabled {{ $s->kunci == 5 ? 'checked' : '' }}
                                                    id="jawab{{ $s->id }}5" name="{{ $s->id }}"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="jawab{{ $s->id }}5">
                                                    @php echo $s->pil_5; @endphp
                                                </label>
                                            </div>
                                        @endif
                                    @elseif($s->jenis_soal == 2)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" disabled
                                                {{ in_array('1', json_decode($s->kunci)) ? 'checked' : '' }}
                                                id="jawab{{ $s->id }}1" name="{{ $s->id }}[]"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="jawab{{ $s->id }}1">
                                                @php echo $s->pil_1; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" disabled
                                                {{ in_array('2', json_decode($s->kunci)) ? 'checked' : '' }}
                                                id="jawab{{ $s->id }}2" name="{{ $s->id }}[]"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="jawab{{ $s->id }}2">
                                                @php echo $s->pil_2; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" disabled
                                                {{ in_array('3', json_decode($s->kunci)) ? 'checked' : '' }}
                                                id="jawab{{ $s->id }}3" name="{{ $s->id }}[]"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="jawab{{ $s->id }}3">
                                                @php echo $s->pil_3; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" disabled
                                                {{ in_array('4', json_decode($s->kunci)) ? 'checked' : '' }}
                                                id="jawab{{ $s->id }}4" name="{{ $s->id }}[]"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="jawab{{ $s->id }}4">
                                                @php echo $s->pil_4; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                        @if ($mapel?->level == 'MA')
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" disabled
                                                    {{ in_array('5', json_decode($s->kunci)) ? 'checked' : '' }}
                                                    id="jawab{{ $s->id }}5" name="{{ $s->id }}[]"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="jawab{{ $s->id }}5">
                                                    @php echo $s->pil_5; @endphp
                                                </label>
                                            </div>
                                        @endif
                                    @elseif($s->jenis_soal == 3)
                                        <textarea class="form-control" name="" id="" rows="3" style="height: 70px;" disabled>{{ $s->jawaban_singkat }}</textarea>
                                        @if (!empty($s->jenis_hrf))
                                            <b>-
                                                {{ in_array('sensitif', json_decode($s->jenis_hrf)) ? 'diaktifkan sensitif' : 'non aktifkan sensitif' }}</b>
                                        @else
                                        @endif
                                        <br>
                                        @if (!empty($s->jenis_inp))
                                            <b>-
                                                {{ in_array('karakter', json_decode($s->jenis_inp)) ? 'huruf/karakter' : 'hanya angka' }}</b>
                                        @else
                                        @endif

                                        <br>
                                    @elseif($s->jenis_soal == 4)
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="{{ $s->id }}" disabled checked
                                                class="custom-control-input">
                                            <label class="custom-control-label">
                                                {{ $s->kunci == 1 ? 'Benar' : 'Salah' }}
                                            </label> <br>
                                        </div>
                                    @elseif($s->jenis_soal == 5)
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
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-danger">
                            Hapus Soal Terchecklist
                        </button>
                    </form>
                @endif
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
                <form method="POST" class="needs-validation" novalidate="" id="formSimpan">
                    @csrf
                    <input type="hidden" name="mapel_id" value="{{ $mapel?->id }}">
                    <div class="modal-body">
                        <div class="form-group my-3" style="">
                            <label for="jenis_soal">Pilihan Jenis Soal</label>
                            <select name="jenis_soal" id="jenis_soal" required=""
                                class="form-control font-weight-bold" onchange="toggleForm()">
                                <option value="">- Pilihan Jenis Soal -</option>
                                <option value="1">- Pilihan Ganda -</option>
                                <option value="2">- Kotak Centang -</option>
                                <option value="3">- Jawaban Singkat -</option>
                                <option value="4">- Soal True And False -</option>
                                <option value="5">- Soal Menjodohkan -</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <span id="option_exam" class="badge badge-primary"></span>
                        </div>
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
                                @if ($mapel?->level == 'MA')
                                    <li class="nav-item">
                                        <button class="nav-link" id="pil-tab-e" data-toggle="tab"
                                            data-target="#pil-e-add" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">
                                            Pilihan E
                                        </button>
                                    </li>
                                @endif
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
                                            @if ($mapel?->level == 'MA')
                                                <option value="5">- PILIHAN E -</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div id="pilihan_2" class="form-group mb-0" style="margin-top: -20px">
                                        <label for="">Jawaban Benar</label>
                                        <br>
                                        <input type="checkbox" name="kunci[]" id="kunci" value="1">
                                        <label for="kunci">- PILIHAN A -</label><br>

                                        <input type="checkbox" name="kunci[]" id="kunci" value="2">
                                        <label for="kunci">- PILIHAN B -</label><br>

                                        <input type="checkbox" name="kunci[]" id="kunci" value="3">
                                        <label for="kunci">- PILIHAN C -</label><br>

                                        <input type="checkbox" name="kunci[]" id="kunci" value="4">
                                        <label for="kunci">- PILIHAN D -</label><br>

                                        @if ($mapel?->level == 'MA')
                                            <input type="checkbox" name="kunci[]" id="kunci" value="5">
                                            <label for="kunci">- PILIHAN E -</label><br>
                                        @endif

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
                                @if ($mapel?->level == 'MA')
                                    <div class="tab-pane fade" id="pil-e-add" role="tabpanel"
                                        aria-labelledby="pil-tab-e">
                                        <textarea name="pil_5" class="summernote"></textarea>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div id="pilihan_3" style="display: none;">
                            <textarea name="soal" id="soal_singkat" class="summernote"></textarea>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">
                                    <h6>Jawaban Benar</h6>
                                </label>
                                <textarea class="form-control" name="jawaban_singkat" id="jawaban_singkat" rows="3" style="height: 100px;"></textarea>
                            </div>
                            <h6 class="">Setting Jawaban Benar</h6>
                            <br>
                            <div class="">
                                <div class="form-check">
                                    <input class="form-check-input custom-radio" type="radio" name="jenis_hrf[]"
                                        value="sensitif">
                                    <label class="form-check-label" for="option-1"> <strong>- aktif kan sensitif case
                                        </strong></label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input custom-radio" type="radio" name="jenis_hrf[]"
                                        value="nonsensitif">
                                    <label class="form-check-label" for="option-2"><strong>- non aktif sensitif case
                                        </strong></label>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="form-check">
                                    <input class="form-check-input custom-radio" type="radio" name="jenis_inp[]"
                                        value="angka">
                                    <label class="form-check-label" for="option-3"><strong>- Hanya Angka </strong></label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input custom-radio" type="radio" name="jenis_inp[]"
                                        value="karakter">
                                    <label class="form-check-label" for="option-4"><strong>- Hanya Huruf dan
                                            Karakter</strong> </label>
                                </div>
                            </div>
                        </div>
                        <div id="pilihan_4" style="display: none;">
                            <textarea name="soal" id="soal_tf" class="summernote"></textarea>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">
                                    <h6>Jawaban Benar</h6>
                                </label>
                                <div class="">
                                    <div class="form-check">
                                        <input class="form-check-input custom-radio" type="radio" name="kunci"
                                            value="1">
                                        <label class="form-check-label" for="option-1"> <strong>- Benar
                                            </strong></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input custom-radio" type="radio" name="kunci"
                                            value="2">
                                        <label class="form-check-label" for="option-2"><strong>- Salah
                                            </strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="pilihan_5" style="display: none;">
                            <div class="d-flex m-auto justify-content-center ">
                                <textarea name="soal" id="soal_jdh" class="summernote"></textarea>
                                <div class="form-group p-3">
                                    <b>Soal</b>
                                    <div class="" id="soal_jdh_array">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-success text-light"
                                                    id="basic-addon1">1</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control"
                                                placeholder="Soal 1" aria-label="soal_1" aria-describedby="basic-addon1"
                                                id="soal_jdh_array">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-primary text-light"
                                                    id="basic-addon1">2</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control"
                                                placeholder="Soal 2" aria-label="soal_2" aria-describedby="basic-addon1"
                                                id="soal_jdh_array">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-danger text-light"
                                                    id="basic-addon1">3</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control"
                                                placeholder="Soal 3" aria-label="soal_3" aria-describedby="basic-addon1"
                                                id="soal_jdh_array">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-info text-light"
                                                    id="basic-addon1">4</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control"
                                                placeholder="Soal 4" aria-label="soal_4" aria-describedby="basic-addon1"
                                                id="soal_jdh_array">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-warning text-light"
                                                    id="basic-addon1">5</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control"
                                                placeholder="Soal 5" aria-label="soal_5" aria-describedby="basic-addon1"
                                                id="soal_jdh_array">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group p-3">
                                    <b>Jawaban</b>
                                    <div class="" id="jawaban_jdh">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="custom-select w-3" id="jawaban_jdh" name="kunci_jdh[]">
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
                    <div class="modal-footer">
                        @if (count($soal) == $mapel?->jumlah_soal)
                            <small>
                                Mencapai batas maksimum input soal
                            </small>
                        @else
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal">Update Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="needs-validation" novalidate=""  id="formUpdate">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="edit_jenis_soal" name="jenis_soal">
                    <div class="modal-body">
                        <div id="edit_ck_pg">
                            <ul class="nav nav-tabs mb-0" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="edit-soal-tab-add" data-toggle="tab"
                                        data-target="#edit-soal-add" type="button" role="tab"
                                        aria-controls="edit-soal-add" aria-selected="true">
                                        Soal
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="edit-pil-tab-a" data-toggle="tab"
                                        data-target="#edit-pil-a-add" type="button" role="tab"
                                        aria-controls="edit-pil-a-add" aria-selected="false">
                                        Pilihan A
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="edit-pil-tab-b" data-toggle="tab"
                                        data-target="#edit-pil-b-add" type="button" role="tab"
                                        aria-controls="contact" aria-selected="false">
                                        Pilihan B
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="edit-pil-tab-c" data-toggle="tab"
                                        data-target="#edit-pil-c-add" type="button" role="tab"
                                        aria-controls="contact" aria-selected="false">
                                        Pilihan C
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="edit-pil-tab-d" data-toggle="tab"
                                        data-target="#edit-pil-d-add" type="button" role="tab"
                                        aria-controls="contact" aria-selected="false">
                                        Pilihan D
                                    </button>
                                </li>
                                @if ($mapel?->level == 'MA')
                                    <li class="nav-item">
                                        <button class="nav-link" id="edit-pil-tab-e" data-toggle="tab"
                                            data-target="#edit-pil-e-add" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">
                                            Pilihan E
                                        </button>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="edit-soal-add" role="tabpanel"
                                    aria-labelledby="edit-soal-tab-add">
                                    <textarea name="soal" id="soal" class="summernote"></textarea>
                                    <div class="form-group mb-0" style="margin-top: -20px">
                                        <div id="edit_pilihan_1" class="form-group mb-0" style="margin-top: -20px">
                                            <label for="">Jawaban Benar</label>
                                            <select name="kunci" id="kunci_pg" class="form-control">
                                                <option value="">-- PILIH JAWABAN YANG BENAR --</option>
                                                <option value="1">- PILIHAN A -</option>
                                                <option value="2">- PILIHAN B -</option>
                                                <option value="3">- PILIHAN C -</option>
                                                <option value="4">- PILIHAN D -</option>
                                                @if ($mapel?->level == 'MA')
                                                    <option value="5">- PILIHAN E -</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div id="edit_pilihan_2" class="form-group mb-0" style="margin-top: -20px">
                                            <label for="">Jawaban Benar</label>
                                            <br>
                                            <input type="checkbox" name="kunci[]" id="kunci_ck" value="1">
                                            <label for="kunci">- PILIHAN A -</label><br>

                                            <input type="checkbox" name="kunci[]" id="kunci_ck" value="2">
                                            <label for="kunci">- PILIHAN B -</label><br>

                                            <input type="checkbox" name="kunci[]" id="kunci_ck" value="3">
                                            <label for="kunci">- PILIHAN C -</label><br>

                                            <input type="checkbox" name="kunci[]" id="kunci_ck" value="4">
                                            <label for="kunci">- PILIHAN D -</label><br>

                                            @if ($mapel?->level == 'MA')
                                                <input type="checkbox" name="kunci[]" id="kunci_ck" value="5">
                                                <label for="kunci">- PILIHAN E -</label><br>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="edit-pil-a-add" role="tabpanel"
                                    aria-labelledby="edit-pil-tab-a">
                                    <textarea name="pil_1" id="pil_1" class="summernote"></textarea>
                                </div>
                                <div class="tab-pane fade" id="edit-pil-b-add" role="tabpanel"
                                    aria-labelledby="edit-pil-tab-b">
                                    <textarea name="pil_2" id="pil_2" class="summernote"></textarea>
                                </div>
                                <div class="tab-pane fade" id="edit-pil-c-add" role="tabpanel"
                                    aria-labelledby="edit-pil-tab-c">
                                    <textarea name="pil_3" id="pil_3" class="summernote"></textarea>
                                </div>
                                <div class="tab-pane fade" id="edit-pil-d-add" role="tabpanel"
                                    aria-labelledby="edit-pil-tab-d">
                                    <textarea name="pil_4" id="pil_4" class="summernote"></textarea>
                                </div>
                                @if ($mapel?->level == 'MA')
                                    <div class="tab-pane fade" id="edit-pil-e-add" role="tabpanel"
                                        aria-labelledby="edit-pil-tab-e">
                                        <textarea name="pil_5" id="pil_5" class="summernote"></textarea>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div id="edit_pilihan_3">
                            <textarea name="soal" id="edit_soal_singkat" class="summernote"></textarea>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">
                                    <h6>Jawaban Benar</h6>
                                </label>
                                <textarea class="form-control" name="jawaban_singkat" id="edit_jawaban_singkat" rows="3"
                                    style="height: 100px;"></textarea>
                            </div>
                            <h6 class="">Setting Jawaban Benar</h6>
                            <br>
                            <div class="">
                                <div class="form-check">
                                    <input class="form-check-input custom-radio" id="edit_jenis_hrf" type="radio"
                                        name="jenis_hrf[]" value="sensitif">
                                    <label class="form-check-label" for="option-1"> <strong>- aktif kan sensitif case
                                        </strong></label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input custom-radio" type="radio" id="edit_jenis_hrf"
                                        name="jenis_hrf[]" value="nonsensitif">
                                    <label class="form-check-label" for="option-2"><strong>- non aktif sensitif case
                                        </strong></label>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="form-check">
                                    <input class="form-check-input custom-radio" id="edit_jenis_inp" type="radio"
                                        name="jenis_inp[]" value="angka">
                                    <label class="form-check-label" for="option-3"><strong>- Hanya Angka </strong></label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input custom-radio" id="edit_jenis_inp" type="radio"
                                        name="jenis_inp[]" value="karakter">
                                    <label class="form-check-label" for="option-4"><strong>- Hanya Huruf dan
                                            Karakter</strong> </label>
                                </div>
                            </div>
                        </div>
                        <div id="edit_pilihan_4">
                            <textarea name="soal" id="edit_soal_tf" class="summernote"></textarea>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">
                                    <h6>Jawaban Benar</h6>
                                </label>
                                <div class="">
                                    <div class="form-check">
                                        <input class="form-check-input custom-radio" id="kunci_tf" type="radio"
                                            name="kunci" value="1">
                                        <label class="form-check-label" for="option-1"> <strong>- Benar
                                            </strong></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input custom-radio" id="kunci_tf" type="radio"
                                            name="kunci" value="2">
                                        <label class="form-check-label" for="option-2"><strong>- Salah
                                            </strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="edit_pilihan_5" >
                            <div class="d-flex m-auto justify-content-center ">
                                <textarea name="soal" id="edit_soal_jdh" class="summernote"></textarea>
                                <div class="form-group p-3">
                                    <b>Soal</b>
                                    <div class="" >
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-success text-light"
                                                    id="basic-addon1">1</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control font-weight-bold"
                                                 aria-label="soal_1" aria-describedby="basic-addon1"
                                                id="edit_soal_jdh_array-1">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-primary text-light"
                                                    id="basic-addon1">2</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control font-weight-bold"
                                                aria-label="soal_2" aria-describedby="basic-addon1"
                                                 id="edit_soal_jdh_array-2">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-danger text-light"
                                                    id="basic-addon1">3</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control font-weight-bold"
                                                 aria-label="soal_3" aria-describedby="basic-addon1"
                                                 id="edit_soal_jdh_array-3">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-info text-light"
                                                    id="basic-addon1">4</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control font-weight-bold"
                                                 aria-label="soal_4" aria-describedby="basic-addon1"
                                                 id="edit_soal_jdh_array-4">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold bg-warning text-light"
                                                    id="basic-addon1">5</span>
                                            </div>
                                            <input type="text" name="soal_jdh_array[]" class="form-control font-weight-bold"
                                                 aria-label="soal_5" aria-describedby="basic-addon1"
                                                 id="edit_soal_jdh_array-5">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group p-3">
                                    <b>Jawaban</b>
                                    <div class="" >
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="custom-select w-3"  name="kunci_jdh[]" id="edit_kunci_jdh-1">
                                                    <option selected>pilih</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <input type="text" class="form-control font-weight-bold"
                                                aria-label="jawaban 1" aria-describedby="basic-addon1"
                                                name="jawaban_jdh[]" id="edit_jawaban_jdh-1">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="custom-select w-3" name="kunci_jdh[]" id="edit_kunci_jdh-2">
                                                    <option selected>pilih</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <input type="text" class="form-control font-weight-bold"
                                                aria-label="jawaban 2" aria-describedby="basic-addon1"
                                                name="jawaban_jdh[]" id="edit_jawaban_jdh-2">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="custom-select w-3" name="kunci_jdh[]" id="edit_kunci_jdh-3">
                                                    <option selected>pilih</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <input type="text" class="form-control font-weight-bold"
                                                aria-label="jawaban 3" aria-describedby="basic-addon1"
                                                name="jawaban_jdh[]" id="edit_jawaban_jdh-3">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="custom-select w-3" name="kunci_jdh[]" id="edit_kunci_jdh-4">
                                                    <option selected>pilih</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <input type="text" class="form-control font-weight-bold"
                                                aria-label="jawaban 4" aria-describedby="basic-addon1"
                                                name="jawaban_jdh[]" id="edit_jawaban_jdh-4">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="custom-select w-3" name="kunci_jdh[]" id="edit_kunci_jdh">
                                                    <option selected>pilih</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <input type="text" class="form-control font-weight-bold"
                                                aria-label="jawaban 5" aria-describedby="basic-addon1"
                                                name="jawaban_jdh[]" id="edit_jawaban_jdh-5">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModal">Import Guru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" id="formImport" method="POST" class="needs-validation" novalidate="">
                    @csrf
                    <input type="hidden" name="id" value="{{ $mapel->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Mapel</label>
                            <input type="text" name="" id="" class="form-control"
                                value="{{ $mapel->nama_mapel }}">
                            <div class="invalid-feedback">
                                Mapel Kosong
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>File Excel</label>
                            <input type="file" name="file" id="" required="" class="form-control"
                                accept=".xlsx">
                            <small class="mt-1">
                                <a href="{{ url('assets/import/soal.xlsx') }}">
                                    Download templeate
                                </a>
                            </small>
                            <div class="invalid-feedback">
                                Masukkan File Excel Sesuai Format
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
    <script>
        var contentForm = document.getElementById('contentForm');
        var jenisSoal = document.getElementById('jenis_soal').value;
        var option_exam = document.getElementById('option_exam');
        if (jenisSoal === '') {
            contentForm.style.display = 'none';
            option_exam.innerHTML = 'Pilih Jenis Soal Terlebih Dahulu';
        }

        function toggleForm() {
            var jenisSoal = document.getElementById('jenis_soal').value;
            var kunci = document.getElementById('kunci');
            var pilihan_1 = document.getElementById('pilihan_1');
            var pilihan_2 = document.getElementById('pilihan_2');
            var pilihan_3 = document.getElementById('pilihan_3');
            var pilihan_4 = document.getElementById('pilihan_4');
            var pilihan_5 = document.getElementById('pilihan_5');
            var option_exam = document.getElementById('option_exam');
            var contentForm = document.getElementById('contentForm');
            var soal_singkat = document.getElementById('soal_singkat');
            var soal_tf = document.getElementById('soal_tf');
            var soal_jdh = document.getElementById('soal_jdh');
            var soal_jdh_array = document.getElementById('soal_jdh_array');
            var jawaban_singkat = document.getElementById('jawaban_singkat');
            contentForm.style.display = 'block';
            if (jenisSoal == '1') {
                pilihan_1.style.display = 'block';
                pilihan_2.style.display = 'none';
                pilihan_3.style.display = 'none';
                pilihan_4.style.display = 'none';
                pilihan_5.style.display = 'none';
                option_exam.innerHTML = 'Soal Pilihan Ganda';
                soal_singkat.removeAttribute('name');
                soal_tf.removeAttribute('name');
                soal_jdh.removeAttribute('name');
                jawaban_singkat.removeAttribute('name');
                soal_singkat.classList.add('d-none');
                kunci.setAttribute('name', 'kunci');
            } else if (jenisSoal == '2') {
                pilihan_1.style.display = 'none';
                pilihan_2.style.display = 'block';
                pilihan_3.style.display = 'none';
                pilihan_4.style.display = 'none';
                pilihan_5.style.display = 'none';
                soal_singkat.classList.add('d-none');
                soal_singkat.removeAttribute('name');
                soal_tf.removeAttribute('name');
                soal_jdh.removeAttribute('name');
                kunci.setAttribute('name', 'kunci');
                jawaban_singkat.removeAttribute('name');
                option_exam.innerHTML = 'Soal Kotak Centang';
            } else if (jenisSoal == '3') {
                option_exam.innerHTML = 'Soal Jawaban Singkat/Essay';
                pilihan_1.style.display = 'none';
                pilihan_2.style.display = 'none';
                pilihan_3.style.display = 'block';
                pilihan_4.style.display = 'none';
                pilihan_5.style.display = 'none';
                contentForm.style.display = 'none';
                soal_tf.removeAttribute('name');
                soal_jdh.removeAttribute('name');
                soal_singkat.setAttribute('name', 'soal');
                jawaban_singkat.setAttribute('name', 'jawaban_singkat');
                kunci.removeAttribute('name');
                soal_singkat.classList.remove('d-none');
            } else if (jenisSoal == '4') {
                option_exam.innerHTML = 'Soal True And False';
                pilihan_1.style.display = 'none';
                pilihan_2.style.display = 'none';
                pilihan_3.style.display = 'none';
                pilihan_4.style.display = 'block';
                pilihan_5.style.display = 'none';
                contentForm.style.display = 'none';
                soal_singkat.classList.add('d-none');
                soal_singkat.removeAttribute('name');
                soal_jdh.removeAttribute('name');
                kunci.setAttribute('name', 'kunci');
                soal_tf.setAttribute('name', 'soal');
                jawaban_singkat.removeAttribute('name');
            } else if (jenisSoal == '5') {
                option_exam.innerHTML = 'Soal Menjodohkan';
                pilihan_1.style.display = 'none';
                pilihan_2.style.display = 'none';
                pilihan_3.style.display = 'none';
                pilihan_4.style.display = 'none';
                pilihan_5.style.display = 'block';
                contentForm.style.display = 'none';
                soal_singkat.classList.add('d-none');
                soal_singkat.removeAttribute('name');
                kunci.removeAttribute('name');
                soal_singkat.classList.remove('d-none');
                jawaban_singkat.removeAttribute('name');
                soal_jdh.setAttribute('name', 'soal');
            } else {
                option_exam.innerHTML = 'Pilih Jenis Soal Terlebih Dahulu';
                pilihan_1.style.display = 'none';
                pilihan_2.style.display = 'none';
                pilihan_3.style.display = 'none';
                pilihan_4.style.display = 'none';
                pilihan_5.style.display = 'none';
                contentForm.style.display = 'none';
                soal_singkat.removeAttribute('name');
                kunci.removeAttribute('name');
                soal_singkat.classList.add('d-none');
            }
        }

        $(document).ready(function() {
            $('.addModal').on('shown.bs.modal', function() {
                $('.summernote').summernote();
            });
            $('#formSimpan').submit(function(e) {
                e.preventDefault()
                $.ajax({
                    data: $(this).serialize(),
                    type: 'POST',
                    url: "{{ url('admin/master-data/soal') }}",
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
                        swal(err.responseJSON.message);
                    }
                });
            });
            $('#formUpdate').submit(function(e) {
                e.preventDefault()
                $.ajax({
                    data: $(this).serialize(),
                    type: 'PUT',
                    url: "{{ url('admin/master-data/soal') }}",
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
                        swal(err.responseJSON.message);
                    }
                });
            });
            $('#formDelete').submit(function(e) {
                e.preventDefault();
                swal({
                        title: "Hapus Soal yang techecklist ?",
                        text: "Soal ini akan dihapus",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                data: $(this).serialize(),
                                type: 'DELETE',
                                url: "{{ url('admin/master-data/soal') }}",
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
                                    swal(err.responseJSON.message);
                                }
                            });
                        }
                    });
            });
            $('#formImport').submit(function(e) {
                e.preventDefault()
                $.ajax({
                    data: new FormData(this),
                    type: 'POST',
                    url: "{{ url('admin/master-data/soal/import') }}",
                    processData: false,
                    contentType: false,
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
            $('.edit').click(function(e) {
                e.preventDefault();
                $.ajax({
                    data: {
                        'id': $(this).data('id'),
                        '_token': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ url('admin/master-data/soal/get') }}",
                    success: function(data) {
                        console.log(data)
                        $('#id').val(data.id);
                        $('#soal').summernote('code', data.soal);
                        $('#edit_jawaban_singkat').val(data.jawaban_singkat);
                        $('#edit_jenis_soal').val(data.jenis_soal);
                        if (data.jenis_soal == 1) {
                            $('#edit_pilihan_1').show();
                            $('#edit_pilihan_2').hide();
                            $('#edit_pilihan_3').hide();
                            $('#edit_pilihan_4').hide();
                            $('#edit_pilihan_5').hide();
                            $('#kunci_pg').val(data.kunci);
                            $('#edit_ck_pg').show();
                            $('#edit_soal_jdh').removeAttr('name');
                            $('#edit_soal_tf').removeAttr('name');
                            $('#edit_soal_singkat').removeAttr('name');
                        } else if (data.jenis_soal == 2) {
                            var kunciArray = JSON.parse(data.kunci);
                            kunciArray.forEach(function(kunci) {
                                $('#kunci_ck[value="' + kunci + '"]').prop('checked',
                                    true);
                            });
                            $('#edit_pilihan_1').hide();
                            $('#edit_pilihan_2').show();
                            $('#edit_pilihan_3').hide();
                            $('#edit_pilihan_4').hide();
                            $('#edit_pilihan_5').hide();
                            $('#edit_soal_jdh').removeAttr('name');
                            $('#edit_soal_tf').removeAttr('name');
                            $('#edit_soal_singkat').removeAttr('name');
                            $('#edit_ck_pg').show();
                        } else if (data.jenis_soal == 3) {
                            var jenis_hrf = JSON.parse(data.jenis_hrf);
                            jenis_hrf.forEach(function(jns_hr) {
                                $('#edit_jenis_hrf[value="' + jns_hr + '"]').prop(
                                    'checked', true);
                            });
                            var jenis_inp = JSON.parse(data.jenis_inp);
                            jenis_inp.forEach(function(jns_inp) {
                                $('#edit_jenis_inp[value="' + jns_inp + '"]').prop(
                                    'checked', true);
                            });
                            $('#edit_pilihan_1').hide();
                            $('#edit_ck_pg').hide();
                            $('#edit_pilihan_2').hide();
                            $('#edit_pilihan_3').show();
                            $('#edit_pilihan_4').hide();
                            $('#edit_pilihan_5').hide();
                            $('#edit_soal_singkat').summernote('code', data.soal);

                            $('#edit_soal_jdh').removeAttr('name');
                            $('#kunci_pg').removeAttr('name');
                            $('#edit_soal_tf').removeAttr('name');
                            $('#pil_1').removeAttr('name');
                            $('#pil_2').removeAttr('name');
                            $('#pil_3').removeAttr('name');
                            $('#pil_4').removeAttr('name');
                            $('#pil_5').removeAttr('name');
                            $('input[name="kunci[]"]').removeAttr('name');

                        } else if (data.jenis_soal == 4) {
                            $('#edit_pilihan_1').hide();
                            $('#edit_ck_pg').hide();
                            $('#edit_pilihan_2').hide();
                            $('#edit_pilihan_3').hide();
                            $('#edit_pilihan_4').show();
                            $('#edit_pilihan_5').hide();
                            $('#edit_jawaban_singkat').removeAttr('name');
                            $('#edit_soal_tf').summernote('code', data.soal);
                            $('#edit_soal_singkat').removeAttr('name');
                            $('#kunci_tf[value="' + data.kunci + '"]').prop('checked',
                                true);
                            $('#kunci_pg').removeAttr('name');
                            $('#edit_soal_jdh').removeAttr('name');
                            $('#pil_1').removeAttr('name');
                            $('#pil_2').removeAttr('name');
                            $('#pil_3').removeAttr('name');
                            $('#pil_4').removeAttr('name');
                            $('#pil_5').removeAttr('name');
                        } else if (data.jenis_soal == 5) {
                            var soal_ja = JSON.parse(data.soal_jdh_array);
                            var jawaban_ja = JSON.parse(data.jawaban_jdh);
                            var kunci_ja = JSON.parse(data.kunci);
                            console.log(kunci_ja)
                            $('#edit_soal_jdh_array-1').val(soal_ja[0]);
                            $('#edit_soal_jdh_array-2').val(soal_ja[1]);
                            $('#edit_soal_jdh_array-3').val(soal_ja[2]);
                            $('#edit_soal_jdh_array-4').val(soal_ja[3]);
                            $('#edit_soal_jdh_array-5').val(soal_ja[4]);

                            $('#edit_jawaban_jdh-1').val(jawaban_ja[0]);
                            $('#edit_jawaban_jdh-2').val(jawaban_ja[1]);
                            $('#edit_jawaban_jdh-3').val(jawaban_ja[2]);
                            $('#edit_jawaban_jdh-4').val(jawaban_ja[3]);
                            $('#edit_jawaban_jdh-5').val(jawaban_ja[4]);

                            $('#edit_kunci_jdh-1').val(kunci_ja[0]);
                            $('#edit_kunci_jdh-2').val(kunci_ja[1]);
                            $('#edit_kunci_jdh-3').val(kunci_ja[2]);
                            $('#edit_kunci_jdh-4').val(kunci_ja[3]);
                            $('#edit_kunci_jdh-5').val(kunci_ja[4]);

                            $('#edit_pilihan_1').hide();
                            $('#edit_ck_pg').hide();
                            $('#edit_pilihan_2').hide();
                            $('#edit_pilihan_3').hide();
                            $('#edit_pilihan_4').hide();
                            $('#edit_pilihan_5').show();
                            $('#edit_jawaban_singkat').removeAttr('name');
                            $('#edit_soal_jdh').summernote('code', data.soal);
                            $('#edit_soal_singkat').removeAttr('name');

                            $('#kunci_pg').removeAttr('name');
                            $('#pil_1').removeAttr('name');
                            $('#pil_2').removeAttr('name');
                            $('#pil_3').removeAttr('name');
                            $('#pil_4').removeAttr('name');
                            $('#pil_5').removeAttr('name');
                        }
                        $('#pil_1').summernote('code', data.pil_1);
                        $('#pil_2').summernote('code', data.pil_2);
                        $('#pil_3').summernote('code', data.pil_3);
                        $('#pil_4').summernote('code', data.pil_4);
                        $('#pil_5').summernote('code', data.pil_5);

                        $('#updateModal').modal('show');
                    },
                    error: function(err) {
                        swal(err.responseJSON.message);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".tombolAmbil").click(function() {
                $("#modalAmbil").toggle();
            });
        });
    </script>
@endsection
