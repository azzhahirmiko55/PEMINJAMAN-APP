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
                                            <h4 class="nk-block-title">Master Karyawan</h4>
                                            <div class="nk-block-des">
                                                <p>Data Karyawan Kantor Pertanahan Kabupaten Cilacap</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mx-auto">
                                            <a href="#" onClick="showMasterKaryawan()" class="btn btn-outline-primary float-end"><em class="icon ni ni-plus"></em><span>Tambah Data Karyawan</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <table class="table display nowrap" id="tableKaryawan" style="width:100%;">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Karyawan</th>
                                                <th>Status</th>
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
    <div class="modal fade" id="modalMasterKaryawan">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Karyawan</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" id="formKaryawan" method="POST" class="form-validate is-alter">
                        <input type="hidden" id="idKaryawan" name="id" value="">
                        <div class="row gx-4 gy-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="inputKaryawan">Karyawan</label>
                                    <div class="form-control-wrap">
                                        {{-- <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-article"></em>
                                        </div> --}}
                                        <input type="text" name="karyawan" id="inputKaryawan" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="inputJabatan">Jabatan</label>
                                    <div class="form-control-wrap">
                                        {{-- <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-article"></em>
                                        </div> --}}
                                        <input type="text" name="jabatan" id="inputJabatan" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12"><hr></div>
                            <div class="col-12">
                                <ul class="d-flex justify-content-between gx-4 mt-1">
                                    <li>
                                        <button type="submit" class="btn btn-primary"><em class="icon ni ni-save"></em><span>Simpan Data</span></button>
                                    </li>
                                    <li>
                                        <button type="button" onClick="hideMasterKaryawan()" class="btn btn-danger btn-dim">Close</button>
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
