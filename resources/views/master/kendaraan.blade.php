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
                                    <span class="preview-title-lg overline-title">Form Kendaraan</span>
                                    <form action="#" method="post" id="formKendaraan" class="form-validate is-alter">
                                        <div class="row gy-4">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="inputPeminjam">Jenis Kendaraan</label>
                                                        <div class="form-control-wrap">
                                                            <ul class="custom-control-group">    
                                                                <li>       
                                                                    <div class="custom-control custom-control-sm custom-radio custom-control-pro">            
                                                                        <input type="radio" class="custom-control-input" name="jenis_kendaraan" id="radioRoda2" value="Roda 2" required>            
                                                                        <label class="custom-control-label" for="radioRoda2">Kendaraan Roda 2 | Motor</label>       
                                                                    </div>  
                                                                </li>   
                                                                <li>       
                                                                    <div class="custom-control custom-control-sm custom-radio custom-control-pro">            
                                                                        <input type="radio" class="custom-control-input" name="jenis_kendaraan" id="radioRoda4" value="Roda 4">            
                                                                        <label class="custom-control-label" for="radioRoda4">Kendaraan Roda 4 | Mobil</label>       
                                                                    </div>  
                                                                </li>   
                                                            </ul>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="inputPlatNomor">Plat Nomor</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-money"></em>
                                                        </div>
                                                        <input type="text" class="form-control" name="plat_nomor" id="inputPlatNomor" placeholder="Plat Nomor" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <label class="form-label" for="inputKeterangan">Keterangan</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-article"></em>
                                                        </div>
                                                        <input type="text" class="form-control" name="keterangan" id="inputKeterangan" placeholder="Keterangan" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-0"><hr class="preview-hr"></div>
                                            <div class="col-sm-12 mt-0">
                                                <div class="form-group float-end">
                                                    <div class="form-control-wrap">
                                                        <button type="submit" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Simpan Data</span> </button>
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