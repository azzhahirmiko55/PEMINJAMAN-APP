<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PeminjamanKendaraan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'peminjaman_kendaraan';

    protected $with = ['kendaraan'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }

    public static function query_peminjaman_kendaraan()
    {
        return static::leftJoin('kendaraan','kendaraan.id', '=', 'peminjaman_kendaraan.id_kendaraan')
                ->select('peminjaman_kendaraan.*', DB::raw('CONCAT(kendaraan.plat, " - ", kendaraan.keterangan) as ket_kendaraan, kendaraan.jenis'))->get();
    }

}
