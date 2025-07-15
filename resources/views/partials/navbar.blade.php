<!-- main header @s -->
<div class="nk-header is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger me-sm-2 d-lg-none">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand">
                <a href="#" class="logo-link">
                   <h4>Aplikasi Peminjaman Kendaraan dan Ruang Rapat</h4>
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-menu ms-auto" data-content="headerNav">
                <div class="nk-header-mobile">
                    <div class="nk-header-brand">
                        <a href="#" class="logo-link">
                            <h4>Aplikasi Peminjaman</h4>
                        </a>
                    </div>
                    <div class="nk-menu-trigger me-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div>
                <ul class="nk-menu nk-menu-main ui-s2">
                    <li class="nk-menu-item has-sub">
                        <a href="/index" class="nk-menu-link">
                            <span class="nk-menu-text">Dashboards</span>
                        </a>
                    </li>
                    @if (Auth::check())
                    @if (Auth::user()->username != "kepala_kantor")
                    @if (Auth::user()->username != "satpam")
                    <li class="nk-menu-item has-sub {{ ($page === "Form Peminjaman Kendaraan")  ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-text">Form</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{ ($page === "Form Peminjaman Kendaraan")  ? 'active' : '' }}">
                                <a href="/calendarKendaraan" class="nk-menu-link"><span class="nk-menu-text">Form Kendaraan</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="/calendarRuangrapat" class="nk-menu-link"><span class="nk-menu-text">Form Ruang Rapat</span></a>
                            </li>
                            {{-- <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link"><span class="nk-menu-text">Form Alat Ukur</span></a>
                            </li> --}}
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    @endif
                     @endif
                    @endif
                    <li class="nk-menu-item has-sub {{ ($page === "Rekapitulasi Peminjaman Kendaraan")  ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-text">Rekapitulasi</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{ ($page === "Rekapitulasi Peminjaman Kendaraan")  ? 'active' : '' }}">
                                <a href="/rekapitulasiKendaraan" class="nk-menu-link"><span class="nk-menu-text">Peminjaman Kendaraan</span></a>
                            </li>
                            @if (Auth::check())
                            @if (Auth::user()->username != "satpam")
                            <li class="nk-menu-item">
                                <a href="/rekapitulasiRuangrapat" class="nk-menu-link"><span class="nk-menu-text">Peminjaman Ruang Rapat</span></a>
                            </li>
                            @endif
                            @endif
                            {{-- <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link"><span class="nk-menu-text">Peminjaman Alat Ukur</span></a>
                            </li> --}}
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    @if (Auth::check())
                     @if (Auth::user()->username != "pengguna")
                     @if (Auth::user()->username != "kepala_kantor")
                      @if (Auth::user()->username != "kasubag")
                       @if (Auth::user()->username != "satpam")
                        <li class="nk-menu-item has-sub {{ ($page === "Master Kendaraan"  || "Master Ruang Rapat" || "Master Karyawan")  ? 'active' : '' }}">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-text">Master</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item {{ ($page === "Master Kendaraan")  ? 'active' : '' }}">
                                    <a href="/masterKendaraan" class="nk-menu-link"><span class="nk-menu-text">Kendaraan</span></a>
                                </li>
                                <li class="nk-menu-item {{ ($page === "Master Ruang Rapat")  ? 'active' : '' }}">
                                    <a href="/masterRuangRapat" class="nk-menu-link"><span class="nk-menu-text">Ruang Rapat</span></a>
                                </li>
                                <li class="nk-menu-item {{ ($page === "Master Karyawan")  ? 'active' : '' }}">
                                    <a href="/masterKaryawan" class="nk-menu-link"><span class="nk-menu-text">Karyawan</span></a>
                                </li>
                                {{-- <li class="nk-menu-item">
                                    <a href="#" class="nk-menu-link"><span class="nk-menu-text">Alat Ukur</span></a>
                                </li> --}}
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                        @endif
                        @endif
                        @endif
                    @endif
                    @endif
                </ul><!-- .nk-menu -->
            </div><!-- .nk-header-menu -->
            @if (Auth::check())
                <div class="nk-header-tools">
                    <ul class="nk-quick-nav">
                        <li class="dropdown user-dropdown order-sm-first">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="user-toggle">
                                    <div class="user-avatar sm">
                                        <em class="icon ni ni-user-alt"></em>
                                    </div>
                                    @if (Auth::user()->username == "kepala_kantor")
                                    <div class="user-info d-none d-xl-block">
                                        <div class="user-status">Kepala Kantor</div>
                                        <div class="user-name dropdown-indicator">Kepala Kantor</div>
                                    </div>
                                    @elseif (Auth::user()->username == "kasubag")
                                    <div class="user-info d-none d-xl-block">
                                        <div class="user-status">Kasubag</div>
                                        <div class="user-name dropdown-indicator">Kasubag</div>
                                    </div>
                                    @elseif (Auth::user()->username == "satpam")
                                    <div class="user-info d-none d-xl-block">
                                        <div class="user-status">Satpam</div>
                                        <div class="user-name dropdown-indicator">Satpam</div>
                                    </div>
                                    @elseif (Auth::user()->username == "admin")
                                    <div class="user-info d-none d-xl-block">
                                        <div class="user-status">Admin</div>
                                        <div class="user-name dropdown-indicator">Admin</div>
                                    </div>
                                    @else
                                    <div class="user-info d-none d-xl-block">
                                        <div class="user-status">Pengguna</div>
                                        <div class="user-name dropdown-indicator">Pengguna</div>
                                    </div>
                                    @endif
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1 is-light">
                                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                    <div class="user-card">
                                        <div class="user-avatar">
                                            <span>A</span>
                                        </div>
                                        @if (Auth::user()->username != "pengguna")
                                        <div class="user-info">
                                            {{-- <span class="lead-text">Administrator</span>
                                            <span class="sub-text">Admin Aplikasi</span> --}}
                                        </div>
                                        @else
                                        <div class="user-info">
                                            {{-- <span class="lead-text">Pengguna</span>
                                            <span class="sub-text">Pengguna Aplikasi</span> --}}
                                        </div>
                                        @endif
                                        <div class="user-action">
                                            <a class="btn btn-icon me-n2" href="#"><em class="icon ni ni-setting"></em></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="/logout"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li><!-- .dropdown -->
                    </ul>
                </div>
            @else
                <div class="nk-header-tools">
                    <ul class="nk-quick-nav">
                        <li class="dropdown user-dropdown order-sm-first">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="user-toggle">
                                    <div class="user-avatar sm">
                                        <em class="icon ni ni-user-alt"></em>
                                    </div>
                                    <div class="user-info d-none d-xl-block">
                                        <div class="user-status">-</div>
                                        <div class="user-name"><a href="/login">Login Pengguna</a></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>
<!-- main header @e -->
