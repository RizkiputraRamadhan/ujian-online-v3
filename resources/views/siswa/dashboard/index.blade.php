@extends('siswa.master')
@section('title', 'Selamat Datang - ')
@section('content')
    <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="{{ url('siswa') }}" class="nav-link"><i class="fa-solid fa-globe"></i><span>Jadwal
                            Ujian</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('siswa/profile') }}" class="nav-link"><i class="fa-solid fa-user"></i><span>Profil
                            Saya</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-content">
        @if ($setting->blok_kecurangan == 'Y')
            <div class="alert alert-light alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Peraturan Fitur Anti Cheattings</div>
                    1. Tidak diperbolehkan berganti browser pada saat memulai ujian<br>
                    2. Tidak diperbolehkan menambah tab baru pada browser ujian<br>
                    3. Tidak diperbolehkan membuka aplikasi lain selain halaman ujian<br>
                    4. Tidak diperbolehkan screenshot halaman ujian<br>
                    5. Jika melanggar pasal 1,2,3,4 maka akan <b>TERBLOKIR OTOMATIS</b><br>
                </div>
            </div>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Fitur anti cheatting diaktifkan
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <section class="section">
            <div class="section-body" style="margin-top: -10px;">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif (session()->has('blokir'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session()->get('blokir') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Berikut ujian yang perlu anda ikuti</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Mapel</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                    <th width="10px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @if ($setting->blok_kecurangan == 'Y')
        <div class="modal fade" id="popup_aturan" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="popup_aturanLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="popup_aturanLabel">Peringatan !!</h5>
                    </div>
                    <div class="modal-body">
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
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Fitur anti cheatting diaktifkan
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary popup_setuju" data-dismiss="modal">Saya
                            Setuju</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (!session()->get('popup_aturan'))
        @php session()->put(['popup_aturan'=>true]) @endphp
        <script>
            $('#popup_aturan').modal('show');
        </script>
    @endif

    <script>
        $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('siswa/all') }}",
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'nama_mapel',
                    name: 'nama_mapel'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'mulai_selesai',
                    name: 'mulai_selesai'
                },
                {
                    data: 'status_jadwal',
                    name: 'status_jadwal'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });

        function hapusSesiYangDimulaiDenganJawab() {
            for (var i = 0; i < sessionStorage.length; i++) {
                var key = sessionStorage.key(i);
                if (key.startsWith('jawab')) {
                    sessionStorage.removeItem(key);
                }
            }
        }

        function hapusSesiSecaraBerkala() {
            hapusSesiYangDimulaiDenganJawab();
            setTimeout(hapusSesiSecaraBerkala, 1000);
        }

        hapusSesiSecaraBerkala();
    </script>
@endsection
