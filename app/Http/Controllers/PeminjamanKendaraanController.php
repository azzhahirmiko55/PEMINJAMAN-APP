<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\PeminjamanKendaraan;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class PeminjamanKendaraanController extends Controller
{
    // public function form_kendaraan()
    // {
    //     return view('peminjaman/kendaraan', [
    //         'page'      => 'Form Peminjaman Kendaraan',
    //         'js_script' => 'js/peminjaman/kendaraan.js'
    //     ]);
    // }

    public function calendar_kendaraan()
    {
        if(Auth::check()){
            return view('peminjaman/auth/ckendaraan', [
                'page'      => 'Kalender Peminjaman Kendaraan',
                'js_script' => 'js/peminjaman/auth/ckendaraan.js'
            ]);
        } else {
             return view('peminjaman/ckendaraan', [
                'page'      => 'Kalender Peminjaman Kendaraan',
                'js_script' => 'js/peminjaman/ckendaraan.js'
            ]);
        }
    }

    public function ajax_gt_calendar_kendaraan(Request $request)
    {

        // if($request->ajax()) {
        
            $arr_peminjaman = [];

                $gt_data_peminjaman = PeminjamanKendaraan::query_peminjaman_kendaraan()->get();

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

    public function convert_nama_bulan($bulan = 0)
    {
        $text = '';
        
        if(!empty($bulan)){
            if($bulan == '1'){
                $text = 'Januari';
            } else if($bulan == '2'){
                $text = 'Februari';
            } else if($bulan == '3'){
                $text = 'Maret';
            } else if($bulan == '4'){
                $text = 'April';
            } else if($bulan == '5'){
                $text = 'Mei';
            } else if($bulan == '6'){
                $text = 'Juni';
            } else if($bulan == '7'){
                $text = 'Juli';
            } else if($bulan == '8'){
                $text = 'Agustus';
            } else if($bulan == '9'){
                $text = 'September';
            } else if($bulan == '10'){
                $text = 'Oktober';
            } else if($bulan == '11'){
                $text = 'November';
            } else if($bulan == '12'){
                $text = 'Desember';
            }
        }

        return $text;
    }

    public function ajax_gt_peminjaman_kendaraan(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id'   => 'required'
            ]);

            if($validator->fails()) {
                return response()->json(implode(',',$validator->errors()->all()), 422);
            }
            
            $gt_peminjaman_kendaraan = PeminjamanKendaraan::query_peminjaman_kendaraan($request->id)->first();

            $arr_peminjaman_kendaraan = [];

            if(!empty($gt_peminjaman_kendaraan))
            {
                $dt_peminjaman_kendaraan = [
                    'id'        => $gt_peminjaman_kendaraan->id,
                    'id_kendaraan'  => $gt_peminjaman_kendaraan->id_kendaraan,
                    'peminjam'  => $gt_peminjaman_kendaraan->peminjam,
                    'driver'    => $gt_peminjaman_kendaraan->driver,
                    'tanggal'   => $gt_peminjaman_kendaraan->tanggal,
                    'warna'     => $gt_peminjaman_kendaraan->warna,
                    'jenis'     => $gt_peminjaman_kendaraan->jenis,
                    'plat'      => $gt_peminjaman_kendaraan->plat,
                    'keterangan'=> $gt_peminjaman_kendaraan->keterangan,
                    'keperluan' => $gt_peminjaman_kendaraan->keperluan,
                    'ket_kendaraan'     => $gt_peminjaman_kendaraan->keterangan.' ( '.$gt_peminjaman_kendaraan->plat.' )',
                    'convert_tanggal'   => date("d", strtotime($gt_peminjaman_kendaraan->tanggal)).' '.$this->convert_nama_bulan(date("m", strtotime($gt_peminjaman_kendaraan->tanggal))).' '.date("Y", strtotime($gt_peminjaman_kendaraan->tanggal))
                ];
            }

            return response()->json($dt_peminjaman_kendaraan);

        }
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

            PeminjamanKendaraan::updateOrCreate(
            [
                'id'            => $request->id
            ],
            [
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

    public function ajax_process_pindah_kendaraan(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id' => 'required'
            ]);

            if($validator->fails()) {
                return response()->json(implode(',',$validator->errors()->all()), 422);
            }

            $check = PeminjamanKendaraan::process_pindah_jadwal([
                'id'            => $request->id,
                'days'          => $request->days 
            ]);

            return response()->json([
                'success'   => $check['status'],
                'message'   => $check['message']
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
            $gt_tb_peminjaman_kendaraan = PeminjamanKendaraan::query_peminjaman_kendaraan(0,1)->get();

            $DT_rekapitulasi_kendaraan = Datatables::of($gt_tb_peminjaman_kendaraan)
                                    ->addIndexColumn()
                                    ->addColumn('action', function($row){
                                        if($row->status == 1) {
                                            if(Auth::check()){
                                                $button  =  '<a href="#" onClick="pembatalanPeminjaman('.$row->id.')" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Batal"><em class="icon ni ni-cross"></em></a>';
                                            } else {
                                                $button = '<span class="badge rounded-pill bg-outline-success">Aktif</span>';
                                            }
                                            return $button;
                                        } else if ($row->status == 0){
                                            return '<span class="badge rounded-pill bg-outline-danger">Dibatalkan</span>';
                                        }
                                    })->rawColumns(['action','status_pinjaman'])->make(true);

            return $DT_rekapitulasi_kendaraan;
        }
    }
}
