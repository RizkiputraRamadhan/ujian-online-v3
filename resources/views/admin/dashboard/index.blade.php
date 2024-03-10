@extends('master')
@section('title', 'Dashboard Admin - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fa-solid fa-school far" style="color: #ffffff;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Sekolah</h4>
                                </div>
                                <div class="card-body">
                                    {{ count($sekolah) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fa-solid fa-users-gear far"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Guru</h4>
                                </div>
                                <div class="card-body">
                                    {{ count($guru) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="far fa-solid fa-landmark"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Kelas</h4>
                                </div>
                                <div class="card-body">
                                    {{ count($kelas) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fa-solid fa-book-open-reader far"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Mapel</h4>
                                </div>
                                <div class="card-body">
                                    {{ count($mapel) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-12 col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Jadwal Ujian Hari {{$today}}</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="jadwal-ujian">
                                    <thead>
                                        <tr>
                                            <th width="10px">#</th>
                                            <th>Sekolah</th>
                                            <th>Mapel</th>
                                            <th>Mulai / Selesai</th>
                                            <th>Kelas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>

        $('#jadwal-ujian').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('admin/jadwal-hari-ini') }}",
                "type": "GET"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'nama_mapel',
                    name: 'nama_mapel'
                },
                {
                    data: 'mulai_selesai',
                    name: 'mulai_selesai'
                },
                {
                    data: 'kelas',
                    name: 'kelas'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
        
    </script>
@endsection
