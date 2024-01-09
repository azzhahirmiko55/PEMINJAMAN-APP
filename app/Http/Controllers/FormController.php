<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Master;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    
    public function form_kendaraan()
    {
        return view('form/kendaraan', [
            'page'      => 'Form Peminjaman Kendaraan',
            'js_script' => 'js/form/kendaraan.js'
        ]);
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

            if($validator->fails()) {
                return response()->json(implode(',',$validator->errors()->all()), 422);
            }

            Form::prosesPinjamKendaraan([
                'peminjam'      => $request->peminjam,
                'driver'        => $request->driver,
                'kendaraan'     => $request->kendaraan,
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

            Form::prosesBatalKendaraan([
                'id'  => $request->id
            ]);

            return response()->json([
                'success'   => TRUE,
                'message'   => 'Peminjaman kendaraan berhasil dibatalkan'
            ]);
        }
    }

}
