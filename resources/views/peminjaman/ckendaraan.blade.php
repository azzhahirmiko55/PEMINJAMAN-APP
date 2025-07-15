@extends('layouts.main')

@section('container')

    <!-- content @s -->
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Kalender Peminjaman Kendaraan</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <a href="#" onClick="showFormPeminjaman()" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Tambah Data Peminjamaan</span></a>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div id="calendar" class="nk-calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->

    <!-- Modal Add Event -->
    <div class="modal fade" id="modal-peminjaman">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Peminjam</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" id="form-peminjaman" method="POST" class="form-validate is-alter">
                        <input type="hidden" id="id-peminjaman" name="id">
                        <div class="row gx-4 gy-3">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="id-peminjam">Peminjam</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-users"></em>
                                        </div>
                                        <input type="text" name="peminjam" class="form-control" id="id-peminjam" placeholder="Peminjam" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id-driver" class="form-label">Driver</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-account-setting"></em>
                                        </div>
                                        <input type="text" name="driver" class="form-control" id="id-driver" placeholder="Peminjam" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="id-tanggal-peminjaman">Tanggal Peminjaman</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calendar"></em>
                                        </div>
                                        <input type="text" name="tanggal" id="id-tanggal-peminjaman" class="form-control" data-date-format="yyyy-mm-dd" value="{{ date('Y-m-d') }}" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label" for="id-jenis-kendaraan">Jenis Kendaraan</label>
                                    <ul class="custom-control-group g-2 align-center flex-wrap mt-0">
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input jen-ken" id="radioRoda2" name="jenis_kendaraan" value="Roda-2" required>
                                                <label for="radioRoda2" class="custom-control-label">Roda 2 | Motor</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input jen-ken" id="radioRoda4" name="jenis_kendaraan" value="Roda-4">
                                                <label for="radioRoda4" class="custom-control-label">Roda 4 | Mobil</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label" for="id-kendaraan">Kendaraan</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-money"></em>
                                        </div>
                                        <select name="kendaraan" id="id-kendaraan" class="form-control"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="id-keperluan">Keperluan</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-article"></em>
                                        </div>
                                        <textarea class="form-control" name="keperluan" id="id-keperluan" placeholder="Keperluan" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12"><hr></div>
                            <div class="col-12">
                                <ul class="d-flex justify-content-between gx-4 mt-1">
                                    <li>
                                        <button id="btn-simpan-peminjaman" type="submit" class="btn btn-primary"><em class="icon ni ni-save"></em><span>Simpan Data</span></button>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-dismiss="modal" class="btn btn-danger btn-dim">Tutup Form</a>
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

    <!-- Modal Preview Penjadwalan -->
    <div class="modal fade" id="modal-preview-peminjaman">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div id="preview-peminjaman-header" class="modal-header">
                    <h5 id="preview-peminjaman-title" class="modal-title">Placeholder Title</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id-peminjaman-preview">
                    <div class="row gy-3 py-1">
                        <div class="col-sm-12">
                            <h6 class="overline-title">Tanggal Peminjaman</h6>
                            <p id="preview-tanggal-peminjaman"></p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="overline-title">Peminjam</h6>
                            <p id="preview-pemakai" style="text-align: justify;"></p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="overline-title">Driver</h6>
                            <p id="preview-driver"></p>
                        </div>
                        <div class="col-sm-12">
                            <h6 class="overline-title">Keperluan</h6>
                            <p id="preview-keperluan"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Preview Penjadwalan -->

@endsection
