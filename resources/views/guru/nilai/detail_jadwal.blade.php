@extends('master')
@section('title', 'Jadwal Ujian Mapel - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
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
                                        <small class="form-text" style="margin-bottom: -10px">
                                            Menampilkan data sekolah, tahun ajaran, dan semester ketika mapel dibuat
                                        </small>
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
                            Jadwal Ujian Mapel {{ $mapel?->nama_mapel }}
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
                                    <th>Status Ujian</th>
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
        $(document).ready(function() {
            $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('guru/nilai/jadwal/get') }}",
                    "type": "GET",
                    "data": {
                        'mapel_id': "{{ request()->segment(4) }}",
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
                        data: 'status_jadwal',
                        name: 'status_jadwal'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });
        });
    </script>
@endsection
