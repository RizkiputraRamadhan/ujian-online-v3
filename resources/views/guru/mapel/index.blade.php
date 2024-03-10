@extends('master')
@section('title', 'Data Mapel - ')
@section('content')
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
                        <h4>Data mapel yang diujikan</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Mapel</th>
                                    <th>Acak Soal</th>
                                    <th>Jumlah Soal</th>
                                    <th>Status Soal</th>
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
                "url": "{{ url('guru/mapel/all') }}",
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
                    data: 'nama_mapel',
                    name: 'nama_mapel'
                },
                {
                    data: 'acak_soal',
                    name: 'acak_soal'
                },
                {
                    data: 'jumlah_soal',
                    name: 'jumlah_soal'
                },
                {
                    data: 'status_soal',
                    name: 'status_soal'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    </script>
@endsection
