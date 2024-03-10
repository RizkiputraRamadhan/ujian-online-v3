<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/img/kemenag.png') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('dist/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mix/app.css') }}">
    <script src="{{ asset('assets/mix/app.js') }}"></script>
    <script src="{{ asset('dist/sweetalert/sweetalert2.min.js') }}""></script>
    <title>Preview Ujian - Aplikasi Ujian Online</title>
</head>
<noscript>
    <div class="awesome-fancy-styling">
        Javascript harus hidup di browser anda ...
    </div>
</noscript>

<body class="layout-3" oncopy="return false" oncut="return false" onpaste="return false">
    <nav class="navbar navbar-expand-lg bg-primary" style="position:fixed; height:110px;">
        <div class="container">
            <a class="navbar-brand" href="#">
                Preview Hasil Ujian
            </a>
            <div id="navbarText">
                <ul class="navbar-nav mr-auto">
                </ul>
                <span class="navbar-text h5 mt-1" id="time">

                </span>
            </div>
        </div>
    </nav>
    @if ($kehadiran?->status_ujian != 'SELESAI')
        <br><br><br><br><br><br><br>
        <div class="text-center">
            UJIAN BELUM SELESAI
        </div>
    @else
        <div class="container">
            <br><br><br><br><br><br><br>
            <div id="accordion">
                <div class="accordion">
                    <div class="accordion-header" role="button" data-toggle="collapse"
                        data-target="#panel-detail-mapel">
                        <h4>Lihat Detail Hasil Ujian</h4>
                    </div>
                    <div class="accordion-body collapse bg-white" id="panel-detail-mapel" data-parent="#accordion">
                        <div class="mb-3 mt-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tahun Ajaran</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $jadwal?->tahun }}" name="" id=""
                                        class="form-control bg-white" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Mapel</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $jadwal?->nama_mapel }}" name=""
                                        id="" class="form-control bg-white" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal Ujian</label>
                                <div class="col-sm-9">
                                    @if ($jadwal != null)
                                        <input type="text"
                                            value="{{ Illuminate\Support\Carbon::createFromFormat('Y-m-d', $jadwal?->tanggal)->isoFormat('D MMMM Y') }}"
                                            name="" id="" class="form-control bg-white" readonly>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Mulai / Selesai</label>
                                <div class="col-sm-9">
                                    <input type="text"
                                        value="{{ $jadwal?->jam_mulai . ' - ' . $jadwal?->jam_selesai }}" name=""
                                        id="" class="form-control bg-white" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Pengawas</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $jadwal?->pengawas }}" name="" id=""
                                        class="form-control bg-white" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kelas</label>
                                <div class="col-sm-9">
                                    <input type="text"
                                        value="KELAS {{ $jadwal?->tingkat_kelas }} ( {{ $jadwal?->urusan_kelas }} ) ( {{ $jadwal?->jurusan }} )"
                                        name="" id="" class="form-control bg-white" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">NISN</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $siswa?->nip_nik_nisn }}" name=""
                                        id="" class="form-control bg-white" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">NIS</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $siswa?->nis }}" name="" id=""
                                        class="form-control bg-white" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Siswa</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $siswa?->nama }}" name="" id=""
                                        class="form-control bg-white" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nilai Akhir</label>
                                <div class="col-sm-9">
                                    <input class="form-control bg-white" readonly type="text"
                                        value="{{ \App\Models\BankJawaban::getNilai($kehadiran?->id, $mapel?->id, $siswa?->id) }}"
                                        name="" id="" />
                                    <small class="text-success">
                                        <b>Total Benar
                                            {{ \App\Models\BankJawaban::getBenar($kehadiran?->id, $mapel?->id, $siswa?->id) }}
                                        </b>
                                    </small>
                                    <small class="text-danger">
                                        <b>Total Salah
                                            {{ \App\Models\BankJawaban::getSalah($kehadiran?->id, $mapel?->id, $siswa?->id) }}
                                        </b>
                                    </small>
                                    <small class="text-warning">
                                        <b>Total Tidak Dijawab
                                            {{ \App\Models\BankJawaban::getTidakDijawab($kehadiran?->id, $mapel?->id, $siswa?->id) }}
                                        </b>
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Status Ujian</label>
                                @php $nilai = \App\Models\BankJawaban::getNilai($kehadiran?->id, $mapel?->id, $siswa?->id) @endphp
                                <div class="col-sm-9">
                                    <input type="text"
                                        value="{{ $nilai >= $mapel?->kkm ? 'LULUS UJIAN' : 'MENGULANG' }}"
                                        name="" id="" class="form-control bg-white" readonly>
                                    <small class="text-black">
                                        <b>KKM MAPEL : {{ $mapel?->kkm }}</b>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @if (count($soal) == 0)
                <div class="text-center">Soal tidak ada</div>
            @else
                @php $nomor=1; @endphp
                @for ($i = 0; $i < count($soal); $i++)
                    @php $jawab_soal = \App\Models\BankJawaban::jawabSiswa($kehadiran?->id, $mapel?->id, $siswa?->id, $soal[$i]['id']); @endphp
                    @if ($soal[$i]['jenis_soal'] == 1)
                        <div class="jenis_1">
                            <div
                                class="card border {{ $jawab_soal?->jawaban == $soal[$i]['kunci'] ? 'border-success' : 'border-danger' }}">
                                <div class="card-header">
                                    <h4>
                                        SOAL NO <span class="badge badge-primary" style="margin-top: -5px;">
                                            {{ $nomor++ }}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @php echo $soal[$i]['soal'] @endphp
                                    <hr>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" disabled value="1"
                                            {{ $soal[$i]['kunci'] == 1 ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}1"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}1">
                                            @php echo $soal[$i]['pil_1']; @endphp
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" disabled value="2"
                                            {{ $soal[$i]['kunci'] == 2 ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}2"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}2">
                                            @php echo $soal[$i]['pil_2']; @endphp
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" disabled value="3"
                                            {{ $soal[$i]['kunci'] == 3 ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}3"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}3">
                                            @php echo $soal[$i]['pil_3']; @endphp
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" disabled value="4"
                                            {{ $soal[$i]['kunci'] == 4 ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}4"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}4">
                                            @php echo $soal[$i]['pil_4']; @endphp
                                        </label>
                                    </div>
                                    <hr>
                                    @if ($sekolah?->level == 'MA')
                                        <div class="custom-control custom-radio">
                                            <input type="radio" disabled value="5"
                                                {{ $soal[$i]['kunci'] == 5 ? 'checked' : '' }}
                                                data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}5"
                                                name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                            <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}5">
                                                @php echo $soal[$i]['pil_5']; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                    @endif
                                    @if ($jawab_soal?->jawaban == 1)
                                        <b>JAWABAN SISWA : A</b>
                                    @elseif($jawab_soal?->jawaban == 2)
                                        <b>JAWABAN SISWA : B</b>
                                    @elseif($jawab_soal?->jawaban == 3)
                                        <b>JAWABAN SISWA : C</b>
                                    @elseif($jawab_soal?->jawaban == 4)
                                        <b>JAWABAN SISWA : D</b>
                                    @elseif($jawab_soal?->jawaban == 5)
                                        <b>JAWABAN SISWA : E</b>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif($soal[$i]['jenis_soal'] == 2)
                        <div class="jenis_2">
                            <div
                                class="card border {{ $jawab_soal?->jawaban == $soal[$i]['kunci'] ? 'border-success' : 'border-danger' }}">
                                <div class="card-header">
                                    <h4>
                                        SOAL NO <span class="badge badge-primary" style="margin-top: -5px;">
                                            {{ $nomor++ }}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @php echo $soal[$i]['soal'] @endphp
                                    <hr>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" disabled value="1"
                                            {{ in_array('1', json_decode($soal[$i]['kunci'])) ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}1"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}[]">
                                            @php echo $soal[$i]['pil_1']; @endphp
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" disabled value="2"
                                            {{ in_array('2', json_decode($soal[$i]['kunci'])) ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}2"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}[]">
                                            @php echo $soal[$i]['pil_2']; @endphp
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" disabled value="3"
                                            {{ in_array('3', json_decode($soal[$i]['kunci'])) ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}3"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}[]">
                                            @php echo $soal[$i]['pil_3']; @endphp
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" disabled value="4"
                                            {{ in_array('4', json_decode($soal[$i]['kunci'])) ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}4"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}[]">
                                            @php echo $soal[$i]['pil_4']; @endphp
                                        </label>
                                    </div>
                                    <hr>
                                    @if ($sekolah?->level == 'MA')
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" disabled value="5"
                                                {{ in_array('5', json_decode($soal[$i]['kunci'])) ? 'checked' : '' }}
                                                data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}5"
                                                name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                            <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}[]">
                                                @php echo $soal[$i]['pil_5']; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                    @endif

                                    @if ($jawab_soal)
                                        @if (in_array('1', json_decode($jawab_soal->jawaban)))
                                            <b>JAWABAN SISWA : A</b> <br>
                                        @endif
                                        @if (in_array('2', json_decode($jawab_soal->jawaban)))
                                            <b>JAWABAN SISWA : B</b> <br>
                                        @endif
                                        @if (in_array('3', json_decode($jawab_soal->jawaban)))
                                            <b>JAWABAN SISWA : C</b> <br>
                                        @endif
                                        @if (in_array('4', json_decode($jawab_soal->jawaban)))
                                            <b>JAWABAN SISWA : D</b> <br>
                                        @endif
                                        @if (in_array('5', json_decode($jawab_soal->jawaban)))
                                            <b>JAWABAN SISWA : E</b> <br>
                                        @endif
                                    @endif

                                </div>
                            </div>
                        </div>
                    @elseif($soal[$i]['jenis_soal'] == 3)
                        @php
                            $jawaban = $jawab_soal?->jawaban;
                            $jawaban_singkat = $soal[$i]['jawaban_singkat'];
                            $jenis_hrf = $soal[$i]['jenis_hrf'];
                            $jenis_hrf = in_array('sensitif', json_decode($soal[$i]['jenis_hrf'])) ? 'sensitif' : 'nonsensitif';
                            if ($jenis_hrf === 'sensitif') {
                                if (strcmp($jawaban, $jawaban_singkat) === 0) {
                                    $verif = 'border-success';
                                } else {
                                    $verif = 'border-danger';
                                }
                            } else {
                                if (strcasecmp($jawaban, $jawaban_singkat) === 0) {
                                    $verif = 'border-success';
                                } else {
                                    $verif = 'border-danger';
                                }
                            }
                        @endphp
                        <div class="jenis_3">
                            <div class="card border {{ $verif }}">
                                <div class="card-header">
                                    <h4>
                                        SOAL NO <span class="badge badge-primary" style="margin-top: -5px;">
                                            {{ $nomor++ }}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @php echo $soal[$i]['soal'] @endphp
                                    <hr>
                                    <textarea class="form-control" name="" id="" rows="3" style="height: 70px;" disabled>{{ $soal[$i]['jawaban_singkat'] }}</textarea>
                                    <hr>
                                    <b>JAWABAN SISWA : </b><br>
                                    <textarea class="form-control" name="" id="" rows="2" style="height: 50px;" disabled>{{ $jawab_soal->jawaban }}</textarea>
                                    @if (!empty($soal[$i]['jenis_hrf']))
                                        <b>-
                                            {{ in_array('sensitif', json_decode($soal[$i]['jenis_hrf'])) ? 'diaktifkan sensitif' : 'non aktifkan sensitif' }}</b>
                                    @else
                                    @endif
                                    <br>
                                    @if (!empty($soal[$i]['jenis_inp']))
                                        <b>-
                                            {{ in_array('karakter', json_decode($soal[$i]['jenis_inp'])) ? 'huruf/karakter' : 'hanya angka' }}</b>
                                    @else
                                    @endif

                                </div>
                            </div>
                        </div>
                    @elseif($soal[$i]['jenis_soal'] == 4)
                        <div class="jenis_4">
                            <div
                                class="card border {{ $jawab_soal?->jawaban == $soal[$i]['kunci'] ? 'border-success' : 'border-danger' }}">
                                <div class="card-header">
                                    <h4>
                                        SOAL NO <span class="badge badge-primary" style="margin-top: -5px;">
                                            {{ $nomor++ }}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @php echo $soal[$i]['soal'] @endphp
                                    <hr>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" disabled value="1"
                                            {{ $soal[$i]['kunci'] == 1 ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}1"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}1">
                                            Benar
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" disabled value="2"
                                            {{ $soal[$i]['kunci'] == 2 ? 'checked' : '' }}
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}2"
                                            name="{{ $soal[$i]['id'] }}" class="custom-control-input answer">
                                        <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}2">
                                            Salah
                                        </label>
                                    </div>
                                    <hr>
                                    <b>JAWABAN SISWA : </b><br>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="" disabled checked
                                            class="custom-control-input">
                                        <label class="custom-control-label">
                                            {{ $jawab_soal?->jawaban == 1 ? 'Benar' : 'Salah' }}
                                        </label> <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($soal[$i]['jenis_soal'] == 5)
                        <div class="jenis_5">
                            <div
                                class="card border {{ $jawab_soal?->jawaban == $soal[$i]['kunci'] ? 'border-success' : 'border-danger' }}">
                                <div class="card-header">
                                    <h4>
                                        SOAL NO <span class="badge badge-primary" style="margin-top: -5px;">
                                            {{ $nomor++ }}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @php echo $soal[$i]['soal'] @endphp
                                    <hr>
                                    <div class="d-flex">
                                        <div class="form-group p-3">
                                            <b>Soal</b>
                                            <div class="" id="soal_jdh_array">
                                                @foreach (json_decode($soal[$i]['soal_jdh_array']) as $index => $item)
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
                                                @foreach (json_decode($soal[$i]['jawaban_jdh']) as $index => $item)
                                                    @php
                                                        $kunci = json_decode($soal[$i]['kunci'])[$index];
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
                                    <b>JAWABAN SISWA : </b><br>
                                    <div class="input-group-prepend d-flex">
                                        @foreach (json_decode($jawab_soal?->jawaban) as $index => $row)
                                            @php
                                                $kunci = json_decode($jawab_soal?->jawaban)[$index];
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

                                            <span
                                                class="input-group-text font-weight-bold text-light {{ $bgColor }} mr-2"
                                                id="kunci">{{ $kunci }}</span>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            @endif
            @include('layout.footer')
        </div>
    @endif
</body>

</html>
