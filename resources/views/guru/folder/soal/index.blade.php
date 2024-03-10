@extends('master')
@section('title', 'Data Mapel - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fa-regular fa-folder-open" style="color: #cfbe03; font-size: 25px;" ></i> Folder {{ $folder->nama }}</h1>
            </div>

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
                        <h4>Data Folder Bank Soal {{ $folder->nama }}</h4>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Jenis Soal</th>
                                    <th>Jumlah Soal</th>
                                    <th width="10px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Pilihan Ganda</td>
                                        <td>{{ $count1 }}</td>
                                        <td>
                                            <div class="dropdown d-inline dropleft mb-2" style="float: right;">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item " href="/guru/folder/soal/{{ $folder->id }}/1">Buat Soal</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Pilihan Ganda Komplex</td>
                                        <td>{{ $count2 }}</td>
                                        <td>
                                            <div class="dropdown d-inline dropleft mb-2" style="float: right;">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item " href="/guru/folder/soal/{{ $folder->id }}/2">Buat Soal</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Soal Essay / Jawaban Singkat</td>
                                        <td>{{ $count3 }}</td>
                                        <td>
                                            <div class="dropdown d-inline dropleft mb-2" style="float: right;">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item " href="/guru/folder/soal/{{ $folder->id }}/3">Buat Soal</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Soal True and False</td>
                                        <td>{{ $count4 }}</td>
                                        <td>
                                            <div class="dropdown d-inline dropleft mb-2" style="float: right;">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item " href="/guru/folder/soal/{{ $folder->id }}/4">Buat Soal</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Soal Mencocokan / Menjodohkan</td>
                                        <td>{{ $count5 }}</td>
                                        <td>
                                            <div class="dropdown d-inline dropleft mb-2" style="float: right;">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item " href="/guru/folder/soal/{{ $folder->id }}/5">Buat Soal</a></li>

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@endsection
