@extends('master')
@section('title', 'Hasil Ujian Siswa - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="alert alert-light alert-has-icon">
                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                    <div class="alert-body">
                        <div class="alert-title">Petunjuk</div>
                        1. Jika status kehadiran <b>BELUM DIMULAI</b> maka ujian memang belum dimulai dan status kehadiran belum diatur pengawas<br>
                        2. Jika baris berwarna merah berarti siswa <b>DIBLOKIR</b> dikarenakan diblokir oleh admin atau melakukan kecurangan<br>
                        3. Siswa yang nilainya <b>DIBAWAH KKM</b> dinyatakan <b>MENGULANG</b>
                    </div>
                </div>

                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header" role="button" data-toggle="collapse"
                            data-target="#panel-detail-mapel">
                            <h4>Lihat Detail Jadwal Ujian</h4>
                        </div>
                        <div class="accordion-body collapse bg-white" id="panel-detail-mapel" data-parent="#accordion">
                            <div class="mb-3 mt-3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Tahun Ajaran</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $jadwal?->tahun }}" name="" id=""
                                            class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Mapel</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $jadwal?->nama_mapel }}" name=""
                                            id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Tanggal Ujian</label>
                                    <div class="col-sm-9">
                                        @if($jadwal != null)
                                        <input type="text"
                                            value="{{ Illuminate\Support\Carbon::createFromFormat('Y-m-d', $jadwal?->tanggal)->isoFormat('D MMMM Y') }}"
                                            name="" id="" class="form-control bg-white" readonly>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Mulai / Selesai</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            value="{{ $jadwal?->jam_mulai . ' - ' . $jadwal?->jam_selesai }}" name=""
                                            id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Pengawas</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $jadwal?->pengawas }}" name="" id=""
                                            class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kelas</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            value="KELAS {{ $jadwal?->tingkat_kelas }} ( {{ $jadwal?->urusan_kelas }} ) ( {{ $jadwal?->jurusan }} )"
                                            name="" id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">KKM</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            value="{{$jadwal?->kkm}}"
                                            name="" id="" class="form-control bg-white" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Hasil Peserta Ujian</h4>
                    </div>
                        <div class="card-body">
                            <div class="overflow-auto">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NISN</th>
                                            <th>Nama Siswa</th>
                                            <th>Status Kehadiran</th>
                                            <th>Nilai</th>
                                            <th>Keterangan</th>
                                            <th width="10px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
                                        @foreach ($siswa as $s)
                                            @php $detail = \App\Models\Kehadiran::get(request()->segment(5), $s->id); @endphp
                                            @php $nilai = \App\Models\BankJawaban::getNilai($detail?->id, $jadwal?->mapel_id, $s->id); @endphp
                                            <tr class="{{ $detail?->status_blokir == 'Y' ? 'text-danger' : '' }}">
                                                <td>
                                                    {{$i++}}
                                                </td>
                                                <td>{{ $s->nip_nik_nisn }}</td>
                                                <td>{{ $s->nama }}</td>
                                                <td>{{ $detail == null ? 'BELUM DIATUR' : $detail?->status_kehadiran }}
                                                </td>
                                                <td>
                                                    {{$nilai}}
                                                </td>
                                                <td>
                                                    {{($nilai < $jadwal?->kkm) ? "MENGULANG" : "LULUS"}}
                                                </td>
                                                <td>
                                                    @if ($detail == null)
                                                        -
                                                    @else
                                                        <a target="_blank"  href="{{url('guru/nilai/preview/ujian/'.request()->segment(5).'/'.$detail?->no_peserta.'/'.request()->session()->get('sekolah_id').'/'.$detail?->id)}}" type="button" class="btn btn-primary btn-sm">
                                                            Detail
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </section>
    </div>
@endsection
