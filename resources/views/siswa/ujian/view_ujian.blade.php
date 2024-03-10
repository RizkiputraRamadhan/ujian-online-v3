<!DOCTYPE html>
<html lang="en" class="notranslate">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="google" content="notranslate">
    <meta translate="no">
    <link href="{{ asset('assets/img/kemenag.png') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('dist/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mix/app.css') }}">
    <script src="{{ asset('assets/mix/app.js') }}"></script>
    <script src="{{ asset('dist/sweetalert/sweetalert2.min.js') }}""></script>
    <title>Ujian dimulai</title>
    <style>
        .soal-content {
            color: black;
            font-size: 16px;
        }

        .awesome-fancy-styling {
            width: 100%;
            height: 100%;
            background-color: black;
            z-index: 9999;
            font-size: 30px;
            color: red;
            text-align: center;
            position: absolute;
        }
    </style>
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
                Soal Ujian
            </a>
            <div id="navbarText">
                <ul class="navbar-nav mr-auto">
                </ul>
                <span class="navbar-text h5 mt-1" id="time">
                    00:00:00
                </span>
            </div>
        </div>
    </nav>
    <div class="">
        <form action="/blokir" method="post" class="d-none">
            @csrf
            <input type="" name="id" value="{{ session()->get('id') }}">
            <input type="" name="status_blokir" value="Y">
            <button type="submit" id="blokir"></button>
        </form>
    </div>
    <div class="container">
        <br><br><br><br><br><br><br>
        @if (count($total_soal) == 0)
            <div class="text-center">Soal tidak ada</div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    @for ($i = 0; $i < count($soal); $i++)
                        @php $jawab_soal = \App\Models\BankJawaban::jawabSiswa($kehadiran?->id, $mapel?->id, request()->session()->get('id'), $soal[$i]['id']); @endphp
                        <div class="card">
                            <div class="card-header">
                                <h4>
                                    SOAL NO <span class="badge badge-primary" style="margin-top: -5px;">
                                        {{ @$no }}</span>
                                </h4>
                            </div>
                            <div class="card-body soal-content">
                                @php echo $soal[$i]['soal'] @endphp
                                <hr>
                                @if ($soal[$i]['jenis_soal'] == 1)
                                    <div class="pilihan_1">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="1"
                                                {{ $jawab_soal?->jawaban == 1 ? 'checked' : '' }}
                                                data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}1"
                                                name="{{ $soal[$i]['id'] }}"
                                                class="custom-control-input answer jenis_{{ $soal[$i]['jenis_soal'] }}">
                                            <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}1">
                                                @php echo $soal[$i]['pil_1']; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="2"
                                                {{ $jawab_soal?->jawaban == 2 ? 'checked' : '' }}
                                                data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}2"
                                                name="{{ $soal[$i]['id'] }}"
                                                class="custom-control-input answer jenis_{{ $soal[$i]['jenis_soal'] }}">
                                            <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}2">
                                                @php echo $soal[$i]['pil_2']; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="3"
                                                {{ $jawab_soal?->jawaban == 3 ? 'checked' : '' }}
                                                data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}3"
                                                name="{{ $soal[$i]['id'] }}"
                                                class="custom-control-input answer jenis_{{ $soal[$i]['jenis_soal'] }}">
                                            <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}3">
                                                @php echo $soal[$i]['pil_3']; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="4"
                                                {{ $jawab_soal?->jawaban == 4 ? 'checked' : '' }}
                                                data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}4"
                                                name="{{ $soal[$i]['id'] }}"
                                                class="custom-control-input answer jenis_{{ $soal[$i]['jenis_soal'] }}">
                                            <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}4">
                                                @php echo $soal[$i]['pil_4']; @endphp
                                            </label>
                                        </div>
                                        <hr>
                                        @if ($sekolah?->level == 'MA')
                                            <div class="custom-control custom-radio">
                                                <input type="radio" value="5"
                                                    {{ $jawab_soal?->jawaban == 5 ? 'checked' : '' }}
                                                    data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}5"
                                                    name="{{ $soal[$i]['id'] }}"
                                                    class="custom-control-input answer jenis_{{ $soal[$i]['jenis_soal'] }}">
                                                <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}5">
                                                    @php echo $soal[$i]['pil_5']; @endphp
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                @elseif($soal[$i]['jenis_soal'] == 2)
                                    <div class="pilihan_2">
                                        <input type="checkbox" class="answer jenis_{{ $soal[$i]['jenis_soal'] }}"
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}1"
                                            name="{{ $soal[$i]['id'] }}[]" value="1">
                                        <label for="jawab{{ $soal[$i]['id'] }}1">@php echo $soal[$i]['pil_1']; @endphp</label><br>
                                        <hr>
                                        <input type="checkbox" class="answer jenis_{{ $soal[$i]['jenis_soal'] }}"
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}2"
                                            name="{{ $soal[$i]['id'] }}[]" value="2">
                                        <label for="jawab{{ $soal[$i]['id'] }}2">@php echo $soal[$i]['pil_2']; @endphp</label><br>
                                        <hr>
                                        <input type="checkbox" class="answer jenis_{{ $soal[$i]['jenis_soal'] }}"
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}3"
                                            name="{{ $soal[$i]['id'] }}[]" value="3">
                                        <label for="jawab{{ $soal[$i]['id'] }}3">@php echo $soal[$i]['pil_3']; @endphp</label><br>
                                        <hr>
                                        <input type="checkbox" class="answer jenis_{{ $soal[$i]['jenis_soal'] }}"
                                            data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}4"
                                            name="{{ $soal[$i]['id'] }}[]" value="4">
                                        <label for="jawab{{ $soal[$i]['id'] }}4">@php echo $soal[$i]['pil_4']; @endphp</label><br>
                                        <hr>
                                        @if ($sekolah?->level == 'MA')
                                            <input type="checkbox" class="answer jenis_{{ $soal[$i]['jenis_soal'] }}"
                                                data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}5"
                                                name="{{ $soal[$i]['id'] }}[]" value="5">
                                            <label for="jawab{{ $soal[$i]['id'] }}5">@php echo $soal[$i]['pil_5']; @endphp</label><br>
                                        @endif
                                        <small class="text-danger">
                                            *Bisa memilih lebih dari 1 (satu) jawaban
                                        </small>
                                    </div>
                                @elseif($soal[$i]['jenis_soal'] == 3)
                                    <div class="pilihan_3">
                                        @if (json_decode($soal[$i]['jenis_inp'])[0] === 'angka')
                                            <input
                                                class="form-control jenis_{{ $soal[$i]['jenis_soal'] }} form-control-lg border border-primary jawaban-input"
                                                data-id="{{ $soal[$i]['id'] }}" type="number"
                                                name="jawaban_singkat"
                                                value="{{ $jawab_soal ? $jawab_soal->jawaban : '' }}">
                                        @else
                                            <textarea class="form-control jenis_{{ $soal[$i]['jenis_soal'] }} jawaban-input" data-id="{{ $soal[$i]['id'] }}"
                                                name="jawaban_singkat" id="" rows="3" style="height: 70px;">{{ $jawab_soal ? $jawab_soal->jawaban : '' }}</textarea>
                                        @endif
                                        <br>
                                        <small class="text-danger">
                                            {{ in_array('sensitif', json_decode($soal[$i]['jenis_hrf'])) ? '*Jawaban sensitif dengan huruf besar dan kecil ' : ' ' }}
                                        </small>
                                    </div>
                                @elseif($soal[$i]['jenis_soal'] == 4)
                                    <div class="pilihan_4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="1"
                                                {{ $jawab_soal?->jawaban == 1 ? 'checked' : '' }}
                                                data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}1"
                                                name="{{ $soal[$i]['id'] }}"
                                                class="custom-control-input answer jenis_{{ $soal[$i]['jenis_soal'] }}">
                                            <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}1">
                                                Benar
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="2"
                                                {{ $jawab_soal?->jawaban == 2 ? 'checked' : '' }}
                                                data-id="{{ $soal[$i]['id'] }}" id="jawab{{ $soal[$i]['id'] }}2"
                                                name="{{ $soal[$i]['id'] }}"
                                                class="custom-control-input answer jenis_{{ $soal[$i]['jenis_soal'] }}">
                                            <label class="custom-control-label" for="jawab{{ $soal[$i]['id'] }}2">
                                                Salah
                                            </label>
                                        </div>
                                    </div>
                                @elseif($soal[$i]['jenis_soal'] == 5)
                                    <div class="d-flex m-auto justify-content-center ">
                                        <div class="form-group p-3">
                                            <b>Soal</b>
                                            <div class="" id="soal_jdh_array">
                                                @foreach (json_decode($soal[$i]['soal_jdh_array']) as $index => $soal_array)
                                                    @php
                                                        $bgSoal = '';

                                                        switch ($index + 1) {
                                                            case 1:
                                                                $bgSoal = 'bg-primary';
                                                                break;
                                                            case 2:
                                                                $bgSoal = 'bg-success';
                                                                break;
                                                            case 3:
                                                                $bgSoal = 'bg-warning';
                                                                break;
                                                            case 4:
                                                                $bgSoal = 'bg-info';
                                                                break;
                                                            case 5:
                                                                $bgSoal = 'bg-dark';
                                                                break;
                                                            default:
                                                                $bgSoal = 'bg-primary';
                                                                break;
                                                        }
                                                    @endphp
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span
                                                                class="input-group-text font-weight-bold {{ $bgSoal }} text-light"
                                                                id="basic-addon{{ $index + 1 }}">{{ $index + 1 }}</span>
                                                        </div>
                                                        <input type="text" class="form-control font-weight-bold"
                                                            placeholder="Soal {{ $index + 1 }}"
                                                            aria-label="soal_{{ $index + 1 }}"
                                                            aria-describedby="basic-addon1" id="soal_jdh_array"
                                                            disabled value="{{ $soal_array }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group p-3">
                                            <b>Jawaban</b>
                                            <div class="">

                                                @foreach (json_decode($soal[$i]['jawaban_jdh']) as $index => $jawaban_array)
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <select
                                                                class="custom-select w-3 font-weight-bold kunci_jdh"
                                                                data-id="{{ $soal[$i]['id'] }}" name="kunci_jdh[]">
                                                                <option selected></option>
                                                                @foreach (json_decode($soal[$i]['kunci']) as $idx => $row)
                                                                    <option value="{{ $idx + 1 }}">
                                                                        {{ $idx + 1 }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control font-weight-bold"
                                                            placeholder="jawaban {{ $index + 1 }}"
                                                            aria-label="jawaban {{ $index + 1 }}"
                                                            aria-describedby="basic-addon1"
                                                            value="{{ $jawaban_array }}" disabled>
                                                        <div class="input-group-prepend">
                                                            @php
                                                                $decoded_jawaban = $jawab_soal?->jawaban
                                                                    ? json_decode($jawab_soal->jawaban)
                                                                    : '';
                                                            @endphp

                                                            @if (!empty($decoded_jawaban))
                                                                @php
                                                                    $kunci = $decoded_jawaban[$index] ?? null;
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
                                                                    class="input-group-text font-weight-bold {{ $bgColor }} text-light"
                                                                    id="basic-addon">
                                                                    {{ $kunci }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                    </div>
                                                @endforeach
                                                <div class="text-left d-flex justify-content-end">
                                                    <button
                                                        class="btn btn-primary d-block d-sm-inline-block d-md-inline-block answer_jdh"
                                                        data-id="{{ $soal[$i]['id'] }}">Simpan Jawaban</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer bg-default">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                        @if ($prev != 0)
                                            <div class="text-left">
                                                <a href="{{ url('siswa/ujian/view/' . request()->segment(4) . '/' . request()->segment(5) . '?prev=' . $prev . '&key_prev=' . $key_prev) }}"
                                                    type="button"
                                                    class="btn btn-primary d-block d-sm-inline-block d-md-inline-block">
                                                    Sebelumnya
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                        <div class="text-center">
                                            <a href="#" type="button"
                                                class="btn btn-warning d-block d-sm-inline-block d-md-inline-block">
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                        {{ $jawab_soal?->status_jawaban == 'ragu_ragu' ? 'checked' : '' }}
                                                        type="checkbox" class="custom-control-input"
                                                        data-id="{{ $soal[$i]['id'] }} value="ragu_ragu"
                                                        id="ragu-ragu">
                                                    <label class="custom-control-label"
                                                        for="ragu-ragu">Ragu-Ragu</label>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                        @if ($next != 0)
                                            <div class="text-right">
                                                <a href="{{ url('siswa/ujian/view/' . request()->segment(4) . '/' . request()->segment(5) . '?next=' . $next . '&key_next=' . $key_next) }}"
                                                    type="button"
                                                    class="btn btn-primary d-block d-sm-inline-block d-md-inline-block">
                                                    Selanjutnya
                                                </a>
                                            </div>
                                        @else
                                            {{-- Kumpulin Ujian --}}
                                            <div class="text-right">
                                                <a href="{{ url('siswa/ujian/preview/' . request()->segment(4) . '/' . request()->segment(5)) }}"
                                                    type="button"
                                                    class="btn btn-success d-block d-sm-inline-block d-md-inline-block">
                                                    Kumpulkan Ujian
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Navigasi Soal</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($soal_id as $s)
                                    @php $jawab_soal = \App\Models\BankJawaban::jawabSiswa($kehadiran?->id, $mapel?->id, request()->session()->get('id'), $s['id']); @endphp
                                    <div class="col col-sm col-lg col-xl col-md">
                                        @if ($jawab_soal?->status_jawaban == 'ragu_ragu')
                                            @php $class = "btn btn-icon btn-light mt-2 bg-warning"; @endphp
                                        @elseif($jawab_soal?->jawaban == null)
                                            @php $class = "btn btn-icon btn-light mt-2"; @endphp
                                        @else
                                            @php $class = "btn btn-icon btn-light mt-2 bg-success"; @endphp
                                        @endif
                                        <a class="{{ $class }}"
                                            href="{{ url('siswa/ujian/view/' . request()->segment(4) . '/' . request()->segment(5) . '?next=' . $s['id'] . '&key_next=' . $s['key']) }}"
                                            type="button">
                                            {{ $s['no'] < 10 ? '0' . $s['no'] : $s['no'] }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer bg-default">
                            <span
                                class="text-success text-small border border-success bg-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <b class="text-small text-success"> Telah dijawab </b> <br>
                            <span class="text-default text-small border border-secondary bg-secondary">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <b class="text-small text-dark"> Belum
                                Dijawab</b> <br>
                            <span
                                class="text-warning text-small border border-warning bg-warning">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <b class="text-small text-warning"> Ragu-Ragu</b><br>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <br><br><br>
        @include('layout.footer')
    </div>
</body>
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
    window.addEventListener("keydown", function(e) {
        if (e.keyCode === 114 || (e.ctrlKey && e.keyCode === 70)) {
            e.preventDefault();
        }
    });

    var countDownDate = new Date("{{ $jadwal?->tanggal . ' ' . $jadwal?->jam_selesai . ':00' }}").getTime();
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("time").innerHTML = hours + " Jam " + minutes + " Menit " + seconds + " Detik ";
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("time").innerHTML = "EXPIRED";
            Toast.fire({
                icon: 'warning',
                title: "Waktu Habis ...."
            });

            $.ajax({
                data: {
                    'jadwal_id': "{{ request()->segment(4) }}",
                    'no_peserta': "{{ request()->segment(5) }}",
                    '_token': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ url('siswa/ujian/submit') }}",
                success: function(data) {
                    $('input[type="checkbox"]').each(function() {
                        sessionStorage.removeItem($(this).attr('id'));
                    });
                    Toast.fire({
                        icon: 'warning',
                        title: "Ujian telah dikumpulkan oleh sistem ...."
                    });
                    setTimeout(function() {
                        window.location.href = "{{ url('siswa') }}"
                    }, 1000);
                },
                error: function(err) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan'
                    });
                }
            });
        }
    }, 1000);
</script>
<script>
    $('input[type="checkbox"]').on('change', function() {
        sessionStorage.setItem($(this).attr('id'), $(this).prop('checked'));
    });

    $(document).ready(function() {
        $('input[type="checkbox"]').each(function() {
            var checked = sessionStorage.getItem($(this).attr('id'));
            if (checked === 'true') {
                $(this).prop('checked', true);
            }
        });
    });

    $('.jawaban-input').on('input', function() {
        var jawabanInput = $(this).val(); // Ambil nilai dari inputan
        var idSoal = $(this).data('id');
        $.ajax({
            data: {
                'banksoal_id': $(this).data('id'),
                'jawaban': jawabanInput, // Menggunakan nilai input yang telah ditangkap
                'mapel_id': "{{ $mapel?->id }}",
                'kehadiran_id': "{{ $kehadiran?->id }}",
                '_token': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: "{{ url('siswa/ujian/progress') }}",
            success: function(data) {
                if (data.status == true) {
                    alert("ANDA DIBLOKIR DARI UJIAN INI OLEH PENGAWAS");
                    setTimeout(function() {
                        window.location.href = "{{ url('siswa/ujian/blokir') }}"
                    }, 1000);
                }
                Toast.fire({
                    icon: 'success',
                    title: data.message
                });

            },
            error: function(err) {
                Toast.fire({
                    icon: 'error',
                    title: 'Progress tidak tersimpan'
                });
            }
        });
    });

    $('.answer_jdh').click(function() {
        kunci_jdh = []; // Initialize as array if it's a checkbox (jenis soal 2)
        $('.kunci_jdh').each(function() {
            kunci_jdh.push($(this).val());
        });
        console.log(kunci_jdh)
        $.ajax({
            data: {
                'banksoal_id': $(this).data('id'),
                'jawaban': kunci_jdh,
                'mapel_id': "{{ $mapel?->id }}",
                'kehadiran_id': "{{ $kehadiran?->id }}",
                '_token': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: "{{ url('siswa/ujian/progress') }}",
            success: function(data) {
                if (data.status == true) {
                    alert("ANDA DIBLOKIR DARI UJIAN INI OLEH PENGAWAS");
                    setTimeout(function() {
                        window.location.href = "{{ url('siswa/ujian/blokir') }}"
                    }, 1000);
                }
                console.log(data.status);
                Toast.fire({
                    icon: 'success',
                    title: data.message
                });
                setTimeout(function() {
                    window.location.href = ""
                }, 100);
            },
            error: function(err) {
                Toast.fire({
                    icon: 'error',
                    title: 'Progress tidak tersimpan'
                });
            }
        });
    })

    $('.answer').click(function() {
        var jenisSoal = $(this).hasClass('jenis_1') ? 1 : $(this).hasClass('jenis_2') ? 2 :
            3;

        var jawaban;
        if (jenisSoal === 2) {
            jawaban = []; // Initialize as array if it's a checkbox (jenis soal 2)
            $('.answer:checked').each(function() {
                jawaban.push($(this).val());
            });
        } else {
            jawaban = $(this).val();
        }
        $.ajax({
            data: {
                'banksoal_id': $(this).data('id'),
                'jawaban': jawaban,
                'mapel_id': "{{ $mapel?->id }}",
                'kehadiran_id': "{{ $kehadiran?->id }}",
                '_token': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: "{{ url('siswa/ujian/progress') }}",
            success: function(data) {
                if (data.status == true) {
                    alert("ANDA DIBLOKIR DARI UJIAN INI OLEH PENGAWAS");
                    setTimeout(function() {
                        window.location.href = "{{ url('siswa/ujian/blokir') }}"
                    }, 1000);
                }
                console.log(data.status);
                Toast.fire({
                    icon: 'success',
                    title: data.message
                });
            },
            error: function(err) {
                Toast.fire({
                    icon: 'error',
                    title: 'Progress tidak tersimpan'
                });
            }
        });
    });

    $('#ragu-ragu').change(function() {
        if ($(this).prop("checked") == true) {
            var status = "ragu_ragu";
        } else {
            var status = "yakin";
        }
        $.ajax({
            data: {
                'banksoal_id': $(this).data('id'),
                'status_jawaban': status,
                'mapel_id': "{{ $mapel?->id }}",
                'kehadiran_id': "{{ $kehadiran?->id }}",
                '_token': "{{ csrf_token() }}"
            },
            type: 'PUT',
            url: "{{ url('siswa/ujian/progress') }}",
            success: function(data) {
                if (data.status == true) {
                    alert("ANDA DIBLOKIR DARI UJIAN INI OLEH PENGAWAS");
                    setTimeout(function() {
                        window.location.href = "{{ url('siswa/ujian/blokir') }}"
                    }, 1000);
                }
                console.log(data.status);
                Toast.fire({
                    icon: 'success',
                    title: data.message
                });
            },
            error: function(err) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Pilih jawaban dulu yha'
                });
            }
        });
    });
</script>
@if ($setting->blok_kecurangan == 'Y')
    <script>
        function finishExam() {
            document.getElementById('blokir').click();
        }
        let examEnded = false;
        window.addEventListener("blur", function() {
            finishExam();
            if (!examEnded) {
                Swal.fire({
                    title: " Melanggar Peraturan Ujian!",
                    html: "Ujian tidak boleh membuka aplikasi lain. <br> Ujian Dinyatakan gagal !!.",
                    timer: 10000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            }
        });
        window.addEventListener('keyup', (e) => {
            if (e.key == 'PrintScreen') {
                navigator.clipboard.writeText('');
                Swal.fire({
                    title: " Melanggar Peraturan Ujian!",
                    html: "Ujian tidak boleh membuka aplikasi lain. <br> Ujian Dinyatakan gagal !!.",
                    timer: 11000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    willClose: () => {
                        finishExam();
                        clearInterval(timerInterval);
                    }
                });
            }
        });
        window.addEventListener("keydown", function(event) {
            if (event.key === "F5" || event.key === "F6" || event.key === "r" || event.key === "R") {
                event.preventDefault();
                finishExam();
            }
        });

        window.addEventListener("popstate", function(event) {
            history.pushState(null, null, window.location.href);
            finishExam();
        });



    </script>
@endif

</html>
