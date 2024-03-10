@extends('master')
@section('title', 'Data Mapel - ')
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
                        <h4><i class="fa-regular fa-folder-open" style="color: #cfbe03; font-size: 20px;" ></i> Data Folder Bank Soal</h4>
                        <button class="w-4 btn btn-primary tombolAdd">Buat Folder</button>
                    </div>
                    <div class="p-2">
                        <div class="shadow p-3 mb-5 bg-body-tertiary rounded mt-2 modalFolderAdd" id="modalFolderAdd"
                            style="display: none;">
                            <h6>Buat Folder Bank Soal Baru</h6>
                            <hr>
                            <form action="" method="post">
                                @csrf
                                <div class="content-container">
                                    <div class="mb-3 mt-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama Folder</label>
                                            <div class="col-sm-9">
                                                <input type="text" value="" name="nama" id=""
                                                    class="form-control bg-white">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Mapel</label>
                                            <div class="col-sm-9">
                                                <input type="text" value="" name="mapel" id=""
                                                    class="form-control bg-white">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Pilih Kelas</label>
                                            <div class="col-sm-9">
                                                <div id="kelasPilihan"></div>
                                                <div class="scrollable-div" style="max-height: 200px; overflow-y: auto;">
                                                    @foreach ($kelas as $i => $row)
                                                        <div class="p-1">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="kelas_id[]" id="kelas_{{ $i }}"
                                                                    value="{{ $row->id }}">
                                                                <label for="kelas_{{ $i }}"
                                                                    class="custom-control-label" for="customCheck1">Kelas
                                                                    {{ $row->tingkat_kelas }} ({{ $row->jurusan }})</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="invalid-feedback">
                                                    Pilih kelas untuk folder ini
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Ketentuan</label>
                                            <div class="col-sm-9">
                                                <textarea name="ket" id="" class="form-control bg-white summernote" cols="30" rows="20"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        class="w-4 btn btn-primary d-flex justify-content-end align-content-end ml-auto">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Nama Folder</th>
                                    <th>Mapel</th>
                                    <th>Kelas</th>
                                    <th>Jumlah Soal</th>
                                    <th width="10px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($folder as $index => $fbs)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $fbs->nama }}</td>
                                        <td>{{ $fbs->nama_mapel }}</td>
                                        <td>
                                            @foreach (json_decode($fbs->nama_kelas) as $i => $klsId)
                                                @foreach ($kelas as $row)
                                                    @if ($row->id == $klsId)
                                                        Kelas {{ $row->tingkat_kelas }} ({{ $row->jurusan }}),
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </td>
                                        <td>
                                            @php
                                                $count1 = \App\Models\Soal::where('jenis_soal', 1)->where('folder_bs', $fbs->id)->count();
                                                $count2 = \App\Models\Soal::where('jenis_soal', 2)->where('folder_bs', $fbs->id)->count();
                                                $count3 = \App\Models\Soal::where('jenis_soal', 3)->where('folder_bs', $fbs->id)->count();
                                                $count4 = \App\Models\Soal::where('jenis_soal', 4)->where('folder_bs', $fbs->id)->count();
                                                $count5 = \App\Models\Soal::where('jenis_soal', 5)->where('folder_bs', $fbs->id)->count();
                                                $jml = $count1 + $count2 + $count3 + $count4 + $count5;
                                            @endphp
                                            {{ $jml }}
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline dropleft mb-2" style="float: right;">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item "
                                                            href="folder/edit/{{ $fbs->id }}">edit</a></li>
                                                    <li><a class="dropdown-item hapusFolder" href="">hapus</a></li>
                                                    <li><a class="dropdown-item " href="folder/soal/{{ $fbs->id }}"><span class="btn btn-primary btn-sm">Buat Soal</span> </a></li>
                                                </ul>
                                                <form action="folder/delete/{{ $fbs->id }}" method="post"
                                                    class="d-none">@csrf<button id="formDelete">formDelete</button></form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @elseif (session('gagal'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('gagal') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
        $(document).ready(function() {
            $(".tombolAdd").click(function() {
                $("#modalFolderAdd").toggle();
            });
            $('.summernote').summernote();

            $('.hapusFolder').click(function(e) {
                e.preventDefault();
                var deleteLink = document.getElementById('formDelete');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteLink.click();
                    }
                });
            });
        });
    </script>
@endsection
