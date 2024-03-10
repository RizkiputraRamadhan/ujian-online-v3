<!DOCTYPE html>
<html lang="en" class="notranslate">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta translate="no">
    <title>@yield('title') Aplikasi Ujian Online Berbasis WEB</title>
    {{-- Assets File --}}
    <link href="{{ asset('assets/img/kemenag.png') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('dist/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mix/app.css') }}">
    <script src="{{ asset('assets/mix/app.js') }}"></script>
    {{-- End Assets File --}}
</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            @include('layout.nav_siswa')
            @yield('content')
            @include('layout.footer')
        </div>
    </div>
</body>

</html>
