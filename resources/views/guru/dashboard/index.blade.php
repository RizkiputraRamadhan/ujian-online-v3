@extends('master')
@section('title', 'Dashboard Guru - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h6>Selamat datang bapak/ibu guru {{ session()->get('nama') }}  </h6>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa-regular fa-calendar-days far"></i> Jadwal Mengawasi Hari Ini {{ $today }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="jadwal-ujian">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Mapel</th>
                                    <th>Jam</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th width="20px">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>


    @if(!session()->get('popup_aturan'))
        @php session()->put(['popup_aturan'=>true]) @endphp
        <script>
            $('#popup_aturan').modal('show');
        </script>
    @endif

    <script>
        $('#jadwal-ujian').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('guru/jadwal-hari-ini') }}",
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
                    data: 'mulai_selesai',
                    name: 'mulai_selesai'
                },
                {
                    data: 'kelas',
                    name: 'kelas'
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
