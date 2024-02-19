<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Ruangrapat;
use DataTables;

class RuangrapatController extends Controller
{

    public static function page_master_ruangrapat()
    {
        return view('master/ruangrapat', [
            'page'          => 'Master Ruang Rapat',
            'js_script'     => '/js/master/ruangrapat.js'
        ]);
    }

    public static function ajax_dt_master_ruangrapat(Request $request)
    {
        if ($request->ajax()) {
            $gt_master_ruangrapat = Ruangrapat::where('status','!=',0)->get();

            $DT_master_ruangrapat = Datatables::of($gt_master_ruangrapat)
                                    ->addIndexColumn()->addColumn('action', function($row){
                                        $button  =  '<a href="#" onClick="editMasterRuangRapat('.$row->id.')" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><em class="icon ni ni-pen2"></em></a>';
                                        $button .= ' <a href="#" onClick="deleteMasterRuangRapat('.$row->id.')" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><em class="icon ni ni-trash"></em></a>';
                                        return $button;
                                    })->rawColumns(['action','status_pinjaman'])->make(true);

            return $DT_master_ruangrapat;
        }
    }

    public static function ajax_pcs_master_ruangrapat(Request $request)
    {
        if($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'ruangan'   => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            Ruangrapat::updateOrCreate(
                ['id'   => $request->id],
                [
                    'ruangan' => $request->ruangan
                ]
            );

            return response()->json(['success' => TRUE, 'message'  => 'Data master kendaraan berhasil disimpan']);
        }
    }

    public function ajax_gt_master_ruangrapat(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id'   => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);
            
            $gt_master_ruangarapat = Ruangrapat::firstWhere('id', $request->id);

            return response()->json($gt_master_ruangarapat);
        }
    }

}
