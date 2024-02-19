<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kendaraan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'keterangan', 'plat', 'jenis', 'status', 'warna'
    ];

    protected $table = 'kendaraan';
    
    public static function select2_kendaraan($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $search = isset($params['search']) ? $params['search'] : '';
        $jenis_kendaraan = isset($params['jenis_kendaraan']) ? $params['jenis_kendaraan'] : '';
        $tanggal = isset($params['tanggal']) ? $params['tanggal'] : date('Y-m-d');

        $condition = '';

        $query = static::select('id', DB::raw('CONCAT(plat, " - ", keterangan) as text'))
                        ->where('status','=',1)
                        ->where(function ($query) use ($search) {
                            $query->where('keterangan','like','%'.$search.'%')
                                ->orWhere('plat','like','%'.$search.'%');
                        })
                        ->where(function ($query) use ($jenis_kendaraan) {
                            if(!empty($jenis_kendaraan)) $query->where('jenis','=',$jenis_kendaraan);
                        })
                        ->whereNotExists(function ($query) use ($tanggal) {
                            $query->select('peminjaman_kendaraan.id')
                                    ->from('peminjaman_kendaraan')
                                    ->where('peminjaman_kendaraan.status', '=', '1')
                                    ->whereRaw('peminjaman_kendaraan.id_kendaraan = kendaraan.id')
                                    ->where('peminjaman_kendaraan.tanggal', '=', $tanggal);
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

}
