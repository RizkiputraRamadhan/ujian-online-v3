@extends('master')
@section('title', 'Monitoring Ujian - ')
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
                        <h4><i class="fa-solid fa-gear far"></i> Settings Ujian</h4>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <form action="{{ url('admin/monitoring/ujian') }}" method="GET"
                                style="margin-top:-10px; margin-left:-23px;">
                                <div class="row">
                                    <div class="col-lg-5 col-xl-5 col">
                                        <div class="form-group mb-3 mt-0">
                                            <select name="s" class="form-control sekolah" required="">
                                                <option value="">- PILIH SEKOLAH -</option>
                                                @foreach ($sekolah as $s)
                                                    <option {{ @$_GET['s'] == $s->id ? 'selected' : '' }}
                                                        value="{{ $s->id }}">- {{ strtoupper($s->nama) }} -</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-xl-5 col">
                                        <div class="form-group mb-3 mt-0">
                                            <select name="k" class="form-control kelas" required="">
                                                <option value="">- PILIH KELAS -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-xl-1 col">
                                        <div class="form-group mb-3 mt-0">
                                            <button type="submit" class="btn btn-primary mt-1">
                                                Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Mapel</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Pengawas</th>
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

    @if (isset($_GET['s']) && isset($_GET['k']))
        <script>
            $('.kelas').find('option').remove().end().append(
                '<option value="">- PILIH KELAS -</option>').val('');
            $.ajax({
                data: {
                    'id': "{{ request()->get('s') }}",
                },
                type: 'GET',
                url: "{{ url('admin/master-data/siswa/kelas') }}",
                success: function(data) {
                    $.each(data, function(i, data) {
                        $('.kelas').append($('<option>', {
                            value: data.id,
                            text: '- Kelas ' + data.tingkat_kelas + ' ( ' + data.urusan_kelas +
                                ' ) ( Jurusan ' + data.jurusan + ' ) -'
                        }));
                    });
                    $('.kelas').val("{{ request()->get('k') }}");
                },
                error: function(err) {
                    alert(err);
                    console.log(err);
                }
            });
        </script>
        <script>
            $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/monitoring/ujian/all') }}",
                    "type": "GET",
                    "data": {
                        's': "{{ request()->get('s') }}",
                        'k': "{{request()->get('k')}}"
                    }
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
                        data: 'pengawas',
                        name: 'pengawas'
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
    @endif

    <script>
        $(document).ready(function() {
            $('.sekolah').on('change', function() {
                $('.kelas').find('option').remove().end().append(
                    '<option value="">- PILIH KELAS -</option>').val('');
                $.ajax({
                    data: {
                        'id': $(this).val(),
                    },
                    type: 'GET',
                    url: "{{ url('admin/master-data/siswa/kelas') }}",
                    success: function(data) {
                        $.each(data, function(i, data) {
                            $('.kelas').append($('<option>', {
                                value: data.id,
                                text: '- Kelas ' + data.tingkat_kelas +
                                    ' ( ' + data.urusan_kelas +
                                    ' ) ( Jurusan ' + data.jurusan + ' ) -'
                            }));
                        });
                    },
                    error: function(err) {
                        alert(err);
                        console.log(err);
                    }
                });
            });
        });
    </script>
@endsection
