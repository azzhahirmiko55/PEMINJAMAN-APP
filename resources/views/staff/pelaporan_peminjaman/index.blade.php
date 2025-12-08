@extends('layouts.app')

@section('content')
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
                </div>
                <div class="row g-2">
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
                <h5 class="mb-0">Pelaporan Peminjaman Ruangan</h5>
                @if (($user->role !== 1))
                <form class="d-inline-flex align-items-center"
                    action="{{ ($user->role == 2)?route('staff.pelaporan.peminjaman.export_ruangan'):route('admin.pelaporan.peminjaman.export_ruangan') }}"
                    method="post" target="_blank">
                    @csrf
                    @php
                    @endphp
                    <button class="btn btn-danger"
                        formaction="{{ ($user->role == 2)?route('staff.pelaporan.peminjaman.export_ruangan'):route('admin.pelaporan.peminjaman.export_ruangan') }}">
                        <svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                            <use xlink:href="#file-pdf"></use>
                        </svg>&nbsp;
                        Create Laporan
                    </button>
                </form>
                @endif
            </div>
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="dt-responsive table-responsive">
                        <div id="table-style-hover_wrapper" class="dt-container dt-bootstrap5">
                            <div class="row mt-2 justify-content-md-center">
                                <div class="col-12 ">
                                    <table id="table-style-hover-ruangan"
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
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Nama Pegawai</span><span
                                                        class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Ruangan</span><span
                                                        class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Total
                                                        Peminjaman</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Total
                                                        Disetujui</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Total
                                                        Tolak</span><span class="dt-column-order"></span>
                                                </th>
                                            </tr>
                                        </thead>
                                        @php $no = 1; @endphp
                                        <tbody>
                                            @foreach ($dRekapRuangan as $row)
                                            <tr>
                                                <td class="text-center">{{ $no++ }}</td>
                                                <td class="text-center">{{ $row->nama_pegawai }}</td>
                                                <td class="text-center">{{ $row->nama_ruangan }}</td>
                                                <td class="text-center">{{ (int)$row->total_peminjaman }}</td>
                                                <td class="text-center">{{ (int)$row->total_disetujui }}</td>
                                                <td class="text-center">{{ (int)$row->total_tolak }}</td>
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
    </section>
    <section id="section-data-table-kendaraan" class="{{ ($filter['section_view']??'')==-1?'':'d-none' }}">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Pelaporan Peminjaman Kendaraan</h5>
                @if (($user->role !== 1))
                <form class="d-inline-flex align-items-center"
                    action="{{ ($user->role == 2)?route('staff.pelaporan.peminjaman.export_kendaraan'):route('admin.pelaporan.peminjaman.export_kendaraan') }}"
                    method="post" target="_blank">
                    @csrf
                    <button class="btn btn-danger"
                        formaction="{{ ($user->role == 2)?route('staff.pelaporan.peminjaman.export_kendaraan'):route('admin.pelaporan.peminjaman.export_kendaraan') }}">
                        <svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                            <use xlink:href="#file-pdf"></use>
                        </svg>&nbsp;
                        Create Laporan
                    </button>
                </form>
                @endif
            </div>
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="dt-responsive table-responsive">
                        <div id="table-style-hover_wrapper" class="dt-container dt-bootstrap5">
                            <div class="row mt-2 justify-content-md-center">
                                <div class="col-12 ">
                                    <table id="table-style-hover-kendaraan"
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
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Nama Pegawai</span><span
                                                        class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Total
                                                        Peminjaman</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Kendaraan Roda
                                                        2</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Kendaraan Roda
                                                        4</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Total
                                                        Disetujui</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Total
                                                        Tolak</span><span class="dt-column-order"></span>
                                                </th>
                                                <th data-dt-column="2" rowspan="2" colspan="1"
                                                    class="dt-orderable-asc dt-orderable-desc text-center"
                                                    aria-label="Position: Activate to sort" tabindex="0"><span
                                                        class="dt-column-title" role="button">Total
                                                        Pengembalian</span><span class="dt-column-order"></span>
                                                </th>
                                            </tr>
                                        </thead>
                                        @php $no = 1; @endphp
                                        <tbody>
                                            @foreach ($dRekapKendaraan as $row)
                                            <tr>
                                                <td class="text-center">{{ $no++ }}</td>
                                                <td class="text-center">{{ $row->nama_pegawai }}</td>
                                                <td class="text-center">{{ (int)$row->total_peminjaman }}</td>
                                                <td class="text-center">{{ (int)$row->kendaraan_roda2 }}</td>
                                                <td class="text-center">{{ (int)$row->kendaraan_roda4 }}</td>
                                                <td class="text-center">{{ (int)$row->total_disetujui }}</td>
                                                <td class="text-center">{{ (int)$row->total_tolak }}</td>
                                                <td class="text-center">{{ (int)$row->total_pengembalian }}</td>
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
    </section>
</div>
@endsection


@push('scripts')

<script>
    $(document).ready(function() {
        // initDataTable('table-style-hover-kendaraan');
        // initDataTable('table-style-hover-ruangan');
    });
</script>

@endpush