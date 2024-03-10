@extends('master')
@section('title', 'Jadwal Ujian - ')
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
                        <h4><i class="fa-solid fa-calendar-days far"></i> Data Jadwal Ujian</h4>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <form action="{{ url('admin/monitoring/jadwal') }}" method="GET"
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
                                            <select name="ta" class="form-control kelas" required="">
                                                <option value="">- TAHUN AJARAN -</option>
                                                @foreach($tahun as $t)
                                                    <option {{(@$_GET['ta'] == $t->id) ? 'selected' : ''}} value="{{$t->id}}">{{$t->tahun}}</option>
                                                @endforeach
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
                                    <th>Mapel</th>
                                    <th>Pengampu</th>
                                    <th>Total Kelas</th>
                                    <th>Status Jadwal</th>
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
    @if (isset($_GET['s']) && isset($_GET['ta']))
        <script>
            $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/monitoring/jadwal/all') }}",
                    "type": "GET",
                    "data": {
                        's': "{{ request()->get('s') }}",
                        'ta': "{{request()->get('ta')}}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_mapel',
                        name: 'nama_mapel'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'total_kelas',
                        name: 'total_kelas'
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
@endsection
