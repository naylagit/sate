@if (Auth::user()->role == 'owner')
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">

                <div class="sidenav-menu-heading d-sm-none">Account</div>

                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Menu Utama</div>

                <a class="nav-link" href="/kehadiran/list">
                    <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg></div>
                    Dashboard
                </a>

                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Manajemen User</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                    data-bs-target="#collapseManajemenAkun" aria-expanded="false" aria-controls="collapseManajemenAkun">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Manajemen Akun
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseManajemenAkun" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="admin">Admin</a>
                        <a class="nav-link" href="karyawan">Karyawan</a>
                    </nav>
                </div>


                <a class="nav-link" href="/kehadiran/list">
                    <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg></div>
                    Kehadiran
                </a>

                <a class="nav-link" href="/kehadiran">
                    <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg></div>
                    Gaji
                </a>


                <a class="nav-link" href="/kehadiran">
                    <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg></div>
                    Pinjaman
                </a>


                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Inventori</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                    data-bs-target="#collapseInventori" aria-expanded="false" aria-controls="collapseInventori">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Bahan Baku
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseInventori" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="admin">Data</a>
                        <a class="nav-link" href="admin">Kategori</a>
                        <a class="nav-link" href="karyawan">Laporan</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                    data-bs-target="#collapseMenu" aria-expanded="false" aria-controls="collapseMenu">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Menu
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMenu" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="dashboard-2.html">Data</a>
                    </nav>
                </div>


            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->nama }}</div>
            </div>
        </div>
    </nav>
@elseif(Auth::user()->role == 'admin')
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">

                <div class="sidenav-menu-heading d-sm-none">Account</div>


                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">User</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link" href="/kehadiran/{{ Auth::user()->id }}">
                    <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg></div>
                    Kehadiran
                </a>


                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Manajemen User</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                    data-bs-target="#collapseManajemenAkun" aria-expanded="false"
                    aria-controls="collapseManajemenAkun">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Manajemen Akun
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseManajemenAkun" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">

                        <a class="nav-link" href="karyawan">Karyawan</a>
                    </nav>
                </div>


                <a class="nav-link" href="/kehadiran/list">
                    <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg></div>
                    Daftar Kehadiran
                </a>


                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Inventori</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                    data-bs-target="#collapseInventori" aria-expanded="false" aria-controls="collapseInventori">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Bahan Baku
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseInventori" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="admin">Data</a>
                        <a class="nav-link" href="admin">Kategori</a>
                        <a class="nav-link" href="karyawan">Laporan</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                    data-bs-target="#collapseMenu" aria-expanded="false" aria-controls="collapseMenu">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Menu
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMenu" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="dashboard-2.html">Data</a>
                    </nav>
                </div>


            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->nama }}</div>
            </div>
        </div>
    </nav>
@elseif(Auth::user()->role == 'karyawan')
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">

                <div class="sidenav-menu-heading d-sm-none">Account</div>


                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">User</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link" href="/kehadiran/{{ Auth::user()->id }}">
                    <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg></div>
                    Kehadiran
                </a>

                <a class="nav-link" href="/kehadiran">
                    <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg></div>
                    Gaji
                </a>

                <a class="nav-link" href="/kehadiran">
                    <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg></div>
                    Pinjaman
                </a>







            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->nama }}</div>
            </div>
        </div>
    </nav>
@endif
