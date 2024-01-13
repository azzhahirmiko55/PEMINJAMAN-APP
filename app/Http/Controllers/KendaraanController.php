<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Kendaraan;
use DataTables;

class KendaraanController extends Controller
{

    public static function page_master_kendaraan()
    {
        return view('master/kendaraan', [
            'page'          => 'Master Kendaraan',
            'js_script'     => '/js/master/kendaraan.js'
        ]);
    }

    public static function ajax_dt_master_kendaraan(Request $request)
    {
        if ($request->ajax()) {
            $gt_master_kendaraan = Kendaraan::where('status','!=',0)->get();

            $DT_master_kendaraan = Datatables::of($gt_master_kendaraan)
                                    ->addIndexColumn()
                                    ->addColumn('status_pinjaman', function($row){
                                        $status_pinjaman = '';
                                        if($row->status === 1){
                                            $status_pinjaman = '<span class="badge rounded-pill bg-outline-info">Bisa Dipinjam</span>';
                                        } else if ($row->status ===5){
                                            $status_pinjaman = '<span class="badge rounded-pill bg-outline-danger">Tidak bisa dipinjam</span>';
                                        }
                                        return $status_pinjaman;
                                    })
                                    ->addColumn('action', function($row){
                                        $button  =  '<a href="#" onClick="editMasterKendaraan('.$row->id.')" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><em class="icon ni ni-pen2"></em></a>';
                                        $button .= ' <a href="#" onClick="deleteMasterKendaraan('.$row->id.')" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><em class="icon ni ni-trash"></em></a>';
                                        return $button;
                                    })->rawColumns(['action','status_pinjaman'])->make(true);

            return $DT_master_kendaraan;
        }
    }

    public static function ajax_pcs_master_kendaraan(Request $request)
    {
        if($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'jenis_kendaraan'   => 'required',
                'plat_nomor'        => 'required',
                'keterangan'        => 'required',
                'status'            => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            Kendaraan::updateOrCreate(
                ['id'   => $request->id],
                [
                    'jenis'         => $request->jenis_kendaraan,
                    'plat'          => $request->plat_nomor,
                    'keterangan'    => $request->keterangan,
                    'status'        => $request->status
                ]
            );

            return response()->json(['success' => TRUE, 'message'  => 'Data master kendaraan berhasil disimpan']);
        }
    }

    public function ajax_gt_master_kendaraan(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id'   => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);
            
            
            $gt_master_kendaraan = Kendaraan::firstWhere('id', $request->id);

            return response()->json($gt_master_kendaraan);
        }
    }

    public function ajax_del_master_kendaraan(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id'   => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            Kendaraan::where('id', $request->id)->update(['status' => 0]);

            return response()->json([
                'success'   => TRUE,
                'message'   => 'Data master kendaraan berhasil dihapus'
            ]);
        }
    }

    public function ajax_select_kendaraan(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'page'   => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            $start = $request->page;
            $limit = 20;

            if($start <= 0){
                $start = 1;
            }

            $select_master_kendaraan = Kendaraan::select2_kendaraan([
                'start'     => ceil($start - 1) * 20,
                'limit'     => $limit,
                'search'    => $request->search,
                'jenis_kendaraan'   => $request->jenis_kendaraan
            ]);

            $response = [
                'results'    => $select_master_kendaraan['query'],
                'pagination' => [
                    'more'  => ($start * 20) < $select_master_kendaraan['count']
                ]
            ];

            return response()->json($response);
        }
    }

}
