@extends('master')
@section('title', 'Data Kelas - ')
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
                        <h4><i class="fa-solid fa-chalkboard-user far"></i> Data Kelas Berdasarkan Sekolah</h4>
                        <div class="card-header-form">
                            <a href="#" data-toggle="modal" data-target="#addModal" type="button"
                                class="btn btn-primary btn-sm">Tambah</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <form action="{{ url('admin/master-data/kelas') }}" method="GET"
                                style="margin-top:-10px; margin-left:-23px;">
                                <div class="form-group mb-3 mt-0">
                                    <select name="s" onchange='if(this.value != "") { this.form.submit(); }'
                                        class="form-control" required="">
                                        <option value="">- PILIH SEKOLAH DAHULU -</option>
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
                                        <th>Tingkat Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Urusan Kelas</th>
                                        <th>Level</th>
                                        <th>Sekolah</th>
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
                    <h5 class="modal-title" id="addModal">Tambah Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/master-data/kelas') }}" method="POST" class="needs-validation" novalidate="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Sekolah</label>
                            <select name="sekolah_id" class="form-control sekolah" required="">
                                <option value="">- PILIH SEKOLAH -</option>
                                @foreach ($sekolah as $s)
                                    <option data-level_sekolah="{{ $s->level }}" value="{{ $s->id }}">-
                                        {{ strtoupper($s->nama) }} -</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih Sekolah Dulu
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tingkat Kelas</label>
                            <select name="tingkat_kelas" class="form-control" required="">
                                <option value="">- PILIH TINGKAT KELAS -</option>
                                @foreach ($tingkat_kelas as $t)
                                    <option value="{{ $t }}">- {{ strtoupper($t) }} -</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih Jurusan
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pilih Jurusan</label>
                            <select name="jurusan" class="form-control" required="">
                                <option value="">- PILIH JURUSAN -</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j }}">- {{ strtoupper($j) }} -</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih Jurusan
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>Urusan Kelas</label>
                            <select name="urusan_kelas" class="form-control urusan_kelas" required="">
                                <option value="">- PILIH URUSAN KELAS -</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilih Urusan Kelas Dahulu
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
                    <h5 class="modal-title" id="updateModal">Update Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/master-data/kelas/update') }}" method="POST" class="needs-validation"
                    novalidate="">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Sekolah</label>
                            <select name="sekolah_id" id="sekolah_id" class="form-control sekolah" required="">
                                <option value="">- PILIH SEKOLAH -</option>
                                @foreach ($sekolah as $s)
                                    <option data-level_sekolah="{{ $s->level }}" value="{{ $s->id }}">-
                                        {{ strtoupper($s->nama) }} -</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih Sekolah Dulu
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tingkat Kelas</label>
                            <select name="tingkat_kelas" id="tingkat_kelas" class="form-control" required="">
                                <option value="">- PILIH TINGKAT KELAS -</option>
                                @foreach ($tingkat_kelas as $t)
                                    <option value="{{ $t }}">- {{ strtoupper($t) }} -</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih Jurusan
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pilih Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-control" required="">
                                <option value="">- PILIH JURUSAN -</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j }}">- {{ strtoupper($j) }} -</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih Jurusan
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>Urusan Kelas</label>
                            <select name="urusan_kelas" id="urusan_kelas" class="form-control urusan_kelas"
                                required="">
                                <option value="">- PILIH URUSAN KELAS -</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilih Urusan Kelas Dahulu
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
            $('.sekolah').on('change', function() {
                $('.urusan_kelas').find('option').remove().end().append(
                    '<option value="">- PILIH URUSAN KELAS -</option>').val('');
                if ($(this).find(':selected').data('level_sekolah') == "MI") {
                    const alphabet = [...'ABCDEFGHIJKLMNOPQRSTUVWXYZ'];
                    $.each(alphabet, function(i, item) {
                        $('.urusan_kelas').append($('<option>', {
                            value: item,
                            text: '- ' + item + ' -'
                        }));
                    });
                } else {
                    for (var i = 1; i <= 20; i++) {
                        $('.urusan_kelas').append($('<option>', {
                            value: i,
                            text: '- ' + i + ' -'
                        }));
                    }
                }
            });
            $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/master-data/kelas/all') }}",
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
                        data: 'tingkat_kelas',
                        name: 'tingkat_kelas'
                    },
                    {
                        data: 'jurusan',
                        name: 'jurusan'
                    },
                    {
                        data: 'urusan_kelas',
                        name: 'urusan_kelas'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
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
                    url: "{{ url('admin/master-data/kelas/get') }}",
                    success: function(data) {
                        $('#id').val(data.id);
                        $('#sekolah_id').val(data.sekolah_id);
                        $('#tingkat_kelas').val(data.tingkat_kelas);
                        $('#jurusan').val(data.jurusan);

                        if ($('#sekolah_id').find(':selected').data('level_sekolah') == "MI") {
                            const alphabet = [...'ABCDEFGHIJKLMNOPQRSTUVWXYZ'];
                            $.each(alphabet, function(i, item) {
                                $('.urusan_kelas').append($('<option>', {
                                    value: item,
                                    text: '- ' + item + ' -'
                                }));
                            });
                        } else {
                            for (var i = 1; i <= 20; i++) {
                                $('.urusan_kelas').append($('<option>', {
                                    value: i,
                                    text: '- ' + i + ' -'
                                }));
                            }
                        }
                        $('#urusan_kelas').val(data.urusan_kelas);

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
                        title: "Hapus Kelas ?",
                        text: "Kelas akan dihapus, dan mungkin akan berpengaruh pada data ujian pada kelas ini",
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
                                url: "{{ url('admin/master-data/kelas') }}",
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
