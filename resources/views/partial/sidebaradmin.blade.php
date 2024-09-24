<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item ">
                    <a href="{{ route('dashboardadmin') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Data Pengguna</span>
                    </a>
                    <ul class="submenu ">
                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">Data Alumni</a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="import-data-alumni.html">Import Data</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{ route('alumniadmin') }}">Lihat Data</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">Data Perusahaan</a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="tambah-data-perusahaan.html">Tambah Data</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{ route('perusahaan.index') }}">Lihat Data</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item ">
                    <a href="index.html" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>Akun Pengguna</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="index.html" class='sidebar-link'>
                        <i class="bi bi-briefcase-fill"></i>
                        <span>Ajuan Loker</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="index.html" class='sidebar-link'>
                        <i class="bi bi-archive-fill"></i>
                        <span>Laporan</span>
                    </a>
                </li>


               

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>