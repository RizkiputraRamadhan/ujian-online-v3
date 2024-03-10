@extends('report.kop')
@section('title', 'Daftar Tidak Hadir Ujian - ')
@section('content')
<hr style="margin-top: -5px"><br>
<h3 class="text-center">Daftar Tidak Hadir Ujian</h3>
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
        </tbody>
    </table>
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th scope="col" width="10px">NO</th>
                <th scope="col">NIS</th>
                <th scope="col">NISN</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col" width="20px">Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach($siswa as $s)
            @php $detail = \App\Models\Kehadiran::get(request()->segment(3), $s->id); @endphp
            @if($detail?->status_kehadiran != "HADIR")
            <tr>
                <td>{{$no++}}</td>
                <td>{{$s->nis}}</td>
                <td>{{$s->nip_nik_nisn}}</td>
                <td>{{$s->nama}}</td>
                <td class="text-center">
                    {{($detail?->status_kehadiran == "HADIR") ? "H" : "TH"}}
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <br><br>
    <table width="90%">
        <tbody>
            <td align="right"></td>
            <td align="right">
                Pengawas Ujian
                <br><br><br><br>
                
                <b>{{$jadwal_kelas_mapel?->pengawas}}</b> <br>
                <b>NIP. {{$jadwal_kelas_mapel?->nip_nik_nisn}}</b> <br>
            </td>
        </tbody>
    </table>
</div>
@endsection