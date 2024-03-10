@extends('master')
@section('title', 'Detail Monitoring Ujian - ')
@section('content')
    <style>
        /* Style untuk toggle */
        .toggle {
            width: 60px;
            height: 30px;
            background-color: #ddd;
            border-radius: 15px;
            position: relative;
            cursor: pointer;
        }

        .toggle::before {
            content: '';
            position: absolute;
            width: 26px;
            height: 26px;
            background-color: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: 0.3s;
        }

        /* Animasi ketika toggle aktif */
        .toggle.active::before {
            transform: translateX(30px);
        }
    </style>

    <div class="main-content">
        <section class="section">
            <div class="section-body">
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
                        <h4><i class="fa-solid fa-wand-magic-sparkles far"></i> Settingan ujian anti cheattings</h4>
                    </div>
                    <br>
                    @if ($setting->blok_kecurangan == 'Y')
                    <div class="toggle ml-4 mb-4 active bg-success" id="togle" onclick="toggleSwitch(this)"></div>
                    <span class="ml-4"><i class="fa-solid fa-circle-check text-success"></i> anti cheattings aktif</span>
                    @else
                    <div class="toggle ml-4 mb-4 bg-danger" id="togle" onclick="toggleSwitch(this)"></div>
                    <span class="ml-4"><i class="fa-regular fa-circle-xmark text-danger"></i> anti cheattings nonaktif</span>
                    @endif
                    <div class="p-3">
                        <div class="alert alert-light alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Keterangan Fitur Anti Cheattings</div>
                                1. Tidak diperbolehkan berganti browser pada saat memulai ujian<br>
                                2. Tidak diperbolehkan menambah tab baru pada browser ujian<br>
                                3. Tidak diperbolehkan membuka aplikasi lain selain halaman ujian<br>
                                4. Tidak diperbolehkan screenshot halaman ujian<br>
                                5. Jika melanggar pasal 1,2,3,4 maka akan <b>TERBLOKIR OTOMATIS</b><br>
                            </div>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="alert alert-light alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Notifikasi</div>
                                <hr>
                                <div id="notifications"></div>
                            </div>
                        </div>
                    </div>
                    <form action=" " method="post" class="d-none">@csrf <input type="text" value=""> <button
                            type="submit" id="submit"></button></form>
                </div>
                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header" role="button" data-toggle="collapse"
                            data-target="#panel-detail-mapel">
                            <h4>Lihat Detail Jadwal Ujian</h4>
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa-solid fa-user-pen far"></i> Peserta Ujian</h4>
                    </div>
                    <form id="kehadiranForm" class="needs-validation" novalidate>
                        <div class="card-body">
                            <div class="overflow-auto">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" class="custom-control-input" id="parent">
                                                    <label for="parent" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>NISN</th>
                                            <th>No Peserta</th>
                                            <th>Nama Siswa</th>
                                            <th>Status Kehadiran</th>
                                            <th>Status Ujian</th>
                                            <th width="10px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswa as $s)
                                            @php $detail = \App\Models\Kehadiran::get(request()->segment(5), $s->id); @endphp
                                            <tr class="{{ $detail?->status_blokir == 'Y' ? 'text-danger' : '' }}">
                                                <td class="p-0 text-center">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" name="siswa_id[]"
                                                            class="custom-control-input child" id="{{ $s->id }}"
                                                            value="{{ $s->id }}">
                                                        <label for="{{ $s->id }}"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ $s->nip_nik_nisn }}</td>
                                                <td>{{ $detail == null ? 'BELUM DIATUR' : $detail?->no_peserta }}</td>
                                                <td>{{ $s->nama }}</td>
                                                <td>{{ $detail == null ? 'BELUM DIATUR' : $detail?->status_kehadiran }}
                                                </td>
                                                <td>{{ $detail == null ? 'BELUM DIATUR' : $detail?->status_ujian }}</td>
                                                <td>
                                                    @if ($detail == null)
                                                        -
                                                    @else
                                                        <div class="dropdown d-inline dropleft">
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm dropdown-toggle"
                                                                aria-haspopup="true" data-toggle="dropdown"
                                                                aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a data-id="{{ $detail?->id }}"
                                                                        data-status_blokir="{{ $detail?->status_blokir == 'Y' ? 'N' : 'Y' }}"
                                                                        data-message="{{ $detail?->status_blokir == 'Y' ? 'Buka blokir peserta ujian ini' : 'Blokir peserta ujian ini' }}"
                                                                        class="dropdown-item blokir-unblokir"
                                                                        href="#">{{ $detail?->status_blokir == 'Y' ? 'Buka Blokir' : 'Blokir Siswa' }}</a>
                                                                </li>
                                                                <li><a class="dropdown-item lihat-nilai" target="_blank"
                                                                        href="{{ url('admin/monitoring/ujian/preview/' . request()->segment(5) . '/' . $detail?->no_peserta . '/' . request()->segment(7) . '/' . $detail?->id) }}">Lihat
                                                                        Nilai</a></li>
                                                                <li><a data-id="{{ $detail?->id }}"
                                                                        class="dropdown-item reset-ujian"
                                                                        href="#">Reset Ujian</a></li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ request()->segment(6) }}">
                            <input type="hidden" name="jadwal_id" value="{{ request()->segment(5) }}">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <select name="status_kehadiran" class="form-control kelas" required="">
                                            <option value="">- PILIH KEHADIRAN -</option>
                                            <option value="HADIR">- HADIR -</option>
                                            <option value="TIDAK_HADIR">- TIDAK HADIR -</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih Status Kehadiran
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <button class="btn btn-primary" type="submit">Simpan & Mulai</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <script>
        function toggleSwitch(element) {
            element.classList.toggle('active');
            var switchState = element.classList.contains('active') ? 'on' : 'off';
            var toggleElement = document.getElementById('togle');
            var submit = document.getElementById('submit');
            if (switchState == 'off') {
                toggleElement.style.backgroundColor = 'red';
                submit.value = 'N';
                submit.click();
            } else {
                toggleElement.style.backgroundColor = 'green';
                submit.value = 'Y';
                submit.click();
            }
            sessionStorage.setItem('switchState', switchState);
        }

        function restoreSwitchState() {
            var switchState = sessionStorage.getItem('switchState');
            if (switchState === 'on') {
                var toggleElement = document.getElementById('togle');
                toggleElement.classList.add('active');
                toggleElement.style.backgroundColor = 'green';

            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            restoreSwitchState();
        });

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
        @endif

        $(document).ready(function() {
            $('#parent').click(function() {
                $('.child').prop('checked', this.checked);
            });

            $('.child').click(function() {
                if ($('.child:checked').length == $('.child').length) {
                    $('#parent').prop('checked', true);
                } else {
                    $('#parent').prop('checked', false);
                }
            });

            $('#kehadiranForm').submit(function(e) {
                e.preventDefault()
                $.ajax({
                    data: $(this).serialize(),
                    type: 'POST',
                    url: "{{ url('admin/monitoring/ujian/kehadiran') }}",
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
            $('.blokir-unblokir').on('click', function(e) {
                e.preventDefault();
                swal({
                        title: $(this).data('message'),
                        text: $(this).data('message'),
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willBlock) => {
                        if (willBlock) {
                            $.ajax({
                                data: {
                                    '_token': "{{ csrf_token() }}",
                                    'id': $(this).data('id'),
                                    'status_blokir': $(this).data('status_blokir'),
                                },
                                type: 'POST',
                                url: "{{ url('admin/monitoring/ujian/blokir') }}",
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
                                    alert("Error....");
                                }
                            });
                        }

                    });
            });
            $('.reset-ujian').on('click', function(e) {
                e.preventDefault();
                swal({
                        title: "Ujian ini akan direset",
                        text: "Jawaban akan direset ulang dan mungkin akan berpengaruh pada nilai peserta",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willBlock) => {
                        if (willBlock) {
                            $.ajax({
                                data: {
                                    '_token': "{{ csrf_token() }}",
                                    'id': $(this).data('id'),
                                },
                                type: 'POST',
                                url: "{{ url('admin/monitoring/ujian/reset') }}",
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
                                    alert("Error....");
                                }
                            });
                        }

                    });
            });

        });
    </script>
    <script>
        function fetchData() {
            fetch('http://127.0.0.1:8000/api/notifikasi')
            .then(response => response.json())
            .then(data => {
                console.log(data)
                let notifications = document.getElementById('notifications');
                notifications.innerHTML = ''; // Clear existing notifications before adding new ones
                data.notifikasi.forEach(notif => {
                    notifications.innerHTML += `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ${notif.nama}  ${notif.informasi}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Panggil fetchData() setiap 1 menit
        setInterval(fetchData, 6000); // 60000 milidetik = 1 menit

        // Panggil fetchData() saat halaman pertama kali dimuat
        fetchData();
        </script>

@endsection
