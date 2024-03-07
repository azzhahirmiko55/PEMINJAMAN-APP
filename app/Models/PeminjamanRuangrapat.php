<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PeminjamanRuangrapat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'peminjaman_ruangrapat';

    protected $with = ['ruangrapat'];

    public function ruangrapat()
    {
        return $this->belongsTo(Ruangrapat::class, 'id_ruangrapat');
    }

    public static function query_peminjaman_ruangrapat($id = 0,$type = 0)
    {
        $query = static::leftJoin('ruangrapat','ruangrapat.id', '=', 'peminjaman_ruangrapat.id_ruangrapat')
                ->select('peminjaman_ruangrapat.*','ruangrapat.ruangan','ruangrapat.warna',DB::raw('CONCAT(peminjaman_ruangrapat.jam_mulai, " - ", peminjaman_ruangrapat.jam_selesai) as jam'))
                ->where(function ($query) use ($type) {
                    if(empty($type)) $query->where('peminjaman_ruangrapat.status','=','1');
                })
                ->where(function ($query) use ($id) {
                    if(!empty($id)) $query->where('peminjaman_ruangrapat.id','=',$id);
                });

        return $query;
    }

}
