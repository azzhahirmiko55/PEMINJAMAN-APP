<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rekapitulasi
{
    public static function gt_tb_peminjaman_kendaraan($id = 0)
    {
        $query = DB::table('tb_peminjaman_kendaraan AS tpk')
                    ->leftJoin('ms_kendaraan AS mk', 'mk.id', '=', 'tpk.id_kendaraan')
                    ->select('tpk.*', DB::raw('CONCAT(mk.plat, " - ", mk.keterangan) as ket_kendaraan, mk.jenis'))
                    ->where('tpk.status','!=',9)
                    ->where(function ($query) use ($id) {
                        if(!empty($id)) $query->where('tpk.id','=',$id);
                    })->get();

        return $query;
    }
}
