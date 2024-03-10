@extends('master')
@section('title', 'Data Soal - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Bank Soal {{ $mapelOld->nama_mapel }} {{ $mapelOld->tahun->tahun }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Data Mapel</div>
                    <a class="breadcrumb-item" <a>
                        Data Soal
                    </a>
                    </a>
                </div>
            </div>
            <div class="section-header mb-3">
                <strong class="text-primary">{{ $mapelOld->nama_mapel }} {{ $mapelOld->tahun->tahun }} &ensp; &ensp; <span
                        class="text-danger"> <i class="fa-solid fa-arrow-right fa-beat-fade"></i> <i
                            class="fa-solid fa-arrow-right fa-beat-fade"></i> <i
                            class="fa-solid fa-arrow-right fa-beat-fade"></i></span> &ensp; &ensp;
                    {{ $mapelNew->nama_mapel }} {{ $mapelNew->tahun->tahun }}</strong>
                <hr>
            </div>
            @foreach ($banksoal as $index => $s)
            <div class="card" style="margin-top: -20px;" id="success{{ $s->id }}">
                    <div class="card-header">
                        <h4>
                            SOAL NO <span class="badge badge-primary" style="margin-top: -5px;">{{ $index + 1 }}</span>
                            {{ session('mapelId') }}
                        </h4>
                        <div class="card-header-form">
                            <div class="dropdown d-inline dropleft">
                                <form action="" method="post">
                                    @csrf
                                    <input type="text" class="d-none" name="soalID" value="{{ $s->id }}">
                                    <button type="submit" onclick="myClick({{ $s->id }})" class="btn btn-primary btn-sm edit">Ambil Soal</button>
                                    <a href="#success" id="back" class="d-none"></a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="soalContent{{ $index }}">{!! $s->soal !!}</div>
                        @if ($s->jenis_soal == 1)
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
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" disabled
                                    {{ in_array('5', json_decode($s->kunci)) ? 'checked' : '' }}
                                    id="jawab{{ $s->id }}5" name="{{ $s->id }}[]"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="jawab{{ $s->id }}5">
                                    @php echo $s->pil_5; @endphp
                                </label>
                            </div>
                        @elseif($s->jenis_soal == 3)
                            <textarea class="form-control" name="" id="" rows="3" style="height: 70px;" disabled>{{ $s->jawaban_singkat }}</textarea>
                            <b>-
                                {{ in_array('sensitif', json_decode($s->jenis_hrf)) ? 'diaktifkan sensitif' : 'non aktifkan sensitif' }}</b>
                            <br>
                            <b>-
                                {{ in_array('karakter', json_decode($s->jenis_inp)) ? 'huruf/karakter' : 'hanya angka' }}</b>
                        @elseif($s->jenis_soal == 4)
                            <hr>
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

        </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function myClick(id) {
            var back = document.getElementById("back");
            back.href = "#success" + id;
            back.click();
        }

        @if (session('success'))
            Swal.fire({
                title: "Proses Migrasi Soal!",
                html: " <b>{{ $mapelOld->nama_mapel }} {{ $mapelOld->tahun->tahun }}</b> <br> &ensp; <small class='text-danger'><i class='fa-solid fa-arrow-right fa-beat-fade'></i> <i class='fa-solid fa-arrow-right fa-beat-fade'></i> <i class='fa-solid fa-arrow-right fa-beat-fade'></i> <i class='fa-solid fa-arrow-right fa-beat-fade'></i></small> &ensp; <br> <b>{{ $mapelNew->nama_mapel }} {{ $mapelNew->tahun->tahun }}</b>",
                timer: 4000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
                didClose: () => {
                    Swal.fire({
                        icon: 'success',
                        title: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })


        @elseif (session('gagal'))
            Swal.fire({
                title: "Proses Migrasi Soal!",
                html: " <b>{{ $mapelOld->nama_mapel }} {{ $mapelOld->tahun->tahun }}</b> <br> &ensp; <small class='text-danger'><i class='fa-solid fa-arrow-right fa-beat-fade'></i> <i class='fa-solid fa-arrow-right fa-beat-fade'></i> <i class='fa-solid fa-arrow-right fa-beat-fade'></i> <i class='fa-solid fa-arrow-right fa-beat-fade'></i></small> &ensp; <br> <b>{{ $mapelNew->nama_mapel }} {{ $mapelNew->tahun->tahun }}</b>",
                timer: 5000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
                didClose: () => {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ session('gagal') }}',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
        @endif
    </script>

@endsection
