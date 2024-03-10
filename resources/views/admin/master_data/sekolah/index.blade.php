@extends('master')
@section('title', 'Data Sekolah - ')
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
                        <h4><i class="fa-solid fa-school text-primary"></i> Data Sekolah</h4>
                        <div class="card-header-form">
                            <a href="{{url('admin/master-data/sekolah/add')}}" type="button"
                                class="btn btn-primary btn-sm"> Tambah</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Sekolah</th>
                                    <th>Tahun Ajaran Aktif</th>
                                    <th>Semester Aktif</th>
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
            ajax: "{{ url('admin/master-data/sekolah/all') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data:'tahun',
                    name:'tahun'
                },
                {
                    data:'semester',
                    name:'semester'
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
                    title: "Hapus Sekolah ?",
                    text: "Sekolah akan dihapus, dan mungkin akan berpengaruh pada data ujian pada sekolah ini",
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
                            url: "{{ url('admin/master-data/sekolah') }}",
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
@endsection
