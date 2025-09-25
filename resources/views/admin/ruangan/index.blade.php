@extends('layouts.app')

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Data Ruangan</h5>
            <a class="btn btn-primary btn-sm text-white d-inline-flex align-items-center" href="#!" data-modal
                data-title="Tambah Data" data-url="{{ url('/ruangan/add') }}">
                <i class="ti ti-plus me-1"></i>Tambah Data
            </a>
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
                                            <th data-dt-column="0" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                aria-sort="ascending" aria-label="Name: Activate to invert sorting"
                                                tabindex="0"><span class="dt-column-title" role="button">No.</span><span
                                                    class="dt-column-order"></span>
                                            </th>
                                            <th data-dt-column="1" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                aria-sort="ascending" aria-label="Name: Activate to invert sorting"
                                                tabindex="0"><span class="dt-column-title" role="button">Nama
                                                    Ruangan</span><span class="dt-column-order"></span>
                                            </th>
                                            <th data-dt-column="2" rowspan="1" colspan="1"
                                                class="dt-orderable-asc dt-orderable-desc"
                                                aria-label="Position: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Warna Ruangan</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="3" rowspan="1" colspan="1"
                                                class="dt-type-numeric dt-orderable-asc dt-orderable-desc"
                                                aria-label="Age: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Aktif?</span><span
                                                    class="dt-column-order"></span></th>
                                            <th data-dt-column="4" rowspan="1" colspan="1"
                                                class="dt-type-date dt-orderable-asc dt-orderable-desc"
                                                aria-label="Start date: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Aksi</span><span
                                                    class="dt-column-order"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp

                                        @foreach ($data_ruangan as $item)
                                        <tr>

                                            <td>{{ $i }}.</td>
                                            <td class="sorting_1">{{ $item->nama_ruangan }}</td>
                                            <td>{{ $item->warna_ruangan }}</td>
                                            <td>
                                                @if ($item->active_st == 1)
                                                <span class="badge rounded-pill text-bg-success">
                                                    <i class="ti ti-check"></i>
                                                </span>
                                                @else
                                                <span class="badge rounded-pill text-bg-danger">
                                                    <i class="ti ti-x"></i>
                                                </span>
                                                @endif
                                            </td>
                                            <td class="dt-type-numeric">
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop1" type="button"
                                                        class="btn btn-outline-info dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fas fa-hand-pointer"></i> Aksi
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item" href="#!" data-modal
                                                            data-title="Edit Ruangan"
                                                            data-url="{{ url('/ruangan/'.$item->id_ruangrapat) }}">
                                                            <svg class="pc-icon text-primary">
                                                                <use xlink:href="#edit"></use>
                                                            </svg> Ubah
                                                        </a>
                                                        <a class="dropdown-item btnToggleStatus" href="#!"
                                                            data-url="{{ route('ruangan.status') }}"
                                                            data-id="{{ $item->id_ruangrapat }}"
                                                            data-status="{{ $item->active_st }}">
                                                            @if($item->active_st == 0)
                                                            <svg class="pc-icon text-success">
                                                                <use xlink:href="#check"></use>
                                                            </svg> Aktif
                                                            @elseif($item->active_st == 1)
                                                            <svg class="pc-icon text-danger">
                                                                <use xlink:href="#x"></use>
                                                            </svg>Non Aktif
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
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
</div>
@endsection


@push('scripts')

<script>
    $(document).ready(function () {
        initDataTable('table-style-hover');
    });
</script>

@endpush
