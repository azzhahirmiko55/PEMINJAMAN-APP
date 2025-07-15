<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class KaryawanController extends Controller
{

    public static function page_master_karyawan()
    {
        if(Auth::check()){
            return view('master/karyawan', [
                'page'          => 'Master Karyawan',
                'js_script'     => '/js/master/karyawan.js'
            ]);
        } else {
            abort(404);
        }
    }

    public static function ajax_dt_master_karyawan(Request $request)
    {
        if ($request->ajax()) {
            $gt_master_karyawan = Karyawan::where('status','!=',0)->get();

            $DT_master_karyawan = Datatables::of($gt_master_karyawan)
                                    ->addIndexColumn()
                                    ->addColumn('action', function($row){
                                        $button  =  '<a href="#" onClick="editMasterKaryawan('.$row->id.')" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><em class="icon ni ni-pen2"></em></a>';
                                        $button .= ' <a href="#" onClick="deleteMasterKaryawan('.$row->id.')" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><em class="icon ni ni-trash"></em></a>';
                                        return $button;
                                    })->rawColumns(['action','status'])->make(true);

            return $DT_master_karyawan;
        }
    }

    public static function ajax_pcs_master_karyawan(Request $request)
    {
        if($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'karyawan'   => 'required',
                'jabatan'        => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            Karyawan::updateOrCreate(
                ['id'   => $request->id],
                [
                    'karyawan'         => $request->karyawan,
                    'jabatan'          => $request->jabatan
                ]
            );

            return response()->json(['success' => TRUE, 'message'  => 'Data master karyawan berhasil disimpan']);
        }
    }

    public function ajax_gt_master_karyawan(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id'   => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);


            $gt_master_karyawan = Karyawan::firstWhere('id', $request->id);

            return response()->json($gt_master_karyawan);
        }
    }

    public function ajax_del_master_karyawan(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id'   => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            Karyawan::where('id', $request->id)->update(['status' => 0]);

            return response()->json([
                'success'   => TRUE,
                'message'   => 'Data master karyawan berhasil dihapus'
            ]);
        }
    }

    public function ajax_select_karyawan(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'page'      => 'required',
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            $start = $request->page;
            $limit = 20;

            if($start <= 0){
                $start = 1;
            }

            $select_master_karyawan = Karyawan::select2_karyawan([
                'start'     => ceil($start - 1) * 20,
                'limit'     => $limit,
                'search'    => $request->search
            ]);

            $response = [
                'results'    => $select_master_karyawan['query'],
                'pagination' => [
                    'more'  => ($start * 20) < $select_master_karyawan['count']
                ]
            ];

            return response()->json($response);
        }
    }

}
