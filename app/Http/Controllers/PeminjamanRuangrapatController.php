<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\PeminjamanRuangrapat;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class PeminjamanRuangrapatController extends Controller
{
    
    public function calendar_ruangrapat()
    {
        return view('peminjaman/cruangrapat', [
            'page'      => 'Kalender Peminjaman Ruang Rapat',
            'js_script' => 'js/peminjaman/cruangrapat.js'
        ]);
    }

    public function ajax_gt_calendar_ruangrapat(Request $request)
    {

        // if($request->ajax()) {
        
            $arr_peminjaman = [];

                $gt_data_peminjaman = PeminjamanRuangrapat::query_peminjaman_ruangrapat()->get();

                if(!empty($gt_data_peminjaman)){
                    foreach($gt_data_peminjaman as $row){

                        $arr_peminjaman[] = [
                            'id'        => $row->id,
                            'title'     => $row->ruangan,
                            'start'     => $row->tanggal.' '.$row->jam_mulai,
                            'end'       => $row->tanggal.' '.$row->jam_selesai,
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

    public function ajax_gt_peminjaman_ruangrapat(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id'   => 'required'
            ]);

            if($validator->fails()) {
                return response()->json(implode(',',$validator->errors()->all()), 422);
            }
            
            $gt_peminjaman_ruangrapat = PeminjamanRuangrapat::query_peminjaman_ruangrapat($request->id)->first();

            $arr_peminjaman_ruangrapat = [];

            if(!empty($gt_peminjaman_ruangrapat))
            {
                $dt_peminjaman_ruangrapat = [
                    'id'            => $gt_peminjaman_ruangrapat->id,
                    'id_ruangrapat' => $gt_peminjaman_ruangrapat->id_ruangrapat,
                    'peminjam'      => $gt_peminjaman_ruangrapat->peminjam,
                    'tanggal'       => $gt_peminjaman_ruangrapat->tanggal,
                    'jam_mulai'     => $gt_peminjaman_ruangrapat->jam_mulai,
                    'jam_selesai'   => $gt_peminjaman_ruangrapat->jam_selesai,
                    'warna'         => $gt_peminjaman_ruangrapat->warna,
                    'ruangan'       => $gt_peminjaman_ruangrapat->ruangan,
                    'jumlah_peserta'=> $gt_peminjaman_ruangrapat->jumlah_peserta,
                    'keperluan'     => $gt_peminjaman_ruangrapat->keperluan,
                    'convert_tanggal'   => date("d", strtotime($gt_peminjaman_ruangrapat->tanggal)).' '.$this->convert_nama_bulan(date("m", strtotime($gt_peminjaman_ruangrapat->tanggal))).' '.date("Y", strtotime($gt_peminjaman_ruangrapat->tanggal))
                ];
            }

            return response()->json($dt_peminjaman_ruangrapat);

        }
    }

    public function ajax_pcs_form_ruangrapat(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'peminjam'      => 'required',
                'jumlah_peserta'=> 'required',
                'tanggal'       => 'required',
                'start_time'    => 'required',
                'end_time'      => 'required',
                'ruangrapat'    => 'required',
                'keperluan'     => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            PeminjamanRuangrapat::updateOrCreate(
            [
                'id'            => $request->id
            ],
            [
                'id_user'           => 0,
                'peminjam'          => $request->peminjam,
                'jumlah_peserta'    => $request->jumlah_peserta,
                'tanggal'           => $request->tanggal,
                'jam_mulai'         => $request->start_time,
                'jam_selesai'       => $request->end_time,
                'id_ruangrapat'     => $request->ruangrapat,
                'keperluan'         => $request->keperluan
            ]);

            return response()->json([
                'success'   => TRUE,
                'message'   => 'Peminjaman ruangrapat berhasil di proses'
            ]);
        }
    }

    public function rekapitulasi_ruangrapat()
    {
        return view('rekapitulasi/ruangrapat', [
            'page'      => 'Rekapitulasi Peminjaman Ruang Rapat',
            'js_script' => 'js/rekapitulasi/ruangrapat.js'
        ]);
    }

    public function ajax_dt_rekapitulasi_ruangrapat(Request $request)
    {
        if ($request->ajax()) {
            $gt_tb_peminjaman_ruangrapat = PeminjamanRuangrapat::query_peminjaman_ruangrapat(0,1)->get();

            $DT_rekapitulasi_ruangrapat = Datatables::of($gt_tb_peminjaman_ruangrapat)
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

            return $DT_rekapitulasi_ruangrapat;
        }
    }

    public function ajax_cancel_form_ruangrapat(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id' => 'required'
            ]);

            if($validator->fails()) {
                return response()->json(implode(',',$validator->errors()->all()), 422);
            }

            PeminjamanRuangrapat::where('id', $request->id)->update(['status' => 0]);

            return response()->json([
                'success'   => TRUE,
                'message'   => 'Peminjaman ruang rapat berhasil dibatalkan'
            ]);
        }
    }

}
