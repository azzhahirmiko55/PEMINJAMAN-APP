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
                                            <h4 class="nk-block-title">Rekapitulasi Peminjaman Kendaraan</h4>
                                            <div class="nk-block-des">
                                                <p>Rekapitulasi kendaraan kantor pertanahan kabupaten cilacap</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mx-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <table class="table display nowrap" id="tableRekapitulasiKendaraan" style="width:100%;">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Jenis Kendaraan</th>
                                                <th>Kendaraan</th>
                                                <th>Peminjam</th>
                                                <th>Driver</th>
                                                <th>Tanggal</th>
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

    <!-- Modal Add Event -->
    <div class="modal fade" id="modalMasterKendaraan">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Kendaraan</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" id="formKendaraan" method="POST" class="form-validate is-alter">
                        <input type="hidden" id="idKendaraan" name="id" value="">
                        <div class="row gx-4 gy-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="inputJenisKendaraan">Jenis Kendaraan</label>
                                        <div class="form-control-wrap">
                                            <ul class="custom-control-group">    
                                                <li>       
                                                    <div class="custom-control custom-control-sm custom-radio custom-control-pro">            
                                                        <input type="radio" class="custom-control-input" name="jenis_kendaraan" id="radioRoda2" value="Roda-2" required>            
                                                        <label class="custom-control-label" for="radioRoda2">Kendaraan Roda 2 | Motor</label>       
                                                    </div>  
                                                </li>   
                                                <li>       
                                                    <div class="custom-control custom-control-sm custom-radio custom-control-pro">            
                                                        <input type="radio" class="custom-control-input" name="jenis_kendaraan" id="radioRoda4" value="Roda-4">            
                                                        <label class="custom-control-label" for="radioRoda4">Kendaraan Roda 4 | Mobil</label>       
                                                    </div>  
                                                </li>   
                                            </ul>
                                        </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
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
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="form-label" for="inputPeminjam">Status Pinjaman</label>
                                    <ul class="custom-control-group g-2 align-center flex-wrap mt-0">
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="statusPinjam1" name="status" value="1">
                                                <label for="statusPinjam1" class="custom-control-label">Bisa Dipinjam</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="statusPinjam5" name="status" value="5">
                                                <label for="statusPinjam5" class="custom-control-label">Tidak Bisa Dipinjam</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="inputKeterangan">Keterangan</label>
                                    <div class="form-control-wrap">
                                        {{-- <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-article"></em>
                                        </div> --}}
                                        <textarea name="keterangan" id="inputKeterangan" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="d-flex justify-content-between gx-4 mt-1">
                                    <li>
                                        <button type="submit" class="btn btn-primary"><em class="icon ni ni-save"></em><span>Simpan Data</span></button>
                                    </li>
                                    <li>
                                        <button type="button" onClick="hideMasterKendaraan()" class="btn btn-danger btn-dim">Discard</button>
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