@extends('report.kop')
@section('title', 'Nilai Ujian - ')
@section('content')
<hr style="margin-top: -5px"><br>
<h3 class="text-center">Rekap Nilai Ujian</h3>
<br><br>
<div class="ml-3 mr-3">
    <table width="100%" class="mb-3 mt-2">
        <tbody>
            <tr>
                <td width="300px"><b>Hari/Tanggal</b></td>
                <td width="10px">:</td>
                <td> @if($jadwal_kelas_mapel != null) {{Illuminate\Support\Carbon::createFromFormat('Y-m-d', $jadwal_kelas_mapel?->tanggal)->isoFormat('dddd, D MMMM Y')}} @endif</td>
            </tr>
            <tr>
                <td width="300px"><b>Mata Pelajaran</b></td>
                <td width="10px">:</td>
                <td>{{strtoupper($jadwal_kelas_mapel?->nama_mapel)}}</td>
            </tr>
            <tr>
                <td width="300px"><b>Kelas</b></td>
                <td width="10px">:</td>
                <td>{{$jadwal_kelas_mapel?->tingkat_kelas." (".$jadwal_kelas_mapel?->urusan_kelas.") JURUSAN ".$jadwal_kelas_mapel?->jurusan}}</td>
            </tr>
            <tr>
                <td width="300px"><b>Jam Mulai s.d Jam Selesai</b></td>
                <td width="10px">:</td>
                <td>{{ $jadwal_kelas_mapel?->jam_mulai . ' - ' . $jadwal_kelas_mapel?->jam_selesai}}</td>
            </tr>
            <tr>
                <td width="300px"><b>Lama Ujian</b></td>
                <td width="10px">:</td>
                <td>{{$jadwal_kelas_mapel?->lama_ujian." Menit"}}</td>
            </tr>
            <tr>
                <td width="300px"><b>KKM</b></td>
                <td width="10px">:</td>
                <td>{{$jadwal_kelas_mapel?->kkm}}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th scope="col" width="10px">NO</th>
                <th scope="col">NIS</th>
                <th scope="col">NISN</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col" class="text-center">Nilai Ujian</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach($siswa as $s)
            @php $detail = \App\Models\Kehadiran::get(request()->segment(3), $s->id); @endphp
            <tr>
                <td>{{$no++}}</td>
                <td>{{$s->nis}}</td>
                <td>{{$s->nip_nik_nisn}}</td>
                <td>{{$s->nama}}</td>
                <td class="text-center">
                    {{\App\Models\BankJawaban::getNilai($detail?->id, request()->segment(6), $s->id)}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection