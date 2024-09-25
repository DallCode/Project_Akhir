<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="/"><img src="{{ asset('bkk/dist/assets/images/logo/ks.jpg')}}" alt="Logo" srcset=""  style="width: 180px; height:auto"></a>
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
                    <a href="{{ route('dashboardperusahaan') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="{{ route('dataloker') }}" class='sidebar-link'>
                        <i class="bi bi-briefcase-fill"></i>
                        <span>Data Loker</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="index.html" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text-fill"></i>
                        <span>Data Lamaran</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class='sidebar-link' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>







            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>

</div>
