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
            $gt_ms_kendaraan = DB::table('ms_kendaraan')->where('status','!=', 9)->get();
        } else {
            $gt_ms_kendaraan = DB::table('ms_kendaraan')->where('id', $id)->first();
        }

        return $gt_ms_kendaraan;
    }

    public static function select_kendaraan($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $search = isset($params['search']) ? $params['search'] : '';
        $jenis_kendaraan = isset($params['jenis_kendaraan']) ? $params['jenis_kendaraan'] : '';

        $condition = '';

        $query = DB::table('ms_kendaraan')
                    ->select('id', DB::raw('CONCAT(plat, " - ", keterangan) as text'))
                    ->where('status','=',1)
                    ->where(function ($query) use ($search) {
                        $query->where('keterangan','like','%'.$search.'%')
                              ->orWhere('plat','like','%'.$search.'%');
                    })
                    ->where(function ($query) use ($jenis_kendaraan) {
                        if(!empty($jenis_kendaraan)) $query->where('jenis','=',$jenis_kendaraan);
                    })
                    ->orderBy('keterangan', 'ASC')
                    ->offset($start)
                    ->limit($limit);
        
        $response = [
            'query' => $query->get(),
            'count' => $query->count()
        ];

        return $response;

    }

    public static function prosesInputKendaraan($params = [])
    {
        $id = isset($params['id']) ? $params['id'] : 0;
        $plat = isset($params['plat_nomor']) ? $params['plat_nomor'] : '';
        $jenis_kendaraan = isset($params['jenis_kendaraan']) ? $params['jenis_kendaraan'] : '';
        $keterangan = isset($params['keterangan']) ? $params['keterangan'] : '';
        $status = isset($params['status']) ? $params['status'] : 1;

        $arr_kendaraan = [];

        if(empty($id)){
            $arr_kendaraan = [
                'plat'              => $plat,
                'jenis'             => $jenis_kendaraan,
                'keterangan'        => $keterangan,
                'insert_at'         => now(),
                'status'            => $status
            ];
        } else {
            $arr_kendaraan = [
                'plat'              => $plat,
                'jenis'             => $jenis_kendaraan,
                'keterangan'        => $keterangan,
                'update_at'         => now(),
                'status'            => $status
            ];
        }

        DB::beginTransaction();

        try {
            
            if(empty($id)){
                DB::table('ms_kendaraan')->insert([$arr_kendaraan]);
            } else {
                DB::table('ms_kendaraan')->where('id', $id)->update($arr_kendaraan);
            }
            DB::commit();

            return true;

        }catch(\Exception $e){

            DB::rollback();
            return false;

        }
    }

    public static function prosesHapusKendaraan($params = [])
    {
        $id = isset($params['id']) ? $params['id'] : 0;

        DB::beginTransaction();

        try {
            
            DB::table('ms_kendaraan')->where('id', $id)->update(['status' => 9]);
            DB::commit();

            return true;

        }catch(\Exception $e){

            DB::rollback();
            return false;

        }
    }

}
