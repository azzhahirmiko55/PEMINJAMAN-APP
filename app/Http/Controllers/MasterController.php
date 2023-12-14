<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Master;

class MasterController extends Controller
{

    public function master_kendaraan()
    {
        return view('master/kendaraan', [
            'page'          => 'Master Kendaraan',
            'js_script'     => '/js/master.js'
        ]);
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
