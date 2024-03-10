@extends('siswa.master')
@section('title', 'Profile Saya - ')
@section('content')
    <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{url('siswa')}}" class="nav-link"><i class="fa-solid fa-globe"></i><span>Jadwal Ujian</span></a>
                </li>
                <li class="nav-item active">
                    <a href="{{url('siswa/profile')}}" class="nav-link"><i class="fa-solid fa-user"></i><span>Profil Saya</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profil Saya</h1>
            </div>  
            <div class="section-body" style="margin-top: -10px;">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Diri Saya</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" value="{{$siswa?->nip_nik_nisn}}" name="" id="" readonly class="form-control bg-white">
                        </div>
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" value="{{$siswa?->nis}}" name="" id="" readonly class="form-control bg-white">
                        </div>
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" value="{{$siswa?->nama}}" name="" id="" readonly class="form-control bg-white">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <input type="text" value="{{($siswa?->jenis_kelamin == "L") ? "LAKI - LAKI" : "PEREMPUAN"}}" name="" id="" readonly class="form-control bg-white">
                        </div>
                        <div class="form-group">
                            <label>TTL</label>
                            <input type="text" value="{{$siswa?->ttl}}" name="" id="" readonly class="form-control bg-white">
                        </div>
                        <div class="form-group">
                            <label>Sekolah</label>
                            <input type="text" value="{{$sekolah?->nama}}" name="" id="" readonly class="form-control bg-white">
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" value="KELAS {{ $kelas?->tingkat_kelas }} ( {{ $kelas?->urusan_kelas }} ) ( {{ $kelas?->jurusan }} )" name="" id="" readonly class="form-control bg-white">
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <i>Jika data diatas tidak sesuai segera hubungi petugas</i>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
