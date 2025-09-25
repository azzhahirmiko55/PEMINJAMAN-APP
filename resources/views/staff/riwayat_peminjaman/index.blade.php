@extends('layouts.app')

@section('content')
{{-- <div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('filter.save') }}" method="post" autocomplete="off" class="mb-2">
                @csrf
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control"
                            value="{{ $filter['tanggal_awal'] ?? '' }}">
                        @error('tanggal_awal')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control"
                            value="{{ $filter['tanggal_akhir'] ?? '' }}">
                        @error('tanggal_akhir')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-primary">
                        <svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                            <use xlink:href="#search"></use>
                        </svg>&nbsp;
                        Search
                    </button>
                    <form action="{{ route('filter.reset') }}" method="post">
                        @csrf
                        <button class="btn btn-light" formaction="{{ route('filter.reset') }}">
                            <svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                                <use xlink:href="#reload"></use>
                            </svg>&nbsp;
                            Reset
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Riwayat Peminjaman</h5>
            <form class="d-inline-flex align-items-center" action="{{ route('staff.riwayat.peminjaman.export') }}"
                method="post" target="_blank">
                @csrf
                <button class="btn btn-success" formaction="{{ route('staff.riwayat.peminjaman.export') }}">
                    <svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                        <use xlink:href="#file-excel"></use>
                    </svg>&nbsp;
                    Export Data
                </button>
            </form>
        </div>
        <div class="card-body">
            <div class="col-sm-12">
                <div class="dt-responsive table-responsive">
                    <div id="table-style-hover_wrapper" class="dt-container dt-bootstrap5">
                        <div class="row mt-2 justify-content-md-center">
                            <div class="col-12 ">
                                <table id="table-style-hover"
                                    class="table table-striped table-hover table-bordered nowrap dataTable"
                                    aria-describedby="table-style-hover_info" style="width: 983px;">
                                    <thead>
                                        <tr role="row">
                                            <th data-dt-column="0" rowspan="2" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                aria-sort="ascending" aria-label="Name: Activate to invert sorting"
                                                tabindex="0"><span class="dt-column-title" role="button">No.</span><span
                                                    class="dt-column-order"></span>
                                            </th>
                                            <th data-dt-column="1" rowspan="2" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                aria-sort="ascending" aria-label="Name: Activate to invert sorting"
                                                tabindex="0"><span class="dt-column-title" role="button">Nama
                                                    Pegawai</span><span class="dt-column-order"></span>
                                            </th>
                                            <th data-dt-column="2" rowspan="2" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Position: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Tanggal</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="3" rowspan="1" colspan="2"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Waktu Peminjaman</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="4" rowspan="2" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Tipe Peminjaman</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="4" rowspan="2" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Verifikator</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="5" rowspan="1" colspan="3"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Kendaraan</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="5" rowspan="1" colspan="2"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Ruangan</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="5" rowspan="2" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Status</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="5" rowspan="2" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Pengembalian</span><span
                                                    class="dt-column-order"></span></th>
                                        </tr>
                                        <tr>
                                            <th data-dt-column="3" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Mulai</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="4" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Selesai</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="5" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Driver</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="6" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Plat Nomor</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="7" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Jenis Kendaraan</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="8" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Ruangan</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="8" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc text-center"
                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Peserta</span><span
                                                    class="dt-column-order"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no=1
                                        @endphp
                                        @foreach ($dRiwayat as $item)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}.</td>
                                            <td>{{ $item->nama_pegawai }}</td>
                                            <td>{{
                                                \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d
                                                F Y') }}
                                            </td>
                                            <td>{{
                                                \Carbon\Carbon::parse($item->jam_mulai)->translatedFormat('H:i:s') }}
                                            </td>
                                            <td>{{
                                                \Carbon\Carbon::parse($item->jam_selesai)->translatedFormat('H:i:s') }}
                                            </td>
                                            <td>{{ strtoupper($item->tipe_peminjaman) }}</td>
                                            <td>{{ ($item->verifikator_nama) }}</td>
                                            <td>{{ ($item->driver) }}</td>
                                            <td>{{ ($item->no_plat) }}</td>
                                            <td>{{ ($item->jenis_kendaraan) }}</td>
                                            <td>{{ ($item->nama_ruangan) }}</td>
                                            <td class="text-center">{{ ($item->jumlah_peserta) }}</td>
                                            <td class="text-center">
                                                @if ($item->status == 1)
                                                <span class="badge bg-success m-2 fs-6 rounded-1">
                                                    <svg class="pc-icon"
                                                        style="width:14px; height:14px; fill:currentColor;">
                                                        <use xlink:href="#check"></use>
                                                    </svg>&nbsp;
                                                    Disetujui
                                                </span>
                                                @elseif ($item->status == -1)
                                                <span class="badge bg-danger m-2 fs-6 rounded-1">
                                                    <svg class="pc-icon"
                                                        style="width:14px; height:14px; fill:currentColor;">
                                                        <use xlink:href="#x"></use>
                                                    </svg>&nbsp;
                                                    Ditolak
                                                </span>
                                                @else
                                                <span class="badge bg-warning m-2 fs-6 rounded-1">
                                                    <svg class="pc-icon"
                                                        style="width:14px; height:14px; fill:currentColor;">
                                                        <use xlink:href="#reload"></use>
                                                    </svg>&nbsp;
                                                    Proses Verifikasi
                                                </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->pengembalian_st == 1)
                                                <span class="badge bg-success m-2 fs-6 rounded-1">
                                                    <svg class="pc-icon"
                                                        style="width:14px; height:14px; fill:currentColor;">
                                                        <use xlink:href="#check"></use>
                                                    </svg>&nbsp;
                                                    Sudah dikembalikan
                                                </span>
                                                @else
                                                <span class="badge bg-warning m-2 fs-6 rounded-1">
                                                    <svg class="pc-icon"
                                                        style="width:14px; height:14px; fill:currentColor;">
                                                        <use xlink:href="#reload"></use>
                                                    </svg>&nbsp;
                                                    Belum dikembalikan
                                                </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('filter.save') }}" method="post" autocomplete="off" class="mb-2">
                @csrf
                <div class="col-sm-12 d-flex justify-content-end mb-2">
                    <div class="col-sm-2">
                        <select class="form-control" name="section_view" id="section-mode"
                            onchange="this.form.submit()">
                            <option value="0" {{ ($filter['section_view']??'')==0?'selected':'' }}>List Data Ruangan
                            </option>
                            <option value="-1" {{ ($filter['section_view']??'')==-1?'selected':'' }}>List Data Kendaraan
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control"
                            value="{{ $filter['tanggal_awal'] ?? '' }}">
                        @error('tanggal_awal')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control"
                            value="{{ $filter['tanggal_akhir'] ?? '' }}">
                        @error('tanggal_akhir')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6 {{ ($filter['section_view']??'')==-1?'':'d-none' }}" id="select-kendaraan">
                        <label class="form-label">Kendaraan</label>
                        <select name="id_kendaraan" class="form-control" id="">
                            <option value="" {{ isset($filter['id_kendaraan'])?'':'selected' }}>-- Semua Kendaraan --
                            </option>
                            @foreach ($mst_kendaraan as $item)
                            <option value="{{ $item->id_kendaraan }}" {{ ($filter['id_kendaraan']??'')==$item->
                                id_kendaraan
                                ? 'selected' : '' }}>
                                {{ $item->no_plat.' - '.$item->jenis_kendaraan }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_kendaraan')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6 {{ ($filter['section_view']??0)==0?'':'d-none' }}" id="select-ruangan">
                        <label class="form-label">Ruangan</label>
                        <select name="id_ruangan" class="form-control" id="">
                            <option value="" {{ empty($filter['id_ruangan'])?'selected':'' }}>-- Semua Ruangan --
                            </option>
                            @foreach ($mst_ruangan as $item1)
                            <option value="{{ $item1->id_ruangrapat }}" {{ ($filter['id_ruangan']??'')==$item1->
                                id_ruangrapat
                                ? 'selected' : '' }}>
                                {{ $item1->nama_ruangan.' - '.$item1->warna_ruangan }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_ruangan')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Peminjaman</label>
                        <select name="status" class="form-control" id="">
                            <option value="" {{ isset($filter['status'])?'':'selected' }}>-- Semua Status --
                            </option>
                            <option value="1" {{ ($filter['status']??'')==1?'selected':'' }}>Disetujui </option>
                            <option value="-1" {{ ($filter['status']??'')==-1?'selected':'' }}>Ditolak </option>
                        </select>
                        @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6 ">
                    <label class="form-label">Pegawai</label>
                    <select name="id_peminjam" class="form-control" id="">
                        <option value="" {{ empty($filter['id_peminjam'])?'selected':'' }}>-- Semua Pegawai --
                        </option>
                        @foreach ($mst_pegawai as $item1)
                        <option value="{{ $item1->id_pegawai }}" {{ ($filter['id_peminjam']??'')==$item1->
                            id_pegawai
                            ? 'selected' : '' }}>
                            {{ $item1->nama_pegawai }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_peminjam')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-primary">
                        <svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                            <use xlink:href="#search"></use>
                        </svg>&nbsp;
                        Search
                    </button>
                    <form action="{{ route('filter.reset') }}" method="post">
                        @csrf
                        <button class="btn btn-light" formaction="{{ route('filter.reset') }}">
                            <svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                                <use xlink:href="#reload"></use>
                            </svg>&nbsp;
                            Reset
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
    <section id="section-data-table-ruangan" class="{{ ($filter['section_view']??0)==0?'':'d-none' }}">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Riwayat Peminjaman Ruangan</h5>
                <form class="d-inline-flex align-items-center"
                    action="{{ route('staff.data.peminjaman.export_ruangan') }}" method="post" target="_blank">
                    @csrf
                    <button class="btn btn-success" formaction="{{ route('staff.data.peminjaman.export_ruangan') }}">
                        <svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                            <use xlink:href="#file-excel"></use>
                        </svg>&nbsp;
                        Create Riwayat
                    </button>
                </form>
            </div>
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="dt-responsive table-responsive">
                        <div id="table-style-hover_wrapper" class="dt-container dt-bootstrap5">
                            <div class="row mt-2 justify-content-md-center">
                                <div class="col-12 ">
                                    <table id="table-style-hover"
                                        class="table table-striped table-hover table-bordered nowrap dataTable w-100"
                                        aria-describedby="table-style-hover_info">
                                        <thead>
                                            <tr role="row">
                                                <th data-dt-column="0" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                    aria-sort="ascending" aria-label="Name: Activate to invert sorting"
                                                    tabindex="0"><span class="dt-column-title"
                                                        role="button">No.</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="1" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                    aria-sort="ascending" aria-label="Name: Activate to invert sorting"
                                                    tabindex="0"><span class="dt-column-title" role="button">Nama
                                                        Pegawai</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Tanggal</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="3" rowspan="1" colspan="2"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Waktu
                                                        Peminjaman</span><span class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Tipe
                                                        Peminjaman</span><span class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="1" colspan="2"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Verifikasi</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="5" rowspan="1" colspan="2"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Ruangan</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="5" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Status</span><span
                                                        class="dt-column-order"></span></th>
                                            </tr>
                                            <tr>
                                                <th data-dt-column="3" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Mulai</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Selesai</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Verifikator</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Tanggal</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="8" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Ruangan</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="8" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Peserta</span><span
                                                        class="dt-column-order"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $no=1
                                            @endphp
                                            @foreach ($dRiwayat as $item)
                                            @if ($item->tipe_peminjaman === 'ruangan')
                                            <tr>
                                                <td class="text-center">{{ $no++ }}.</td>
                                                <td>{{ $item->nama_pegawai }}</td>
                                                <td>{{
                                                    \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d
                                                    F Y') }}
                                                </td>
                                                <td>{{
                                                    \Carbon\Carbon::parse($item->jam_mulai)->translatedFormat('H:i:s')
                                                    }}
                                                </td>
                                                <td>{{
                                                    \Carbon\Carbon::parse($item->jam_selesai)->locale('id')->translatedFormat('H:i:s')
                                                    }}
                                                </td>
                                                <td>{{ strtoupper($item->tipe_peminjaman) }}</td>
                                                <td>{{ ($item->verifikator_nama) }}</td>
                                                <td>
                                                    {{
                                                    !empty($item->verifikator_tgl)?(\Carbon\Carbon::parse($item->verifikator_tgl)->locale('id')->translatedFormat('d
                                                    F Y H:i:s')):''
                                                    }}
                                                </td>
                                                <td>{{ ($item->nama_ruangan) }}</td>
                                                <td class="text-center">{{ ($item->jumlah_peserta) }}</td>
                                                <td class="text-center">
                                                    @if ($item->status == 1)
                                                    <span class="badge bg-success m-2 fs-6 rounded-1">
                                                        <svg class="pc-icon"
                                                            style="width:14px; height:14px; fill:currentColor;">
                                                            <use xlink:href="#check"></use>
                                                        </svg>&nbsp;
                                                        Disetujui
                                                    </span>
                                                    @elseif ($item->status == -1)
                                                    <span class="badge bg-danger m-2 fs-6 rounded-1">
                                                        <svg class="pc-icon"
                                                            style="width:14px; height:14px; fill:currentColor;">
                                                            <use xlink:href="#x"></use>
                                                        </svg>&nbsp;
                                                        Ditolak
                                                    </span>
                                                    @else
                                                    <span class="badge bg-warning m-2 fs-6 rounded-1">
                                                        <svg class="pc-icon"
                                                            style="width:14px; height:14px; fill:currentColor;">
                                                            <use xlink:href="#reload"></use>
                                                        </svg>&nbsp;
                                                        Proses Verifikasi
                                                    </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="section-data-table-kendaraan" class="{{ ($filter['section_view']??'')==-1?'':'d-none' }}">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Riwayat Peminjaman Kendaraan</h5>
                <form class="d-inline-flex align-items-center"
                    action="{{ route('staff.data.peminjaman.export_kendaraan') }}" method="post" target="_blank">
                    @csrf
                    <button class="btn btn-success" formaction="{{ route('staff.data.peminjaman.export_kendaraan') }}">
                        <svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                            <use xlink:href="#file-excel"></use>
                        </svg>&nbsp;
                        Create Riwayat
                    </button>
                </form>
            </div>
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="dt-responsive table-responsive">
                        <div id="table-style-hover_wrapper" class="dt-container dt-bootstrap5">
                            <div class="row mt-2 justify-content-md-center">
                                <div class="col-12 ">
                                    <table id="table-style-hover"
                                        class="table table-striped table-hover table-bordered nowrap dataTable w-100"
                                        aria-describedby="table-style-hover_info">
                                        <thead>
                                            <tr role="row">
                                                <th data-dt-column="0" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                    aria-sort="ascending" aria-label="Name: Activate to invert sorting"
                                                    tabindex="0"><span class="dt-column-title"
                                                        role="button">No.</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="1" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                    aria-sort="ascending" aria-label="Name: Activate to invert sorting"
                                                    tabindex="0"><span class="dt-column-title" role="button">Nama
                                                        Pegawai</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Tanggal</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="3" rowspan="1" colspan="2"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Waktu
                                                        Peminjaman</span><span class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Tipe
                                                        Peminjaman</span><span class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="1" colspan="2"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Verifikasi</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="5" rowspan="1" colspan="3"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Kendaraan</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="5" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Status</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="5" rowspan="1" colspan="3"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Pengembalian</span><span
                                                        class="dt-column-order"></span></th>
                                            </tr>
                                            <tr>
                                                <th data-dt-column="3" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Mulai</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Selesai</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Verifikator</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="4" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Tanggal</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="5" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Driver</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="6" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Plat Nomor</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="7" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Jenis
                                                        Kendaraan</span><span class="dt-column-order"></span></th>
                                                <th data-dt-column="8" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Status</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="8" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Penerima</span><span
                                                        class="dt-column-order"></span></th>
                                                <th data-dt-column="8" rowspan="1" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Office: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Tanggal
                                                        Pengembalian</span><span class="dt-column-order"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $no=1
                                            @endphp
                                            @foreach ($dRiwayat as $item)
                                            @if ($item->tipe_peminjaman === 'kendaraan')
                                            <tr>
                                                <td class="text-center">{{ $no++ }}.</td>
                                                <td>{{ $item->nama_pegawai }}</td>
                                                <td>{{
                                                    \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d
                                                    F Y') }}
                                                </td>
                                                <td>{{
                                                    \Carbon\Carbon::parse($item->jam_mulai)->translatedFormat('H:i:s')
                                                    }}
                                                </td>
                                                <td>{{
                                                    \Carbon\Carbon::parse($item->jam_selesai)->locale('id')->translatedFormat('H:i:s')
                                                    }}
                                                </td>
                                                <td>{{ strtoupper($item->tipe_peminjaman) }}</td>
                                                <td>{{ ($item->verifikator_nama) }}</td>
                                                <td>
                                                    {{
                                                    !empty($item->verifikator_tgl)?(\Carbon\Carbon::parse($item->verifikator_tgl)->locale('id')->translatedFormat('d
                                                    F Y H:i:s')):''
                                                    }}
                                                </td>
                                                <td>{{ ($item->driver) }}</td>
                                                <td>{{ ($item->no_plat) }}</td>
                                                <td>{{ ($item->jenis_kendaraan) }}</td>
                                                <td class="text-center">
                                                    @if ($item->status == 1)
                                                    <span class="badge bg-success m-2 fs-6 rounded-1">
                                                        <svg class="pc-icon"
                                                            style="width:14px; height:14px; fill:currentColor;">
                                                            <use xlink:href="#check"></use>
                                                        </svg>&nbsp;
                                                        Disetujui
                                                    </span>
                                                    @elseif ($item->status == -1)
                                                    <span class="badge bg-danger m-2 fs-6 rounded-1">
                                                        <svg class="pc-icon"
                                                            style="width:14px; height:14px; fill:currentColor;">
                                                            <use xlink:href="#x"></use>
                                                        </svg>&nbsp;
                                                        Ditolak
                                                    </span>
                                                    @else
                                                    <span class="badge bg-warning m-2 fs-6 rounded-1">
                                                        <svg class="pc-icon"
                                                            style="width:14px; height:14px; fill:currentColor;">
                                                            <use xlink:href="#reload"></use>
                                                        </svg>&nbsp;
                                                        Proses Verifikasi
                                                    </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->pengembalian_st == 1)
                                                    <span class="badge bg-success m-2 fs-6 rounded-1">
                                                        <svg class="pc-icon"
                                                            style="width:14px; height:14px; fill:currentColor;">
                                                            <use xlink:href="#check"></use>
                                                        </svg>&nbsp;
                                                        Sudah dikembalikan
                                                    </span>
                                                    @else
                                                    <span class="badge bg-warning m-2 fs-6 rounded-1">
                                                        <svg class="pc-icon"
                                                            style="width:14px; height:14px; fill:currentColor;">
                                                            <use xlink:href="#reload"></use>
                                                        </svg>&nbsp;
                                                        Belum dikembalikan
                                                    </span>
                                                    @endif
                                                </td>
                                                <td>{{ ($item->pengembalian_nm) }}</td>
                                                <td>
                                                    {{
                                                    !empty($item->pengembalian_tgl)?(\Carbon\Carbon::parse($item->pengembalian_tgl)->locale('id')->translatedFormat('d
                                                    F Y H:i:s')):''
                                                    }}
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


@push('scripts')

<script>
    $(document).ready(function () {
        // initDataTable('table-style-hover');
    });
</script>

@endpush
