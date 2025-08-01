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
                                            <h4 class="nk-block-title">Master Ruang Rapat</h4>
                                            <div class="nk-block-des">
                                                <p>Data Ruang Rapat Kantor Pertanahan Kabupaten Cilacap</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mx-auto">
                                            <a href="#" onClick="showMasterRuangRapat()" class="btn btn-outline-primary float-end"><em class="icon ni ni-plus"></em><span>Tambah Data Ruang Rapat</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <table class="table display nowrap" id="tableRuangRapat" style="width:100%;">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Ruangan</th>
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

    <!-- Modal Add Event -->
    <div class="modal fade" id="modalMasterRuangRapat">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Ruang Rapat</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" id="formRuangRapat" method="POST" class="form-validate is-alter">
                        <input type="hidden" id="idRuangRapat" name="id" value="">
                        <div class="row gx-4 gy-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="inputPlatNomor">Ruangan</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-money"></em>
                                        </div>
                                        <input type="text" class="form-control" name="ruangan" id="inputRuangan" placeholder="Ruangan" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="event-room">Warna Tampilan</label>
                                    <ul class="custom-control-group g-2 align-center flex-wrap mt-0">
                                        <li>
                                            <div class="custom-control custom-radio custom-control-sm">
                                                <input type="radio" class="custom-control-input warna-checkbox" id="radioWarnaUngu" name="warna_tampilan" value="fc-event-primary-dim" required>
                                                <label for="radioWarnaUngu" class="custom-control-label"><span class="badge badge-dim rounded-pill bg-primary">Ungu</span></label>
                                            </div>
                                        </li>
                                        |
                                        <li>
                                            <div class="custom-control custom-radio custom-control-sm">
                                                <input type="radio" class="custom-control-input warna-checkbox" id="radioWarnaHijau" name="warna_tampilan" value="fc-event-success-dim">
                                                <label for="radioWarnaHijau" class="custom-control-label"><span class="badge badge-dim rounded-pill bg-success">Hijau</span></label>
                                            </div>
                                        </li>
                                        |
                                        <li>
                                            <div class="custom-control custom-radio custom-control-sm">
                                                <input type="radio" class="custom-control-input warna-checkbox" id="radioWarnaJingga" name="warna_tampilan" value="fc-event-warning-dim">
                                                <label for="radioWarnaJingga" class="custom-control-label"><span class="badge badge-dim rounded-pill bg-warning">Jingga</span></label>
                                            </div>
                                        </li>
                                        |
                                        <li>
                                            <div class="custom-control custom-radio custom-control-sm">
                                                <input type="radio" class="custom-control-input warna-checkbox" id="radioWarnaMerah" name="warna_tampilan" value="fc-event-danger-dim">
                                                <label for="radioWarnaMerah" class="custom-control-label"><span class="badge badge-dim rounded-pill bg-danger">Merah</span></label>
                                            </div>
                                        </li>
                                        |
                                        <li>
                                            <div class="custom-control custom-radio custom-control-sm">
                                                <input type="radio" class="custom-control-input warna-checkbox" id="radioWarnaBiru" name="warna_tampilan" value="fc-event-info-dim">
                                                <label for="radioWarnaBiru" class="custom-control-label"><span class="badge badge-dim rounded-pill bg-info">Biru</span></label>
                                            </div>
                                        </li>
                                        |
                                        <li>
                                            <div class="custom-control custom-radio custom-control-sm">
                                                <input type="radio" class="custom-control-input warna-checkbox" id="radioWarnaAbu" name="warna_tampilan" value="fc-event-dark-dim">
                                                <label for="radioWarnaAbu" class="custom-control-label"><span class="badge badge-dim rounded-pill bg-dark">Abu-Abu</span></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12"><hr></div>
                            <div class="col-12">
                                <ul class="d-flex justify-content-between gx-4 mt-1">
                                    <li>
                                        <button type="submit" class="btn btn-primary"><em class="icon ni ni-save"></em><span>Simpan Data</span></button>
                                    </li>
                                    <li>
                                        <button type="button" onClick="hideMasterRuangRapat()" class="btn btn-danger btn-dim">Close</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Add Event -->

@endsection
