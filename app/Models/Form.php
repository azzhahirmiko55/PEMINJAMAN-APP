<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Form
{
    
    public static function prosesPinjamKendaraan($params = [])
    {
        $peminjam = isset($params['peminjam']) ? $params['peminjam'] : '';
        $driver = isset($params['driver']) ? $params['driver'] : '';
        $kendaraan = isset($params['kendaraan']) ? $params['kendaraan'] : 0;
        $tanggal = isset($params['tanggal']) ? $params['tanggal'] : date('Y-m-d');
        $keperluan = isset($params['keperluan']) ? $params['keperluan'] : '';

        $arr_form_kendaraan = [
            'peminjam'      => $peminjam,
            'driver'        => $driver,
            'id_kendaraan'  => $kendaraan,
            'tanggal'       => $tanggal,
            'keperluan'     => $keperluan,
            'insert_at'     => now(),
            'status'        => 1
        ];

        DB::beginTransaction();

        try {
            
            DB::table('tb_peminjaman_kendaraan')->insert([$arr_form_kendaraan]);
            DB::commit();

            return true;

        }catch(\Exception $e){

            DB::rollback();
            return false;

        }
    }

    public static function prosesBatalKendaraan($params = [])
    {
        $id = isset($params['id']) ? $params['id'] : 0;

        DB::beginTransaction();

        try {
            
            DB::table('tb_peminjaman_kendaraan')->where('id', $id)->update(['status' => 5]);
            DB::commit();

            return true;

        }catch(\Exception $e){

            DB::rollback();
            return false;

        }
    }

}
