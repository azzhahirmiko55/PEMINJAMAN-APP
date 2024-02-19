<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\PeminjamanKendaraan;
use DataTables;

class PeminjamanKendaraanController extends Controller
{
    public function form_kendaraan()
    {
        return view('peminjaman/kendaraan', [
            'page'      => 'Form Peminjaman Kendaraan',
            'js_script' => 'js/peminjaman/kendaraan.js'
        ]);
    }

    public function calendar_kendaraan()
    {
        return view('peminjaman/ckendaraan', [
            'page'      => 'Kalender Peminjaman Kendaraan',
            'js_script' => 'js/peminjaman/ckendaraan.js'
        ]);
    }

    public function ajax_gt_calendar_kendaraan(Request $request)
    {

        // if($request->ajax()) {
        
            $arr_peminjaman = [];

                $gt_data_peminjaman = PeminjamanKendaraan::query_peminjaman_kendaraan();

                if(!empty($gt_data_peminjaman)){
                    foreach($gt_data_peminjaman as $row){

                        $arr_peminjaman[] = [
                            'id'        => $row->id,
                            'title'     => $row->plat.' - '.$row->peminjam,
                            'start'     => $row->tanggal.' 00:00:00',
                            'end'       => $row->tanggal.' 23:59:59',
                            'className' => $row->warna
                        ];

                    }
                }

            return $arr_peminjaman;

        // }

    }

    public function ajax_pcs_form_kendaraan(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'peminjam'      => 'required',
                'driver'        => 'required',
                'kendaraan'     => 'required',
                'tanggal'       => 'required',
                'keperluan'     => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            PeminjamanKendaraan::create([
                'id_user'       => 0,
                'peminjam'      => $request->peminjam,
                'driver'        => $request->driver,
                'id_kendaraan'  => $request->kendaraan,
                'tanggal'       => $request->tanggal,
                'keperluan'     => $request->keperluan
            ]);

            return response()->json([
                'success'   => TRUE,
                'message'   => 'Peminjaman kendaraan berhasil di proses'
            ]);
        }
    }

    public function ajax_cancel_form_kendaraan(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id' => 'required'
            ]);

            if($validator->fails()) {
                return response()->json(implode(',',$validator->errors()->all()), 422);
            }

            PeminjamanKendaraan::where('id', $request->id)->update(['status' => 0]);

            return response()->json([
                'success'   => TRUE,
                'message'   => 'Peminjaman kendaraan berhasil dibatalkan'
            ]);
        }
    }

    public function rekapitulasi_kendaraan()
    {
        return view('rekapitulasi/kendaraan', [
            'page'      => 'Rekapitulasi Peminjaman Kendaraan',
            'js_script' => 'js/rekapitulasi/kendaraan.js'
        ]);
    }

    public function ajax_dt_rekapitulasi_kendaraan(Request $request)
    {
        if ($request->ajax()) {
            $gt_tb_peminjaman_kendaraan = PeminjamanKendaraan::query_peminjaman_kendaraan();

            $DT_rekapitulasi_kendaraan = Datatables::of($gt_tb_peminjaman_kendaraan)
                                    ->addIndexColumn()
                                    ->addColumn('action', function($row){
                                        if($row->status == 1) {
                                            $button  =  '<a href="#" onClick="pembatalanPeminjaman('.$row->id.')" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Batal"><em class="icon ni ni-cross"></em></a>';
                                            return $button;
                                        } else if ($row->status == 0){
                                            return '<span class="badge rounded-pill bg-outline-danger">Dibatalkan</span>';
                                        }
                                    })->rawColumns(['action','status_pinjaman'])->make(true);

            return $DT_rekapitulasi_kendaraan;
        }
    }
}
