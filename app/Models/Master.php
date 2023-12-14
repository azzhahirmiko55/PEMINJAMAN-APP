<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Master
{
    // use HasFactory;

    public static function gt_ms_kendaraan($id = 0)
    {
        $gt_ms_kendaraan = [];
        if(empty($id)){
            $gt_ms_kendaraan = DB::table('ms_kendaraan')->where('status', 1)->get();
        } else {
            $gt_ms_kendaraan = DB::table('ms_kendaraan')->where('id', $id)->get();
        }

        return $gt_ms_kendaraan;
    }

    public static function prosesInputKendaraan($params = [])
    {
        $plat = isset($params['plat_nomor']) ? $params['plat_nomor'] : '';
        $jenis_kendaraan = isset($params['jenis_kendaraan']) ? $params['jenis_kendaraan'] : '';
        $keterangan = isset($params['keterangan']) ? $params['keterangan'] : '';
        
        $arr_kendaraan = [
            'plat'              => $plat,
            'jenis'             => $jenis_kendaraan,
            'keterangan'        => $keterangan,
            'insert_at'         => now()
        ];

        DB::beginTransaction();

        try {
            
            DB::table('ms_kendaraan')->insert([$arr_kendaraan]);
            DB::commit();

            return true;

        }catch(\Exception $e){

            DB::rollback();
            return false;

        }
     }

}
