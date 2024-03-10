@extends('report.kop')
@section('title', 'Berita Acara Ujian - ')
@section('content')
<hr style="margin-top: -5px"><br>
<h1 class="text-center">Berita Acara</h1>
<br><br>
<p class="ml-3 mr-3 text-lg">
    Pada hari ini @if($jadwal_kelas_mapel != null) {{Illuminate\Support\Carbon::createFromFormat('Y-m-d', $jadwal_kelas_mapel?->tanggal)->isoFormat('D MMMM Y')}} @endif , di {{strtoupper($kop?->nama)}}
    telah diselenggarakan UJIAN MADRASAH TINGKAT {{$kop?->level}} , dari pukul {{$jadwal_kelas_mapel?->jam_mulai}}
    sampai dengan pukul {{$jadwal_kelas_mapel?->jam_selesai}}
</p>
<div class="ml-3 mr-3">
    <table width="100%" class="mb-3 mt-3">
        <tbody>
            <tr>
                <td width="300px"><b>Nama Madrasah</b></td>
                <td width="10px">:</td>
                <td>{{strtoupper($kop?->nama)}}</td>
            </tr>
            <tr>
                <td width="300px"><b>Kelas</b></td>
                <td width="10px">:</td>
                <td>{{"Kelas ".$jadwal_kelas_mapel?->tingkat_kelas." (".$jadwal_kelas_mapel?->urusan_kelas.") JURUSAN ".$jadwal_kelas_mapel?->jurusan}}</td>
            </tr>
            <tr>
                <td width="300px"><b>Jumlah Peserta Seharusnya</b></td>
                <td width="10px">:</td>
                <td>{{count($siswa)}}</td>
            </tr>
            <tr>
                <td width="300px"><b>Jumlah Hadir</b></td>
                <td width="10px">:</td>
                <td>{{count($siswa_hadir)}}</td>
            </tr>
            <tr>
                <td width="300px"><b>Jumlah Tidak Hadir</b></td>
                <td width="10px">:</td>
                <td>{{count($siswa_tidak_hadir)}}</td>
            </tr>
            <tr>
                <td width="300px"><b>Mata Pelajaran</b></td>
                <td width="10px">:</td>
                <td>{{$jadwal_kelas_mapel?->nama_mapel}}</td>
            </tr>
        </tbody>
    </table>
    <div class="mt-4">
        <b>Catatan Selama Tes</b>
        <div class="card border-black mt-3" style="height:200px;">
            <div class="card-body">
            </div>
        </div>
    </div>
    <div class="mt-5">
        <div class="row">
            <div class="col-7">
                <b>Yang membuat berita acara</b>
            </div>
            <div class="col-5">
                <b>TTD</b>
            </div>
        </div>
        <table width="100%" class="mb-3 mt-5">
            <tbody>
                <tr>
                    <td width="20px"><b>1.</b></td>
                    <td width="300px"><b>Proktor</b></td>
                    <td>{{strtoupper($kop?->nama_proktor)}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20px"></td>
                    <td width="300px"><b>NIP</b></td>
                    <td>{{($kop?->nip_proktor == null) ? "-" : strtoupper($kop?->nip_proktor)}}</td>
                    <td>____________________________________</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="20px"><b>2.</b></td>
                    <td width="300px"><b>Pengawas</b></td>
                    <td>{{strtoupper($jadwal_kelas_mapel?->pengawas)}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20px"></td>
                    <td width="300px"><b>NIP</b></td>
                    <td>{{strtoupper($jadwal_kelas_mapel?->nip_nik_nisn)}}</td>
                    <td>____________________________________</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="20px"><b>3.</b></td>
                    <td width="300px"><b>Kepala Madrasah</b></td>
                    <td>{{strtoupper($kop?->nama_kamad)}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td width="20px"></td>
                    <td width="300px"><b>NIP</b></td>
                    <td>{{($kop?->nip_kamad == null) ? "-" : strtoupper($kop?->nip_kamad)}}</td>
                    <td>____________________________________</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@endsection