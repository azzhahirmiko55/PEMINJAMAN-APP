@extends('layouts.main')

@section('container')

    <!-- content @s -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-lg mx-auto">

                        <div class="nk-block nk-block-lg">

                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <h4 class="nk-block-title">Form peminjaman kendaraan</h4>
                                            <div class="nk-block-des">
                                                <p>Form peminjaman kendaraan kantor pertanahan kabupaten cilacap</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <div class="preview-block">

                                        <form action="#" method="post" id="formKendaraan" class="form-validate is-alter">

                                            <span class="preview-title-lg overline-title">Data Peminjam</span>
                                            <div class="row gy-4">

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="inputPlatNomor">Peminjam</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-users"></em>
                                                            </div>
                                                            {{-- <input type="text" class="form-control" name="peminjam" id="inputPeminjamr" placeholder="Peminjam" required> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="inputPlatNomor">Driver</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-account-setting"></em>
                                                            </div>
                                                            <input type="text" class="form-control" name="driver" id="inputDriver" placeholder="Driver" required>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr class="preview-hr">

                                            <div class="row gy-4">

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="inputPlatNomor">Tanggal Pinjam</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-calender-date"></em>
                                                            </div>
                                                            <input type="text" class="form-control" name="tanggal" id="inputTanggal" placeholder="Tanggal Pinjam" value="{{ date('Y-m-d') }}" readonly required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="inpuJenisKendaraan">Jenis Kendaraan</label>
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
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="inputPlatNomor">Kendaraan</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-money"></em>
                                                            </div>
                                                            <select name="kendaraan" id="inputKendaraan" class="form-control"></select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="inputKeterangan">Keperluan</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-article"></em>
                                                            </div>
                                                            <textarea type="text" class="form-control no-resize" name="keperluan" id="inputKeterangan" placeholder="Keterangan" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-0"><hr class="preview-hr"></div>
                                                <div class="col-sm-12 mt-0">
                                                    <div class="form-group float-end">
                                                        <div class="form-control-wrap">
                                                            <button type="submit" class="btn btn-primary" id="btnProsesPeminjaman"><em class="icon ni ni-save"></em><span>Proses Peminjaman</span> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- .card-preview -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content @s -->

@endsection
