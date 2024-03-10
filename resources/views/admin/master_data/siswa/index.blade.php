@extends('master')
@section('title', 'Data Siswa - ')
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
                        <h4><i class="fa-solid fa-users-viewfinder far"></i> Data Seluruh Siswa</h4>
                        <div class="card-header-form">
                            <div class="dropdown d-inline dropleft">
                                <button type="button" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#addModal">
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <form action="{{ url('admin/master-data/siswa') }}" method="GET"
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

                        <table class="table table-striped mt-5">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>NISN</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Password</th>
                                    <th>Tingkat Kelas</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal">Tambah Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" class="needs-validation" novalidate="" id="formSimpan">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Sekolah</label>
                            <select name="sekolah_id" class="form-control sekolah" required="" id="">
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
                            <label>Pilih Kelas</label>
                            <select name="kelas_id" class="form-control kelas" required="" id="">
                                <option value="">- PILIH KELAS -</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilih Kelas Dahulu
                            </div>
                        </div>
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" placeholder="Masukkan NIS" class="form-control" name="nis"
                                required="" id="">
                            <div class="invalid-feedback">
                                Masukkan NIS Siswa
                            </div>
                        </div>
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" placeholder="Masukkan NISN" class="form-control" name="nip_nik_nisn"
                                required="" id="">
                            <div class="invalid-feedback">
                                Masukkan NISN
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" placeholder="Masukkan Nama Siswa" class="form-control" name="nama"
                                required="" id="">
                            <div class="invalid-feedback">
                                Masukkan Nama Siswa
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" required="" class="form-control" id="">
                                <option value="">- PILIH JENIS KELAMIN -</option>
                                <option value="L">- LAKI - LAKI -</option>
                                <option value="P">- PEREMPUAN -</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilih Jenis Kelamin
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>TTL</label>
                            <input type="text" placeholder="Tempat Tanggal Lahir" class="form-control" name="ttl"
                                required="" id="">
                            <div class="invalid-feedback">
                                Masukkan Tempat Tanggal Lahir
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModal">Update Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" id="formUpdate" method="POST" class="needs-validation" novalidate="">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Sekolah</label>
                            <select name="sekolah_id" id="sekolah_id" class="form-control sekolah" required="">
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
                            <label>Pilih Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-control kelas" required="">
                                <option value="">- PILIH KELAS -</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilih Kelas Dahulu
                            </div>
                        </div>
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" placeholder="Masukkan NIS" class="form-control" name="nis"
                                required="" id="nis">
                            <div class="invalid-feedback">
                                Masukkan NIS Siswa
                            </div>
                        </div>
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" placeholder="Masukkan NISN" class="form-control" name="nip_nik_nisn"
                                required="" id="nip_nik_nisn">
                            <div class="invalid-feedback">
                                Masukkan NISN
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" placeholder="Masukkan Nama Siswa" class="form-control" name="nama"
                                required="" id="nama">
                            <div class="invalid-feedback">
                                Masukkan Nama Siswa
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" required="" class="form-control" id="jenis_kelamin">
                                <option value="">- PILIH JENIS KELAMIN -</option>
                                <option value="L">- LAKI - LAKI -</option>
                                <option value="P">- PEREMPUAN -</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilih Jenis Kelamin
                            </div>
                        </div>
                        <div class="form-group">
                            <label>TTL</label>
                            <input type="text" placeholder="Tempat Tanggal Lahir" class="form-control" name="ttl"
                                required="" id="ttl">
                            <div class="invalid-feedback">
                                Masukkan Tempat Tanggal Lahir
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" placeholder="Masukkan Password" class="form-control" name="password"
                                required="" id="password">
                            <div class="invalid-feedback">
                                Masukkan Password
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
                    "url": "{{ url('admin/master-data/siswa/all') }}",
                    "type": "GET",
                    "data": {
                        'id': "{{ request()->get('k') }}"
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
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'password_view',
                        name: 'password_view'
                    },
                    {
                        data: 'tingkat_kelas',
                        name: 'tingkat_kelas'
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
            $('#formSimpan').submit(function(e) {
                e.preventDefault()
                $.ajax({
                    data: $(this).serialize(),
                    type: 'POST',
                    url: "{{ url('admin/master-data/siswa') }}",
                    beforeSend: function() {
                        $.LoadingOverlay("show", {
                            image: "",
                            fontawesome: "fa fa-cog fa-spin"
                        });
                    },
                    complete: function() {
                        $.LoadingOverlay("hide", {
                            image: "",
                            fontawesome: "fa fa-cog fa-spin"
                        });
                    },
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
            });
            $('#formUpdate').submit(function(e) {
                e.preventDefault()
                $.ajax({
                    data: $(this).serialize(),
                    type: 'PUT',
                    url: "{{ url('admin/master-data/siswa') }}",
                    beforeSend: function() {
                        $.LoadingOverlay("show", {
                            image: "",
                            fontawesome: "fa fa-cog fa-spin"
                        });
                    },
                    complete: function() {
                        $.LoadingOverlay("hide", {
                            image: "",
                            fontawesome: "fa fa-cog fa-spin"
                        });
                    },
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
            });
            
            $('.table').on('click', '.edit[data-id]', function(e) {
                e.preventDefault();
                $.ajax({
                    data: {
                        'id': $(this).data('id'),
                        '_token': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ url('admin/master-data/siswa/get') }}",
                    success: function(data) {
                        $('#id').val(data.id);
                        $('#sekolah_id').val(data.sekolah_id);

                        $('#nip_nik_nisn').val(data.nip_nik_nisn);
                        $('#nis').val(data.nis);
                        $('#nama').val(data.nama);
                        $('#jenis_kelamin').val(data.jenis_kelamin);
                        $('#ttl').val(data.ttl);
                        $('#password').val(data.password_view);
                        $('#kelas_id').val(data.kelas_id);

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
                        title: "Hapus Siswa ?",
                        text: "Data Siswa ini akan dihapus",
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
                                url: "{{ url('admin/master-data/siswa') }}",
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
