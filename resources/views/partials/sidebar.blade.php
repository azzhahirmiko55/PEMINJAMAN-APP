<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand text-primary d-flex align-items-center">
                <!-- ========   Change your logo from here   ============ -->
                {{-- <img src="{{asset('/assets/images/Logo_BPN.png') }}" class="img-fluid logo-lg" alt="logo"> --}}
                <img src="{{asset('/assets/images/Logo_BPN.png') }}" class="img-fluid" width="50" height="50"
                    alt="logo">
                <h2 class="mb-0 ms-2">&nbsp;BPN</h2>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget"></label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Home</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('dashboard') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#dashboard"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                {{-- Admin --}}
                @if ($user->role == 0)
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Master Data</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('user') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#user"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Data User</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('pegawai') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#profile"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Data Pegawai</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('ruangan') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#border-inner"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Data Ruangan</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('kendaraan') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#car"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Data Kendaraan</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Menu</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('kasubag.data.peminjaman') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#book"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Riwayat Penggunaan</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('admin.pelaporan.peminjaman') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#account-book"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Pelaporan Penggunaan</span>
                    </a>
                </li>
                @endif
                {{-- Pegawai --}}
                @if ($user->role == 4)
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Menu</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('pegawai.peminjaman') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#calendar"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Peminjaman</span>
                    </a>
                </li>
                @endif
                {{-- Staff --}}
                @if ($user->role == 2)
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Menu</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('staff.verifikasi.peminjaman') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#check-circle"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Verifikasi Peminjaman</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('staff.riwayat.peminjaman') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#book"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Riwayat Penggunaan</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('staff.pelaporan.peminjaman') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#account-book"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Pelaporan Penggunaan</span>
                    </a>
                </li>
                @endif
                {{-- Satpam --}}
                @if ($user->role == 3)
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Menu</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('satpam.pengembalian') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#rollback"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Pengembalian</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('satpam.laporan.pengembalian') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#account-book"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Laporan Pengembalian</span>
                    </a>
                </li>
                @endif
                {{-- Kasubag --}}
                @if ($user->role == 1)
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Menu</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('kasubag.data.peminjaman') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#book"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Riwayat Penggunaan</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('kasubag.pelaporan.peminjaman') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#account-book"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Pelaporan Penggunaan</span>
                    </a>
                </li>
                @endif

                {{-- <li class="pc-item pc-caption">
                    <label data-i18n="Widget">UI Components</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item">
                    <a href="../elements/bc_typography.html" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#font-size"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Typography</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../elements/bc_color.html" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#bg-colors"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Color</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../elements/icon-tabler.html" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#highlight"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Icons</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Pages</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>
                <li class="pc-item">
                    <a href="../pages/login.html" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#lock"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Login</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../pages/register.html" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#user-add"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Register</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label data-i18n="Widget">Other</label>
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#line-chart"></use>
                        </svg>
                    </i>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#swap"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext" data-i18n="Menu levels">Menu levels</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="#!" data-i18n="Level 2.1">Level 2.1</a></li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">
                                <span data-i18n="Level 2.2">Level 2.2</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!" data-i18n="Level 3.1">Level 3.1</a>
                                </li>
                                <li class="pc-item"><a class="pc-link" href="#!" data-i18n="Level 3.2">Level 3.2</a>
                                </li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#!" class="pc-link">
                                        <span data-i18n="Level 3.3">Level 3.3</span>
                                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                                    </a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#!" data-i18n="Level 4.1">Level
                                                4.1</a></li>
                                        <li class="pc-item"><a class="pc-link" href="#!" data-i18n="Level 4.2">Level
                                                4.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">
                                <span data-i18n="Level 2.2">Level 2.3</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!" data-i18n="Level 3.1">Level 3.1</a>
                                </li>
                                <li class="pc-item"><a class="pc-link" href="#!" data-i18n="Level 3.2">Level 3.2</a>
                                </li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#!" class="pc-link">
                                        <span data-i18n="Level 3.3">Level 3.3</span>
                                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                                    </a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="../other/sample-page.html" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#chrome"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext" data-i18n="Sample Page">Sample page</span>
                    </a>
                </li> --}}
            </ul>
            {{-- <div class="card text-center">
                <div class="card-body">
                    <img src="../assets/images/img-navbar-card.png" alt="images" class="img-fluid mb-2">
                    <h5>Upgrade To Pro</h5>
                    <p>To get more features and components</p>
                    <a href="https://codedthemes.com/item/mantis-bootstrap-admin-dashboard/" target="_blank"
                        class="btn btn-success">Buy Now</a>
                </div>
            </div> --}}
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->
