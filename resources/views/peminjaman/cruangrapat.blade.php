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
                                <h3 class="nk-block-title page-title">Kalender Peminjaman Ruang Rapat</h3>
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
                    <h5 class="modal-title">Tambah Peminjaman</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" id="form-peminjaman" method="POST" class="form-validate is-alter">
                        <input type="hidden" id="id-peminjaman" name="id">
                        <div class="row gx-4 gy-3">
                            <div class="col-sm-8">
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
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="id-peminjam">Jumlah Peserta</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-users"></em>
                                        </div>
                                        <input type="number" name="jumlah_peserta" class="form-control" id="id-jumlah-peserta" placeholder="Jumlah Peserta" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
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

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Jam Mulai & Selesai</label>
                                    <div class="row gx-2">
                                        <div class="w-50">
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-left">
                                                    <em class="icon ni ni-clock"></em>
                                                </div>
                                                <input type="text" name="start_time" id="event-start-time" data-time-format="HH:mm" class="form-control" required readonly>
                                            </div>
                                        </div>
                                        <div class="w-50">
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-left">
                                                    <em class="icon ni ni-clock"></em>
                                                </div>
                                                <input type="text" name="end_time" id="event-end-time" data-time-format="HH:mm" class="form-control" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="id-kendaraan">Ruangan</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-money"></em>
                                        </div>
                                        <select name="ruangrapat" id="id-ruangrapat" class="form-control"></select>
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
                        <div class="col-sm-4">
                            <h6 class="overline-title">Tanggal Peminjaman</h6>
                            <p id="preview-tanggal-peminjaman"></p>
                        </div>
                        <div class="col-sm-4">
                            <h6 class="overline-title">Jam Mulai</h6>
                            <p id="preview-jam-mulai"></p>
                        </div>
                        <div class="col-sm-4">
                            <h6 class="overline-title">Jam Selesai</h6>
                            <p id="preview-jam-selesai"></p>
                        </div>
                        <div class="col-sm-4">
                            <h6 class="overline-title">Peminjam</h6>
                            <p id="preview-peminjam" style="text-align: justify;"></p>
                        </div>
                        <div class="col-sm-8">
                            <h6 class="overline-title">Jumlah Peserta</h6>
                            <p id="preview-jumlah"></p>
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