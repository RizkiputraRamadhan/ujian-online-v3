@extends('master')
@section('title', 'Tahun Ajaran - ')
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
                        <h4> <i class="fa-solid fa-calendar text-primary"></i> Data Tahun Ajaran</h4>
                        <div class="card-header-form">
                            <a href="#" data-toggle="modal" data-target="#addModal" type="button"
                                class="btn btn-primary btn-sm">Tambah</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Tahun Ajaran</th>
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
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal">Tambah Tahun Ajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/master-data/tahun-ajaran') }}" method="POST" class="needs-validation"
                    novalidate="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label>Tahun Ajaran</label>
                            <input type="text" name="tahun" placeholder="Contoh : 2022/2023" class="form-control"
                                required="">
                            <div class="invalid-feedback">
                                Masukkan Tahun Ajaran
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModal">Update Tahun Ajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/master-data/tahun-ajaran/update') }}" method="POST" class="needs-validation"
                    novalidate="">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label>Tahun Ajaran</label>
                            <input type="text" id="tahun" name="tahun" placeholder="Contoh : 2022/2023"
                                class="form-control" required="">
                            <div class="invalid-feedback">
                                Masukkan Tahun Ajaran
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/master-data/tahun-ajaran/all') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
        $('.table').on('click', '.edit[data-id]', function(e) {
            e.preventDefault();
            $.ajax({
                data: {
                    'id': $(this).data('id'),
                    '_token': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ url('admin/master-data/tahun-ajaran/get') }}",
                success: function(data) {
                    $('#id').val(data.id);
                    $('#tahun').val(data.tahun);
                    $('#updateModal').modal('show');
                },
                error: function(err) {
                    alert(err);
                    console.log(err);
                }
            });
        });
        $('.table').on('click', '.hapus[data-id]', function(e) {
            e.preventDefault();
            swal({
                    title: "Hapus Tahun Ajaran ?",
                    text: "Tahun Ajaran akan dihapus, dan mungkin akan berpengaruh pada data ujian pada tahun ajaran ini",
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
                            url: "{{ url('admin/master-data/tahun-ajaran') }}",
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
