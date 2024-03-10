<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('dist/bootstrap/bootstrap.min.css') }}">
    {{-- Favicon --}}
    <link href="{{ asset('assets/img/kemenag.png') }}" rel="icon">
    <title>@yield('title') Dicetak Pada {{ date('Y-m-d') }}</title>
</head>

<body>
    <table width="100%">
        <td width="100px" align="left">
            <img src="{{ asset('assets/logo/' . $kop?->logo_kiri) }}" alt="" height="100px">
        </td>
        <td align="top">
            <h3 align="center" style="margin-right:40px;"><b>{{ $kop?->instansi }}</b></h3>
            <h3 align="center" style="margin-right:40px;"><b>{{ $kop?->sub_instansi }}</b></h3>
            <h5 align="center" style="margin-right:40px;"><b>{{ $kop?->nama }}</b></h5>
            <p align="center" style="margin-right:40px;font-size:16px">
                {{ $kop?->alamat }}<br>
                Telp. {{ $kop?->no_telp }}, Email. <a href="mailto:{{ $kop?->email }}">{{ $kop?->email }}</a>
            </p>
        </td>
        @if ($kop?->logo_kanan != null)
            <td width="100px" align="right">
                <img src="{{ asset('assets/logo/' . $kop?->logo_kanan) }}" alt="" height="100px">
            </td>
        @endif
    </table>
    @yield('content')
</body>
<script>
    window.print();
</script>

</html>
