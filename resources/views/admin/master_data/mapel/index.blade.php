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
                        <h4><i class="fa-solid fa-book-open-reader far"></i> Data Seluruh Mapel</h4>
                        <div class="card-header-form">
                            <a href="{{ url('admin/master-data/mapel/add') }}" type="button"
                                class="btn btn-primary btn-sm">Tambah</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <form action="{{ url('admin/master-data/mapel') }}" method="GET"
                                style="margin-top:-10px; margin-left:-23px;">
                                <div class="form-group mb-3 mt-0">
                                    <select name="s" onchange='if(this.value != "") { this.form.submit(); }'
                                        class="form-control" required="">
                                        <option value="">- PILIH SEKOLAH -</option>
                                        @foreach ($sekolah as $s)
                                            <option {{ @$_GET['s'] == $s->id ? 'selected' : '' }}
                                                value="{{ $s->id }}">- {{ strtoupper($s->nama) }} -</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Mapel</th>
                                    <th>Pengampu</th>
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
    @if (isset($_GET['s']))
        <script>
            $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/master-data/mapel/all') }}",
                    "type": "GET",
                    "data": {
                        'id': "{{ request()->get('s') }}"
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
                        data: 'nama',
                        name: 'nama'
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
            $('.table').on('click', '.hapus[data-id]', function(e) {
                e.preventDefault();
                swal({
                        title: "Hapus Mapel ?",
                        text: "Mapel ini akan dihapus selamanya",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                data: {
                                    'id': $(this).data('id'),
                                    '_token': "{{ csrf_token() }}"
                                },
                                type: 'DELETE',
                                url: "{{ url('admin/master-data/mapel') }}",
                                success: function(data) {
                                    swal(data.message)
                                        .then((result) => {
                                            location.reload();
                                        });
                                },
                                error: function(err) {
                                    alert(err);
                                    console.log(err);
                                }
                            });
                        }
                    });
            });
        </script>
    @endif
@endsection
