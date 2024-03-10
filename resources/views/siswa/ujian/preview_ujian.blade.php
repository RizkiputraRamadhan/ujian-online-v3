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
    <div class="container">
        <br><br><br><br><br><br><br>
        @if(count($soal) == 0)
            <div class="text-center">Soal tidak ada</div>
        @else
            <div class="alert alert-light alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Petunjuk</div>
                    1. Pastikan anda telah menjawab semua soal yang ada <br>
                    2. Jika ada soal yang belum terjawab klik menu <b>KEMBALI</b> untuk mengerjakan soal<br>
                    3. Kumpulkan ujian dengan menekan menu  <b>YAKIN & KUMPULKAN UJIAN</b>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        Preview Ujian
                    </h4>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total Soal</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ count($soal) }}" name="" id=""
                                class="form-control bg-white" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total Dijawab</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ $soal_dijawab }}" name="" id=""
                                class="form-control bg-white" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total Belum Dijawab</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ $soal_tidak_dijawab }}" name="" id=""
                                class="form-control bg-white" readonly>
                            @if($soal_dijawab == count($soal))
                                <small class="text-success mt-3">
                                    Soal Dijawab Lengkap
                                </small>
                            @else
                                <small class="text-danger mt-3">
                                    Soal Belum Dijawab Lengkap
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{url('siswa/ujian/view/'.request()->segment(4).'/'.request()->segment(5))}}" type="button" class="btn btn-danger mb-5" style="float: left;">
                Kembali
            </a>
            <form onsubmit="hapusSesiCheckbox(); return confirm('Kumpulkan Ujian');" action="{{url('siswa/ujian/submit')}}" method="post">
                @csrf
                <input type="hidden" value="{{request()->segment(4)}}" name="jadwal_id">
                <input type="hidden" value="{{request()->segment(5)}}" name="no_peserta">
                <button type="submit" class="btn btn-primary mb-5" style="float: right;">
                    Yakin & Kumpulkan Ujian
                </button>
            </form>
        @endif
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
    function hapusSesiCheckbox() {
        $('input[type="checkbox"]').each(function() {
            sessionStorage.removeItem($(this).attr('id'));
        });
    }
</script>
<script>
    var countDownDate = new Date("{{$jadwal?->tanggal .' '. $jadwal?->jam_selesai.':00'}}").getTime();
    var x = setInterval(function() {
    var now = new Date().getTime();
    var distance = countDownDate - now;
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    document.getElementById("time").innerHTML =  hours + " Jam " + minutes + " Menit " + seconds + " Detik ";
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("time").innerHTML = "EXPIRED";
            Toast.fire({
                icon: 'warning',
                title: "Waktu Habis ...."
            });

            $.ajax({
                data: {
                    'jadwal_id': "{{request()->segment(4)}}",
                    'no_peserta': "{{request()->segment(5)}}",
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
                        window.location.href = "{{url('siswa')}}"
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
    document.addEventListener('contextmenu', event => event.preventDefault());
    window.addEventListener("keydown",function (e) {
        if (e.keyCode === 114 || (e.ctrlKey && e.keyCode === 70)) {
            e.preventDefault();
        }
    });
</script>
</html>
