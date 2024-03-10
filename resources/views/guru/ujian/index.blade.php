@extends('master')
@section('title', 'Jadwal Ujian - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                @if ($setting->blok_kecurangan == 'Y')
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
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>List Ujian yang untuk diawasi</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Kelas</th>
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
    <script>
        $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('guru/ujian/all') }}",
                "type": "GET"
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
                    data: 'kelas',
                    name: 'kelas'
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
    </script>
@endsection
