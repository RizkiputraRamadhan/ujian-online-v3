@extends('master')
@section('title', 'Setting Jadwal - ')
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

                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header" role="button" data-toggle="collapse"
                            data-target="#panel-detail-mapel">
                            <h4>Lihat Detail Mapel</h4>
                        </div>
                        <div class="accordion-body collapse bg-white" id="panel-detail-mapel" data-parent="#accordion">
                            <div class="mb-3 mt-3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Sekolah</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            value=" {{ $mapel?->nama_sekolah }} ( T.A {{ $mapel?->tahun }} ) (SEMESTER {{ $mapel?->semester }})"
                                            name="" id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Mapel</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $mapel?->nama_mapel }}" name=""
                                            id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Guru</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $mapel?->nama_guru }}" name="" id=""
                                            class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kelas</label>
                                    <div class="col-sm-9">
                                        <select name="" disabled multiple="multiple"
                                            class="form-control bg-white" data-height="100%" required="">
                                            @foreach ($kelas as $k)
                                                <option
                                                    {{ \App\Models\MapelKelas::validate($mapel?->id, $k->id) != null ? 'selected' : '' }}
                                                    value="{{ $k->id }}">- KELAS {{ $k->tingkat_kelas }} (
                                                    {{ $k->urusan_kelas }} ) ( {{ $k->jurusan }} )</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Acak Soal</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            value="{{ $mapel?->acak_soal == 'Y' ? 'SOAL ACAK' : 'TIDAK ACAK' }}"
                                            name="" id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">KKM</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $mapel?->kkm }}" name="" id=""
                                            class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label">Jumlah Soal</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $mapel?->jumlah_soal }}" name=""
                                            id="" class="form-control bg-white" readonly>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>
                            <i class="fa-solid fa-calendar-days far"></i>  Jadwal Ujian Mapel {{ $mapel?->nama_mapel }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Mulai / Selesai</th>
                                    <th>Lama Ujian</th>
                                    <th>Pengawas</th>
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
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModal">Update Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="needs-validation" id="formSimpan">
                    @csrf
                    <input type="hidden" name="mapel_id" value="{{ $mapel?->id }}">
                    <input type="hidden" name="kelas_id" id="kelas_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" class="form-control bg-white" id="kelas_name" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" placeholder="Tanggal Ujian" class="form-control" name="tanggal"
                                required="" id="tanggal">
                            <div class="invalid-feedback">
                                Masukkan Tanggal Ujian
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jam Mulai</label>
                            <input type="time" placeholder="Jam Mulai" class="form-control" name="jam_mulai"
                                required="" id="jam_mulai">
                            <div class="invalid-feedback">
                                Masukkan Jam Mulai
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jam Selesai</label>
                            <input type="time" placeholder="Jam Selesai" class="form-control" name="jam_selesai"
                                required="" id="jam_selesai">
                            <div class="invalid-feedback">
                                Masukkan Jam Selesai
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Durasi Ujian</label>
                            <input type="text" readonly placeholder="Durasi Ujian (Menit) " class="form-control bg-white" name="durasi"
                                required="" id="durasi">
                            <div class="invalid-feedback">
                                Durasi Ujian
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>Pilih Pengawas</label>
                            <select name="guru_id" required="" class="form-control select2" id="guru_id">
                                <option value="">- PILIH GURU PENGAWAS -</option>
                                @foreach ($guru as $g)
                                    <option value="{{ $g->id }}">- {{ strtoupper($g->nama) }} -</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Masukkan Jam Selesai
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
        $(document).ready(function() {
            $(".select2").select2({
                dropdownParent: $("#updateModal"),
                tags: true,
            });
            $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/monitoring/jadwal/setting/detail') }}",
                    "type": "GET",
                    "data": {
                        'mapel_id': "{{ request()->segment(5) }}",
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas'
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
                        data: 'lama_ujian',
                        name: 'lama_ujian'
                    },
                    {
                        data: 'pengawas',
                        name: 'pengawas'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });
            $('.table').on('click', '.edit[data-mapel_id]', function(e) {
                e.preventDefault();
                $('#kelas_name').val($(this).data('kelas_name'));
                $('#kelas_id').val($(this).data('kelas_id'));
                $.ajax({
                    data: {
                        'mapel_id': $(this).data('mapel_id'),
                        'kelas_id': $(this).data('kelas_id'),
                        '_token': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ url('admin/monitoring/jadwal/setting/detail') }}",
                    success: function(data) {
                        if (data.data != null) {
                            $('#tanggal').val(data.data.tanggal);
                            $('#jam_mulai').val(data.data.jam_mulai);
                            $('#jam_selesai').val(data.data.jam_selesai);
                            $('#guru_id').val(data.data.guru_id);
                            generate(data.data.jam_mulai, data.data.jam_selesai);
                        }else{
                            $('#durasi').val('');
                            $('#tanggal').val('');
                            $('#jam_mulai').val('');
                            $('#jam_selesai').val('');
                            $('#guru_id').val('');
                        }

                        $('#updateModal').modal('show');
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
                    url: "{{ url('admin/monitoring/jadwal/setting') }}",
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
                        swal(err.responseJSON.message);
                    }
                });
            });
        });
    </script>
    <script>
        $('#jam_selesai').on('change', function(e){
            e.preventDefault();
            var jam_mulai = $('#jam_mulai').val();
            var jam_selesai = $('#jam_selesai').val();
            console.log(jam_mulai);
            generate(jam_mulai, jam_selesai);
        });
    </script>
    <script>
        function generate(jam_mulai, jam_selesai){
            if(jam_mulai.length === 0 || jam_selesai.length === 0){
                swal('Pilih jam mulai & jam selesai dahulu yha ...');
            }else{
                var jam_mulai_hours = jam_mulai.split(":")[0];
                var jam_mulai_minute = jam_mulai.split(":")[1];
                var jam_selesai_hours = jam_selesai.split(":")[0];
                var jam_selesai_minute = jam_selesai.split(":")[1];

                var jam = jam_selesai_hours - jam_mulai_hours;
                var menit = jam_selesai_minute - jam_mulai_minute;

                if (jam < 0){
                    jam = jam * -1;
                }else if(menit < 0){
                    menit = menit * -1;
                }
                var res = (jam * 60) + menit;
                if(res <=0 ){
                    swal('Jam masuk dan jam selesai tidak valid');
                }else{
                    $('#durasi').val(res+" Menit")
                }
            }
        }
    </script>
@endsection
