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
                                        $button  =  '<a href="#" onClick="editMasterRuangrapat('.$row->id.')" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><em class="icon ni ni-pen2"></em></a>';
                                        $button .= ' <a href="#" onClick="deleteMasterRuangrapat('.$row->id.')" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><em class="icon ni ni-trash"></em></a>';
                                        return $button;
                                    })->rawColumns(['action','status_pinjaman'])->make(true);

            return $DT_master_ruangrapat;
        }
    }

}
