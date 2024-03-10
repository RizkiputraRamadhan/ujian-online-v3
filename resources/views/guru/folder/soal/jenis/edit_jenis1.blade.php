@extends('master')
@section('title', 'Data Soal - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="section-header">
                    <h5><i class="fa-solid fa-folder-open" style="color: orange;"></i> {{ $folder->nama }} pilihan ganda</h5> <br>

                    <div class="section-header-breadcrumb">
                        <a href="/guru/folder/soal/{{ $folder->id }}/1" class="btn btn-danger btn-sm ">
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
                            <div id="contentForm">
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
                                        <textarea name="soal" class="summernote">{{ $soal->soal}}</textarea>
                                        <div id="pilihan_1" class="form-group mb-0" style="margin-top: -20px">
                                            <label for="">Jawaban Benar</label>
                                            <select name="kunci" id="kunci" class="form-control">
                                                <option value="">-- PILIH JAWABAN YANG BENAR --</option>
                                                <option {{ $soal->kunci == 1 ? 'selected' : '' }} value="1">- PILIHAN A -</option>
                                                <option {{ $soal->kunci == 2 ? 'selected' : '' }} value="2">- PILIHAN B -</option>
                                                <option {{ $soal->kunci == 3 ? 'selected' : '' }} value="3">- PILIHAN C -</option>
                                                <option {{ $soal->kunci == 4 ? 'selected' : '' }} value="4">- PILIHAN D -</option>
                                                <option {{ $soal->kunci == 5 ? 'selected' : '' }} value="5">- PILIHAN E -</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="pil-a-add" role="tabpanel"
                                        aria-labelledby="pil-tab-a">
                                        <textarea name="pil_1" class="summernote">{{ $soal->pil_1 }}</textarea>
                                    </div>
                                    <div class="tab-pane fade" id="pil-b-add" role="tabpanel"
                                        aria-labelledby="pil-tab-b">
                                        <textarea name="pil_2" class="summernote">{{ $soal->pil_2 }}</textarea>
                                    </div>
                                    <div class="tab-pane fade" id="pil-c-add" role="tabpanel"
                                        aria-labelledby="pil-tab-c">
                                        <textarea name="pil_3" class="summernote">{{ $soal->pil_3 }}</textarea>
                                    </div>
                                    <div class="tab-pane fade" id="pil-d-add" role="tabpanel"
                                        aria-labelledby="pil-tab-d">
                                        <textarea name="pil_4" class="summernote">{{ $soal->pil_4 }}</textarea>
                                    </div>
                                    <div class="tab-pane fade" id="pil-e-add" role="tabpanel"
                                        aria-labelledby="pil-tab-e">
                                        <textarea name="pil_5" class="summernote">{{ $soal->pil_5 }}</textarea>
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
