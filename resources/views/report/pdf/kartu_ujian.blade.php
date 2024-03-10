<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('dist/bootstrap/bootstrap.min.css') }}">
    <link href="{{ asset('assets/img/kemenag.png') }}" rel="icon">
    <title>Kartu Ujian - Dicetak Pada {{ date('Y-m-d') }}</title>
    <style>
        @media print {
            .pagebreak {
                page-break-before: always;
            }

            /* page-break-after works, as well */
        }
    </style>
</head>

<body>
    @if(count($siswa) == null)
        <p>Data siswa tidak ditemukan</p>
    @else
    @php $j=1; @endphp
    @for($i=0; $i<count($siswa); $i++)
        <div class="row ml-3 mr-3 mt-3 {{($j % 3 == 0) ? "pagebreak" : ""}}">
            <div class="col-6 border border-dark">
                <br>
                <table width="100%">
                    <td width="100px" align="left">
                        <img src="{{ asset('assets/logo/' . $kop?->logo_kiri) }}" alt="" height="50px">
                    </td>
                    <td align="top">
                        <h6 align="center" style="margin-right:35px; margin-top:2px; font-size:15px"><b>KARTU UJIAN
                                SISWA</b></h6>
                        <h6 align="center" style="margin-right:35px; margin-top:-2px; font-size:15px">
                            <b>{{ $kop?->nama }}</b></h6>
                        <h6 align="center" style="margin-right:35px; margin-top:-2px; font-size:15px"><b>TAHUN AJARAN
                                {{ $kop?->tahun }}</b></h6>
                    </td>
                    @if ($kop?->logo_kanan != null)
                        <td width="100px" align="right">
                            <img src="{{ asset('assets/logo/' . $kop?->logo_kanan) }}" alt="" height="50px">
                        </td>
                    @endif
                </table>
                <hr>
                <font size="2">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="200px"><b>NIS</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i]['nis'] }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>NISN</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i]['nip_nik_nisn'] }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Nama Siswa</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i]['nama'] }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Jenis Kelamin</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i]['jenis_kelamin'] == 'L' ? 'LAKI - LAKI' : 'PEREMPUAN' }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Tempat, Tanggal Lahir</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i]['ttl'] }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Kelas</b></td>
                                <td width="10px">:</td>
                                <td>{{ $kelas?->tingkat_kelas . ' (' . $kelas?->urusan_kelas . ') JURUSAN ' . $kelas?->jurusan }}
                                </td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Username</b></td>
                                <td width="10px">:</td>
                                <td><b>{{ @$siswa[$i]['nip_nik_nisn'] }}</b></td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Password</b></td>
                                <td width="10px">:</td>
                                <td><b>{{ @$siswa[$i]['password_view'] }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="90%">
                        <tbody>
                            <td align="right"></td>
                            <td align="right">
                                Kepala Madrasah
                                <br><br><br><br>

                                <b>{{ $kop?->nama_kamad }}</b> <br>
                                @if ($kop?->nip_kamad != null)
                                    <b>NIP. {{ $kop?->nip_kamad }}</b> <br>
                                @endif
                            </td>
                        </tbody>
                    </table>
                </font>
                <br>
            </div>
            @if(@$siswa[$i+1]['nip_nik_nisn'] != null)
            <div class="col-6 border border-dark border-left-0">
                <br>
                <table width="100%">
                    <td width="100px" align="left">
                        <img src="{{ asset('assets/logo/' . $kop?->logo_kiri) }}" alt="" height="50px">
                    </td>
                    <td align="top">
                        <h6 align="center" style="margin-right:35px; margin-top:2px; font-size:15px"><b>KARTU UJIAN
                                SISWA</b></h6>
                        <h6 align="center" style="margin-right:35px; margin-top:-2px; font-size:15px">
                            <b>{{ $kop?->nama }}</b></h6>
                        <h6 align="center" style="margin-right:35px; margin-top:-2px; font-size:15px"><b>TAHUN AJARAN
                                {{ $kop?->tahun }}</b></h6>
                    </td>
                    @if ($kop?->logo_kanan != null)
                        <td width="100px" align="right">
                            <img src="{{ asset('assets/logo/' . $kop?->logo_kanan) }}" alt="" height="50px">
                        </td>
                    @endif
                </table>
                <hr>
                <font size="2">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="200px"><b>NIS</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i+1]['nis'] }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>NISN</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i+1]['nip_nik_nisn'] }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Nama Siswa</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i+1]['nama'] }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Jenis Kelamin</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i+1]['jenis_kelamin'] == 'L' ? 'LAKI - LAKI' : 'PEREMPUAN' }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Tempat, Tanggal Lahir</b></td>
                                <td width="10px">:</td>
                                <td>{{ @$siswa[$i+1]['ttl'] }}</td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Kelas</b></td>
                                <td width="10px">:</td>
                                <td>{{ $kelas?->tingkat_kelas . ' (' . $kelas?->urusan_kelas . ') JURUSAN ' . $kelas?->jurusan }}
                                </td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Username</b></td>
                                <td width="10px">:</td>
                                <td><b>{{ @$siswa[$i+1]['nip_nik_nisn'] }}</b></td>
                            </tr>
                            <tr>
                                <td width="200px"><b>Password</b></td>
                                <td width="10px">:</td>
                                <td><b>{{ @$siswa[$i+1]['password_view'] }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="90%">
                        <tbody>
                            <td align="right"></td>
                            <td align="right">
                                Kepala Madrasah
                                <br><br><br><br>

                                <b>{{ $kop?->nama_kamad }}</b> <br>
                                @if ($kop?->nip_kamad != null)
                                    <b>NIP. {{ $kop?->nip_kamad }}</b> <br>
                                @endif
                            </td>
                        </tbody>
                    </table>
                </font>
                <br>
            </div>
            @php $i++; @endphp
            @endif
        </div>
        @php $j++; @endphp
    @endfor
    @endif

    <script>
        window.print();
    </script>
</body>

</html>
