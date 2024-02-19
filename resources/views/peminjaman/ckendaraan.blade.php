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
                                <a href="#" onClick="showFormPeminjaman()" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Tambah Data Peminjaman</span></a>
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
                    <h5 class="modal-title">Tambah Penjadwalan</h5>
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
                                        <input type="text" name="title" class="form-control" id="id-peminjam" placeholder="Peminjam" required>
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
                                        <input type="text" name="title" class="form-control" id="id-driver" placeholder="Peminjam" required>
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
                                        <input type="text" name="tanggal_peminjaman" id="id-tanggal-peminjaman" class="form-control" data-date-format="yyyy-mm-dd" value="{{ date('Y-m-d') }}" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label" for="id-jenis-kendaraan">Jenis Kendaraan</label>
                                    <ul class="custom-control-group g-2 align-center flex-wrap mt-0">
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="radioRoda2" name="jenis_kendaraan" value="Roda-2" required>
                                                <label for="radioRoda2" class="custom-control-label">Roda 2 | Motor</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="radioRoda4" name="jenis_kendaraan" value="Roda-4">
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
                                        <button id="btnAddEvent" type="submit" class="btn btn-primary"><em class="icon ni ni-save"></em><span>Simpan Data</span></button>
                                    </li>
                                    <li>
                                        <button onclick="hideModalPenjadwalan()" type="buttton" class="btn btn-danger btn-dim">Tutup Form</button>
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
                <div id="preview-event-header" class="modal-header">
                    <h5 id="preview-event-title" class="modal-title">Placeholder Title</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id-peminjaman-preview">
                    <div class="row gy-3 py-1">
                        <div class="col-sm-6">
                            <h6 class="overline-title">Tanggal Mulai</h6>
                            <p id="preview-event-start"></p>
                        </div>
                        <div class="col-sm-6" id="preview-event-end-check">
                            <h6 class="overline-title">Tanggal Selesai</h6>
                            <p id="preview-event-end"></p>
                        </div>
                        <div class="col-sm-12" id="preview-event-description-check">
                            <h6 class="overline-title">Deskripsi</h6>
                            <p id="preview-event-description" style="text-align: justify;"></p>
                        </div>
                        <div class="col-sm-12" id="preview-event-room-check">
                            <h6 class="overline-title">Ruangan</h6>
                            <p id="preview-event-room"></p>
                        </div>
                    </div>
                    <ul class="d-flex justify-content-between gx-4 mt-3">
                        <li>
                            <button type="button" onclick="editPeminjaman()" class="btn btn-primary">Ubah Data Peminjaman</button>
                        </li>
                        <li>
                            <button type="button" onclick="deletePeminjaman()" class="btn btn-danger btn-dim">Hapus Data Peminjaman</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Preview Penjadwalan -->

@endsection