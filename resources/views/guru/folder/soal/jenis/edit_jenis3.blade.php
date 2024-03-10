@extends('master')
@section('title', 'Data Soal - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="section-header">
                    <h5><i class="fa-solid fa-folder-open" style="color: orange;"></i> {{ $folder->nama }} Essay</h5> <br>

                    <div class="section-header-breadcrumb">
                        <a href="/guru/folder/soal/{{ $folder->id }}/3" class="btn btn-danger btn-sm ">
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
                                        <div id="pilihan_3">
                                            <textarea name="soal" id="soal_singkat" class="summernote">{{ $soal->soal }}</textarea>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">
                                                    <h6>Jawaban Benar</h6>
                                                </label>
                                                <textarea class="form-control" name="jawaban_singkat" id="jawaban_singkat" rows="3" style="height: 100px;">{{ $soal->jawaban_singkat }}</textarea>
                                            </div>
                                            <h6 class="">Setting Jawaban Benar</h6>
                                            <br>
                                            <div class="">
                                                <div class="form-check">
                                                    <input class="form-check-input custom-radio" {{ in_array('sensitif', json_decode($soal->jenis_hrf)) ? "checked" : ' ' }}  type="radio"
                                                        name="jenis_hrf[]" value="sensitif">
                                                    <label class="form-check-label" for="option-1"> <strong>- aktif kan
                                                            sensitif case
                                                        </strong></label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input custom-radio" {{ in_array('nonsensitif', json_decode($soal->jenis_hrf)) ? 'checked' : ' ' }} type="radio"
                                                        name="jenis_hrf[]" value="nonsensitif">
                                                    <label class="form-check-label" for="option-2"><strong>- non aktif
                                                            sensitif case
                                                        </strong></label>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <div class="form-check">
                                                    <input class="form-check-input custom-radio" {{ in_array('angka', json_decode($soal->jenis_inp)) ? "checked" : ' ' }} type="radio"
                                                        name="jenis_inp[]" value="angka">
                                                    <label class="form-check-label" for="option-3"><strong>- Hanya Angka
                                                        </strong></label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input custom-radio" {{ in_array('karakter', json_decode($soal->jenis_inp)) ? "checked" : ' ' }} type="radio"
                                                        name="jenis_inp[]" value="karakter">
                                                    <label class="form-check-label" for="option-4"><strong>- Hanya Huruf dan
                                                            Karakter</strong> </label>
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
