@extends('master')
@section('title', 'Data Soal - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="section-header">
                    <h5><i class="fa-solid fa-folder-open" style="color: orange;"></i> {{ $folder->nama }} menjodohkan</h5> <br>

                    <div class="section-header-breadcrumb">
                        <a href="/guru/folder/soal/{{ $folder->id }}/5" class="btn btn-danger btn-sm ">
                            Kembali
                        </a>
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
            </div>
        </section>
        <div>
            <div class=" modal-xl">
                <div class="modal-content">
                    <form method="POST" class="needs-validation" novalidate="" action="">
                        @csrf
                        <div class="modal-body">
                            <div id="contentForm" style="display: block;">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="soal-add" role="tabpanel"
                                        aria-labelledby="soal-tab-add">
                                        <div id="pilihan_5">
                                            <div class="m-auto justify-content-center ">
                                                <textarea name="soal" id="soal_jdh" class="summernote">{{ $soal->soal }}</textarea>
                                                <div class="d-flex m-auto justify-content-center">
                                                    <div class="form-group p-3">
                                                        <b>Soal</b>
                                                        <div class="" id="soal_jdh_array">

                                                            @foreach (json_decode($soal->soal_jdh_array) as $index => $row)
                                                            @endforeach
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text font-weight-bold bg-success text-light"
                                                                        id="basic-addon1">1</span>
                                                                </div>
                                                                <input type="text" name="soal_jdh_array[]"
                                                                    class="form-control" placeholder="Soal 1"
                                                                    aria-label="soal_1"
                                                                    value="{{ isset(json_decode($soal->soal_jdh_array)[0]) ? json_decode($soal->soal_jdh_array)[0] : '' }}"
                                                                    aria-describedby="basic-addon1" id="soal_jdh_array">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text font-weight-bold bg-primary text-light"
                                                                        id="basic-addon1">2</span>
                                                                </div>
                                                                <input type="text" name="soal_jdh_array[]"
                                                                    class="form-control" placeholder="Soal 2"
                                                                    aria-label="soal_2"
                                                                    value="{{ isset(json_decode($soal->soal_jdh_array)[1]) ? json_decode($soal->soal_jdh_array)[1] : '' }}"
                                                                    aria-describedby="basic-addon1" id="soal_jdh_array">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text font-weight-bold bg-danger text-light"
                                                                        id="basic-addon1">3</span>
                                                                </div>
                                                                <input type="text" name="soal_jdh_array[]"
                                                                    class="form-control" placeholder="Soal 3"
                                                                    aria-label="soal_3"
                                                                    value="{{ isset(json_decode($soal->soal_jdh_array)[2]) ? json_decode($soal->soal_jdh_array)[2] : '' }}"
                                                                    aria-describedby="basic-addon1" id="soal_jdh_array">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text font-weight-bold bg-info text-light"
                                                                        id="basic-addon1">4</span>
                                                                </div>
                                                                <input type="text" name="soal_jdh_array[]"
                                                                    class="form-control" placeholder="Soal 4"
                                                                    aria-label="soal_4"
                                                                    value="{{ isset(json_decode($soal->soal_jdh_array)[3]) ? json_decode($soal->soal_jdh_array)[3] : '' }}"
                                                                    aria-describedby="basic-addon1" id="soal_jdh_array">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text font-weight-bold bg-warning text-light"
                                                                        id="basic-addon1">5</span>
                                                                </div>
                                                                <input type="text" name="soal_jdh_array[]"
                                                                    class="form-control" placeholder="Soal 5"
                                                                    aria-label="soal_5"
                                                                    value="{{ isset(json_decode($soal->soal_jdh_array)[4]) ? json_decode($soal->soal_jdh_array)[4] : '' }}"
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
                                                                        <option>pilih</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[0] ?? '') == 1 ? 'selected' : '' }}
                                                                            value="1">1</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[0] ?? '') == 2 ? 'selected' : '' }}
                                                                            value="2">2</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[0] ?? '') == 3 ? 'selected' : '' }}
                                                                            value="3">3</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[0] ?? '') == 4 ? 'selected' : '' }}
                                                                            value="4">4</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[0] ?? '') == 5 ? 'selected' : '' }}
                                                                            value="5">5</option>
                                                                    </select>
                                                                </div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="jawaban "
                                                                    value="{{ isset(json_decode($soal->jawaban_jdh)[0]) ? json_decode($soal->jawaban_jdh)[0] : '' }}"
                                                                    aria-label="jawaban 1" aria-describedby="basic-addon1"
                                                                    name="jawaban_jdh[]">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <select class="custom-select w-3" id="jawaban_jdh"
                                                                        name="kunci_jdh[]">
                                                                        <option>pilih</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[1] ?? '') == 1 ? 'selected' : '' }}
                                                                            value="1">1</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[1] ?? '') == 2 ? 'selected' : '' }}
                                                                            value="2">2</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[1] ?? '') == 3 ? 'selected' : '' }}
                                                                            value="3">3</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[1] ?? '') == 4 ? 'selected' : '' }}
                                                                            value="4">4</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[1] ?? '') == 5 ? 'selected' : '' }}
                                                                            value="5">5</option>
                                                                    </select>
                                                                </div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="jawaban "
                                                                    value="{{ isset(json_decode($soal->jawaban_jdh)[1]) ? json_decode($soal->jawaban_jdh)[1] : '' }}"
                                                                    aria-label="jawaban 2" aria-describedby="basic-addon1"
                                                                    name="jawaban_jdh[]">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <select class="custom-select w-3" id="jawaban_jdh"
                                                                        name="kunci_jdh[]">
                                                                        <option>pilih</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[2] ?? '') == 1 ? 'selected' : '' }}
                                                                            value="1">1</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[2] ?? '') == 2 ? 'selected' : '' }}
                                                                            value="2">2</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[2] ?? '') == 3 ? 'selected' : '' }}
                                                                            value="3">3</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[2] ?? '') == 4 ? 'selected' : '' }}
                                                                            value="4">4</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[2] ?? '') == 5 ? 'selected' : '' }}
                                                                            value="5">5</option>
                                                                    </select>
                                                                </div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="jawaban "
                                                                    value="{{ isset(json_decode($soal->jawaban_jdh)[2]) ? json_decode($soal->jawaban_jdh)[2] : '' }}"
                                                                    aria-label="jawaban 3" aria-describedby="basic-addon1"
                                                                    name="jawaban_jdh[]">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <select class="custom-select w-3" id="jawaban_jdh"
                                                                        name="kunci_jdh[]">
                                                                        <option>pilih</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[3] ?? '') == 1 ? 'selected' : '' }}
                                                                            value="1">1</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[3] ?? '') == 2 ? 'selected' : '' }}
                                                                            value="2">2</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[3] ?? '') == 3 ? 'selected' : '' }}
                                                                            value="3">3</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[3] ?? '') == 4 ? 'selected' : '' }}
                                                                            value="4">4</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[3] ?? '') == 5 ? 'selected' : '' }}
                                                                            value="5">5</option>
                                                                    </select>
                                                                </div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="jawaban "
                                                                    value="{{ isset(json_decode($soal->jawaban_jdh)[3]) ? json_decode($soal->jawaban_jdh)[3] : '' }}"
                                                                    aria-label="jawaban 4" aria-describedby="basic-addon1"
                                                                    name="jawaban_jdh[]">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <select class="custom-select w-3" id="jawaban_jdh"
                                                                        name="kunci_jdh[]">
                                                                        <option>pilih</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[4] ?? '') == 1 ? 'selected' : '' }}
                                                                            value="1">1</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[4] ?? '') == 2 ? 'selected' : '' }}
                                                                            value="2">2</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[4] ?? '') == 3 ? 'selected' : '' }}
                                                                            value="3">3</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[4] ?? '') == 4 ? 'selected' : '' }}
                                                                            value="4">4</option>
                                                                        <option
                                                                            {{ (json_decode($soal->kunci)[4] ?? '') == 5 ? 'selected' : '' }}
                                                                            value="5">5</option>
                                                                    </select>
                                                                </div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="jawaban "
                                                                    value="{{ isset(json_decode($soal->jawaban_jdh)[4]) ? json_decode($soal->jawaban_jdh)[4] : '' }}"
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
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $('.summernote').summernote();

        });
    </script>
@endsection
