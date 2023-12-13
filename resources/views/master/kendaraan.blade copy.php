@extends('layouts.main')

@section('container')

<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-lg mx-auto">
                    <div class="nk-block-head nk-block-head-lg wide-sm">
                        <div class="nk-block-head-content">
                            {{-- <div class="nk-block-head-sub"><a class="back-to" href="html/components.html"><em class="icon ni ni-arrow-left"></em><span>Components</span></a></div> --}}
                            <h2 class="nk-block-title fw-normal">Master Kendaraan</h2>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div class="preview-block">
                                    <span class="preview-title-lg overline-title">Data Peminjam</span>
                                    <div class="row gy-4">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="inputPeminjam">Peminjam</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-left">
                                                        <em class="icon ni ni-user"></em>
                                                    </div>
                                                    <input type="text" class="form-control" id="inputPeminjam" placeholder="Peminjam">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="inputDriver">Driver</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-left">
                                                        <em class="icon ni ni-account-setting"></em>
                                                    </div>
                                                    <input type="text" class="form-control" id="inputDriver" placeholder="Driver">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="inputKeperluan">Keperluan</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control no-resize" id="inputKeperluan"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="preview-hr">
                                    <span class="preview-title-lg overline-title">Data Kendaraan</span>
                                    <div class="row gy-4">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radioRoda2" name="jenisKendaraan" class="custom-control-input">    
                                                    <label class="custom-control-label" for="radioRoda2">Kendaraan Roda-2 | Motor</label>
                                                </div>
                                                &nbsp;&nbsp;
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radioRoda4" name="jenisKendaraan" class="custom-control-input">    
                                                    <label class="custom-control-label" for="radioRoda4">Kendaraan Roda-4 | Mobil</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="inputPeminjam">Mobil</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2">
                                                        <option value="R-1103-XB">Kijang Innova / R 1103 XB / Kepala Kantor</option>
                                                        <option value="R-1106-XB">Kijang Innova / R 1106 XB / Pemerintah Daerah </option>
                                                        <option value="R-1304-XB">Kijang Innova / R 1304 XB / Manual</option>
                                                        <option value="R-9058-XB">Larasita / R 9058 XB / Manual</option>
                                                        <option value="R-9058-XB">Kijang Innova / H 1189 UM / Kepala Kantor</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="inputDriver">Driver</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-left">
                                                        <em class="icon ni ni-account-setting"></em>
                                                    </div>
                                                    <input type="text" class="form-control" id="inputDriver" placeholder="Driver">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="preview-hr">
                                    <span class="preview-title-lg overline-title">Size Preview </span>
                                    <div class="row gy-4 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-lg" placeholder="Input Large">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" placeholder="Input Regular">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-sm" placeholder="Input Small">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p class="text-soft">Use <code>.form-control-lg</code> or <code>.form-control-sm</code> with <code>.form-control</code> for large or small input box.</p>
                                        </div>
                                    </div>
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