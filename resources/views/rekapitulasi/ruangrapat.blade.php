@extends('layouts.main')

@section('container')

    <!-- content @s -->
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-lg mx-auto">

                        <div class="nk-block nk-block-lg">

                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h4 class="nk-block-title">Rekapitulasi Peminjaman Ruang Rapat</h4>
                                            <div class="nk-block-des">
                                                <p>Rekapitulasi peminjaman ruang rapat kantor pertanahan kabupaten cilacap</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mx-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <table class="table display nowrap" id="tableRekapitulasiRuangrapat" style="width:100%;">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Ruangan</th>
                                                <th>Peminjam</th>
                                                <th>Tanggal</th>
                                                <th>Jam</th>
                                                <th>Keperluan</th>
                                                <th>#</th>
                                            </tr>
                                            <tbody></tbody>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content @s -->

@endsection