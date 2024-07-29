@if (Auth::user()->role == 'owner')
<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">

            <div class="sidenav-menu-heading d-sm-none">Account</div>

            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Menu Utama</div>

            <a class="nav-link" href="/">
                <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                        <line x1="12" y1="20" x2="12" y2="10"></line>
                        <line x1="18" y1="20" x2="18" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="16"></line>
                    </svg></div>
                Dashboard
            </a>
            <!-- Sidenav Accordion (Dashboard)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseManajemenAkun" aria-expanded="false" aria-controls="collapseManajemenAkun">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                User
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseManajemenAkun" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link" href="/admin">Admin</a>
                    <a class="nav-link" href="/karyawan">Karyawan</a>
                </nav>
            </div>

            <a class="nav-link" href="/data/kehadiran/all/{{ \Carbon\Carbon::now()->month }}">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                Data Kehadiran
            </a>


            <a class="nav-link" href="/data/gaji/all/{{ \Carbon\Carbon::now()->month }}">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Gaji
            </a>

            <a class="nav-link" href="/data/pinjaman/all/{{ \Carbon\Carbon::now()->month }}">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Pinjaman
            </a>


            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Pesanan</div>
            <!-- Sidenav Accordion (Dashboard)-->

            <a class="nav-link" href="/pesanan">
                <div class="nav-link-icon"><i data-feather="monitor"></i></div>
                Pesanan
            </a>

            <a class="nav-link" href="/meja">
                <div class="nav-link-icon"><i data-feather="box"></i></div>
                Pemesanan Tempat
            </a>

            <div class="sidenav-menu-heading">Data Master</div>


            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDataMaster" aria-expanded="false" aria-controls="collapseDataMaster">
                <div class="nav-link-icon"><i data-feather="box"></i></div>
                Data Master
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseDataMaster" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link" href="/kategorimenu">Kategori Menu</a>
                    <a class="nav-link" href="/kategoripengeluaran">Kategori Pengeluaran</a>
                    <a class="nav-link" href="/menu">Menu</a>
                    <a class="nav-link" href="/inventori">Inventori</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Dashboard)-->

            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseBahanBaku" aria-expanded="false" aria-controls="collapseBahanBaku">
                <div class="nav-link-icon"><i data-feather="box"></i></div>
                Bahan Baku
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseBahanBaku" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link" href="/bahanbaku">Data</a>
                    <a class="nav-link" href="/bahanbaku/laporan">Laporan</a>
                </nav>
            </div>


            <div class="sidenav-menu-heading">Keuangan</div>

            <a class="nav-link" href="/pemasukan">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Pemasukan
            </a>

            <a class="nav-link" href="/penjualan">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Penjualan
            </a>

            <a class="nav-link" href="/pengeluaran">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Pengeluaran
            </a>
        </div>
    </div>

</nav>
@elseif (Auth::user()->role == 'admin')
<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">

            <div class="sidenav-menu-heading d-sm-none">Account</div>

            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Menu Utama</div>

            <!-- <a class="nav-link" href="/">
                    <div class="nav-link-icon"><i data-feather="user"></i></div>
                    Dashboard
                </a> -->


            <!-- Sidenav Accordion (Dashboard)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseManajemenAkun" aria-expanded="false" aria-controls="collapseManajemenAkun">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                User
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseManajemenAkun" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <!-- <a class="nav-link" href="/admin">Admin</a> -->
                    <a class="nav-link" href="/karyawan">Karyawan</a>
                </nav>
            </div>

            <a class="nav-link" href="/data/kehadiran/all/{{ \Carbon\Carbon::now()->month }}">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                Data Kehadiran
            </a>

            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Pesanan</div>
            <!-- Sidenav Accordion (Dashboard)-->

            <a class="nav-link" href="/pesanan">
                <div class="nav-link-icon"><i data-feather="monitor"></i></div>
                Pesanan
            </a>

            <a class="nav-link" href="/meja">
                <div class="nav-link-icon"><i data-feather="box"></i></div>
                Pemesanan Tempat
            </a>

            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Manajamen Akun</div>
            <!-- Sidenav Accordion (Dashboard)-->



            <a class="nav-link" href="/kehadiran/{{ \Carbon\Carbon::now()->month }}">
                <div class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                        <line x1="12" y1="20" x2="12" y2="10"></line>
                        <line x1="18" y1="20" x2="18" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="16"></line>
                    </svg></div>
                Kehadiran
            </a>


            <a class="nav-link" href="/gaji">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Gaji
            </a>

            <a class="nav-link" href="/pinjaman">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Pinjaman
            </a>

            <div class="sidenav-menu-heading">Data Master</div>


            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDataMaster" aria-expanded="false" aria-controls="collapseDataMaster">
                <div class="nav-link-icon"><i data-feather="box"></i></div>
                Data Master
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseDataMaster" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                <a class="nav-link" href="/kategorimenu">Kategori Menu</a>
                    <a class="nav-link" href="/kategoripengeluaran">Kategori Pengeluaran</a>
                    <a class="nav-link" href="/menu">Menu</a>
                    <a class="nav-link" href="/inventori">Inventori</a>
                </nav>
            </div>
            <!-- Sidenav Accordion (Dashboard)-->

            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseBahanBaku" aria-expanded="false" aria-controls="collapseBahanBaku">
                <div class="nav-link-icon"><i data-feather="box"></i></div>
                Bahan Baku
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseBahanBaku" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link" href="/bahanbaku">Data</a>
                    <a class="nav-link" href="/bahanbaku/laporan">Laporan</a>
                </nav>
            </div>

            <a class="nav-link" href="/menu">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Menu
            </a>



            <div class="sidenav-menu-heading">Keuangan</div>

            <a class="nav-link" href="/pemasukan">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Pemasukan
            </a>

            <a class="nav-link" href="/penjualan">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Penjualan
            </a>

            <a class="nav-link" href="/pengeluaran">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Pengeluaran
            </a>
        </div>
    </div>

</nav>
@elseif (Auth::user()->role == 'karyawan')
<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">

            <div class="sidenav-menu-heading d-sm-none">Account</div>

            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Pesanan</div>
            <!-- Sidenav Accordion (Dashboard)-->

            <a class="nav-link" href="/pesanan">
                <div class="nav-link-icon"><i data-feather="monitor"></i></div>
                Kasir
            </a>

            <a class="nav-link" href="/meja">
                <div class="nav-link-icon"><i data-feather="box"></i></div>
                Meja Tersedia
            </a>

            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Manajamen Akun</div>
            <!-- Sidenav Accordion (Dashboard)-->

            <a class="nav-link" href="/kehadiran">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                Kehadiran
            </a>


            <a class="nav-link" href="/gaji">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Gaji
            </a>

            <a class="nav-link" href="/pinjaman">
                <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                Pinjaman
            </a>


        </div>
    </div>

</nav>
@endif