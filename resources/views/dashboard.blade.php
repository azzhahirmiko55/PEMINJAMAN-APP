@extends('layouts.main')

@section('container')

<!-- content @s -->
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Dashboard</h3>
                            <div class="nk-block-des text-soft">
                                <p>Statistik Peminjaman Kendaraan dan Ruang Rapat Kantor Pertanahan Kabupaten Cilacap
                                </p>
                            </div>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                    data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li><a href="/calendarKendaraan" target="_blank"
                                                class="btn btn-white btn-dim btn-outline-primary"><em
                                                    class="icon ni ni-reports"></em><span>Form Peminjaman
                                                    Kendaraan</span></a></li>
                                        <li><a href="/calendarRuangrapat" target="_blank"
                                                class="btn btn-white btn-dim btn-outline-primary"><em
                                                    class="icon ni ni-reports"></em><span>Form Peminjaman Ruang
                                                    Rapat</span></a></li>
                                    </ul>
                                </div><!-- .toggle-expand-content -->
                            </div><!-- .toggle-wrap -->
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-md-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="subtitle">Total Peminjaman Kendaraan Hari Ini</h6>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip"
                                                data-bs-placement="left"
                                                title="Total Peminjaman Kendaraan Hari Ini"></em>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount"> {{ $total['total_kendaraan_hari'] }} <span
                                                class="currency currency-usd">Kendaraan</span>
                                        </span>
                                    </div>
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <div class="title">Bulan Ini</div>
                                                <div class="amount">{{ $total['total_kendaraan_bulan'] }} <span
                                                        class="currency currency-usd">Kendaraan</span></div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title">Tahun Ini</div>
                                                <div class="amount">{{ $total['total_kendaraan'] }} <span
                                                        class="currency currency-usd">Kendaraan</span></div>
                                            </div>
                                        </div>
                                        <div class="invest-data-ck">
                                            <canvas class="iv-data-chart" id="totalDeposit"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="subtitle">Total Peminjaman Ruang Rapat Hari Ini</h6>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip"
                                                data-bs-placement="left"
                                                title="Total Peminjaman Ruang Rapat Hari Ini"></em>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount"> {{ $total['total_ruangrapat_hari'] }} <span
                                                class="currency currency-usd">Ruang Rapat</span>
                                        </span>
                                    </div>
                                    <div class="invest-data">
                                        <div class="invest-data-amount g-2">
                                            <div class="invest-data-history">
                                                <div class="title">Bulan Ini</div>
                                                <div class="amount">{{ $total['total_ruangrapat_bulan'] }} <span
                                                        class="currency currency-usd">Ruang Rapat</span></div>
                                            </div>
                                            <div class="invest-data-history">
                                                <div class="title">Tahun Ini</div>
                                                <div class="amount">{{ $total['total_ruangrapat'] }} <span
                                                        class="currency currency-usd">Ruang Rapat</span></div>
                                            </div>
                                        </div>
                                        <div class="invest-data-ck">
                                            <canvas class="iv-data-chart" id="totalWithdraw"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-xxl-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Notifikasi Peminjaman Kendaraan</h6>
                                        </div>
                                        <div class="card-tools">
                                            <ul class="card-tools-nav">
                                                <li><a href="/rekapitulasiKendaraan" target="_blank"><span>Lihat
                                                            Rekapitulasi Kendaraan</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity">
                                    @foreach($total['list_kendaraan'] as $key => $row)
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-media user-avatar {{ $arr_bg[$key]; }}">{{
                                            substr($row->peminjam,0,1); }}</div>
                                        <div class="nk-activity-data">
                                            <div class="label">{{ $row->peminjam.' meminjam kendaraan
                                                '.$row->ket_kendaraan.' pada tanggal '.date("d",
                                                strtotime($row->tanggal)).'/'.date("m",
                                                strtotime($row->tanggal)).'/'.date("Y", strtotime($row->tanggal)); }}
                                            </div>
                                            <span class="time">Diinput pada : {{ $row->created_at; }}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-xxl-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Notifikasi Peminjaman Ruang Rapat</h6>
                                        </div>
                                        <div class="card-tools">
                                            <ul class="card-tools-nav">
                                                <li><a href="/rekapitulasiRuangrapat" target="_blank"><span>Lihat
                                                            Rekapitulasi Ruang Rapat</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity">
                                    @foreach($total['list_ruangrapat'] as $key => $row)
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-media user-avatar {{ $arr_bg[$key]; }}">{{
                                            substr($row->peminjam,0,1); }}</div>
                                        <div class="nk-activity-data">
                                            <div class="label">{{ $row->peminjam.' meminjam ruangan '.$row->ruangan.'
                                                pada tanggal '.date("d", strtotime($row->tanggal)).'/'.date("m",
                                                strtotime($row->tanggal)).'/'.date("Y", strtotime($row->tanggal)); }}
                                            </div>
                                            <span class="time">Diinput pada : {{ $row->created_at; }}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-xxl-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Kendaraan yang belum di pakai hari ini</h6>
                                        </div>
                                        <div class="card-tools">
                                            <ul class="card-tools-nav">
                                                <li><a href="/calendarKendaraan" target="_blank"><span>Form
                                                            Kendaraan</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity">
                                    @foreach($total['kendaraan_available'] as $key => $row)
                                    <li class="nk-activity-item">
                                        <div
                                            class="nk-activity-media user-avatar {{ $arr_bg[$key] ?? 'default-bg-class' }}">
                                            {{ substr($row->plat, 0, 1) }}</div>
                                        <div class="nk-activity-data">
                                            <div class="label">{{ $row->text }}</div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-xxl-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Ruangrapat yang belum di pakai hari ini</h6>
                                        </div>
                                        <div class="card-tools">
                                            <ul class="card-tools-nav">
                                                <li><a href="/calendarRuangrapat" target="_blank"><span>Form Ruang
                                                            Rapat</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity">
                                    @foreach($total['ruangrapat_available'] as $key => $row)
                                    <li class="nk-activity-item">
                                        <div class="nk-activity-media user-avatar {{ $arr_bg[$key]; }}">{{
                                            substr($row->text,0,1); }}</div>
                                        <div class="nk-activity-data">
                                            <div class="label">{{ $row->text; }}</div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div><!-- .card -->
                        </div><!-- .col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content @e -->

@endsection
