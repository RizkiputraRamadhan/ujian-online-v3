<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ session()->get('nama') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">System SIMPLS</div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item has-icon edit-profile">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2 ">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="https://i.ibb.co/bbjvh0b/logo-sipenting.png" alt="" width="150"> <a href="#"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">SP</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li {{ $sb == 'Dashboard' ? 'class=active' : '' }}>
                <a class="nav-link" href="{{ url('admin') }}"><i class="fa-solid fa-house-chimney"></i>
                    <span>Beranda</span>
                </a>
            </li>
            <li
                class="nav-item dropdown {{ $sb == 'Tahun Ajaran' || $sb == 'Data Sekolah' || $sb == 'Data Kelas' || $sb == 'Data Guru' || $sb == 'Data Siswa' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-folder-tree"></i>
                    <span>Master Data</span>
                </a>
                <ul class="dropdown-menu">
                    <li {{ $sb == 'Tahun Ajaran' ? 'class=active' : '' }}><a class="nav-link"
                            href="{{ url('admin/master-data/tahun-ajaran') }}">Tahun Ajaran</a></li>
                    <li {{ $sb == 'Data Sekolah' ? 'class=active' : '' }}><a class="nav-link"
                            href="{{ url('admin/master-data/sekolah') }}">Sekolah</a></li>
                    <li {{ $sb == 'Data Kelas' ? 'class=active' : '' }}><a class="nav-link"
                            href="{{ url('admin/master-data/kelas') }}">Kelas</a></li>
                    <li {{ $sb == 'Data Guru' ? 'class=active' : '' }}><a class="nav-link"
                            href="{{ url('admin/master-data/guru') }}">Guru</a></li>
                    <li {{ $sb == 'Data Siswa' ? 'class=active' : '' }}><a class="nav-link"
                            href="{{ url('admin/master-data/siswa') }}">Siswa</a></li>
                </ul>
            </li>
            <li {{ $sb == 'Data Mapel' ? 'class=active' : '' }}>
                <a class="nav-link" href="{{ url('admin/master-data/mapel') }}"><i class="fa-solid fa-book-open"></i>
                    <span>Data Mapel</span>
                </a>
            </li>

            <li {{ $sb == 'Jadwal' ? 'class=active' : '' }}>
                <a class="nav-link" href="{{ url('admin/monitoring/jadwal') }}"><i
                        class="fa-solid fa-calendar-days"></i>
                    <span>Jadwal</span>
                </a>
            </li>
            <li {{ $sb == 'Ujian' ? 'class=active' : '' }}>
                <a class="nav-link" href="{{ url('admin/monitoring/ujian') }}"><i class="fa-solid fa-pen-to-square"></i>
                    <span>Ujian</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
