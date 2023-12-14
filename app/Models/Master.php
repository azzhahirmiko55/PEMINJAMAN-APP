<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    // use HasFactory;

    public static function gt_ms_kendaraan($id = 0)
    {
        if(empty($id)){
            $gt_ms_kendaraan = DB::table('ms_kendaraan')->where('status', 1)->get();
        }
    }

    public static function prosesJadwal($params = [])
    {
        
    }

}
