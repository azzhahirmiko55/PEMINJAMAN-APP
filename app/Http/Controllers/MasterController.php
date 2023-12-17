<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Master;
use DataTables;

class MasterController extends Controller
{

    public function master_kendaraan()
    {
        return view('master/kendaraan', [
            'page'          => 'Master Kendaraan',
            'js_script'     => '/js/master.js'
        ]);
    }

    public function ajax_dt_master_kendaraan(Request $request)
    {
        if ($request->ajax()) {
            $gt_master_kendaraan = Master::gt_ms_kendaraan();

            $DT_master_kendaraan = Datatables::of($gt_master_kendaraan)
                                    ->addIndexColumn()
                                    ->addColumn('action', function($row){
                                        $button = '<a href="javascript:void(0)" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><em class="icon ni ni-pen2"></em></a>';
                                        $button .= ' <a href="javascript:void(0)" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><em class="icon ni ni-trash"></em></a>';
                                        return $button;
                                    })->rawColumns(['action'])->make(true);

            return $DT_master_kendaraan;
        }
    }

    public function ajax_proses_master_kendaraan(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'jenis_kendaraan'   => 'required',
            'plat_nomor'        => 'required',
            'keterangan'        => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(implode(',',$validator->errors()->all()), 422);
        }

        Master::prosesInputKendaraan([
            'jenis_kendaraan'   => $request->jenis_kendaraan,
            'plat_nomor'        => $request->plat_nomor,
            'keterangan'        => $request->keterangan
        ]);

        return response()->json([
            'success'   => TRUE,
            'message'   => 'Data master kendaraan berhasil disimpan'
        ]);

    }

}
