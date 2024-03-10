@extends('master')
@section('title', 'Data Guru - ')
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
                        <h4><i class="fa-solid fa-person-chalkboard far "></i> Data keseluruhan guru</h4>
                        <div class="card-header-form">
                            <div class="dropdown d-inline dropleft">
                                <button type="button" class="btn btn-primary btn-sm " aria-expanded="false" data-toggle="modal" data-target="#addModal">
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <form action="{{ url('admin/master-data/guru') }}" method="GET"
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
                        @if (isset($_GET['s']))
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="10px">#</th>
                                        <th>NIP/NIK</th>
                                        <th>Nama Guru</th>
                                        <th>Sekolah</th>
                                        <th>Password Akun</th>
                                        <th width="10px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

        </section>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal">Tambah Guru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/master-data/guru') }}" method="POST" class="needs-validation" novalidate=""
                    id="formSimpan">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Sekolah</label>
                            <select name="sekolah_id" class="form-control" required="" id="">
                                <option value="">- PILIH SEKOLAH -</option>
                                @foreach ($sekolah as $s)
                                    <option value="{{ $s->id }}">- {{ $s->nama }} -</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih Sekolah Dahulu
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nip/Nik</label>
                            <input type="text" placeholder="Masukkan NIP/NIK Guru" class="form-control"
                                name="nip_nik_nisn" required="" id="">
                            <div class="invalid-feedback">
                                Masukkan NIP/NIK Guru
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input type="text" placeholder="Masukkan Nama Guru" class="form-control" name="nama"
                                required="" id="">
                            <div class="invalid-feedback">
                                Masukkan Nama Guru
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>Password</label>
                            <input type="text" placeholder="Masukkan Password Guru" class="form-control" name="password"
                                required="" id="">
                            <div class="invalid-feedback">
                                Masukkan Password Guru
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
                    <h5 class="modal-title" id="updateModal">Update Guru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/master-data/guru/update') }}" id="formUpdate" method="POST"
                    class="needs-validation" novalidate="">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Sekolah</label>
                            <select name="sekolah_id" id="sekolah_id" class="form-control" required="">
                                <option value="">- PILIH SEKOLAH -</option>
                                @foreach ($sekolah as $s)
                                    <option value="{{ $s->id }}">- {{ $s->nama }} -</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih Sekolah Dahulu
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nip/Nik</label>
                            <input type="text" placeholder="Masukkan NIP/NIK Guru" class="form-control"
                                name="nip_nik_nisn" required="" id="nip_nik_nisn">
                            <div class="invalid-feedback">
                                Masukkan NIP/NIK Guru
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input type="text" placeholder="Masukkan Nama Guru" class="form-control" name="nama"
                                required="" id="nama">
                            <div class="invalid-feedback">
                                Masukkan Nama Guru
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>Password</label>
                            <input type="text" placeholder="Masukkan Password Guru" class="form-control"
                                name="password" required="" id="password">
                            <div class="invalid-feedback">
                                Masukkan Password Guru
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/master-data/guru/all') }}",
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
                        data: 'nip_nik_nisn',
                        name: 'nip_nik_nisn'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'sekolah_name',
                        name: 'sekolah_name'
                    },
                    {
                        data: 'password_view',
                        name: 'password_view'
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
                    url: "{{ url('admin/master-data/guru/get') }}",
                    success: function(data) {
                        $('#id').val(data.id);
                        $('#sekolah_id').val(data.sekolah_id);
                        $('#nip_nik_nisn').val(data.nip_nik_nisn);
                        $('#password').val(data.password_view);
                        $('#nama').val(data.nama);

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
                        title: "Hapus Guru ?",
                        text: "Data Guru ini akan dihapus",
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
                                url: "{{ url('admin/master-data/guru') }}",
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
        });
    </script>
@endsection
