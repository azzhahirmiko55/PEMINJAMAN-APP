<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ruangrapat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'ruangrapat';

    public static function select2_ruangrapat($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $search = isset($params['search']) ? $params['search'] : '';
        $tanggal = isset($params['tanggal']) ? $params['tanggal'] : '';
        $start_time = isset($params['start_time']) ? $params['start_time'] : '';
        $end_time = isset($params['end_time']) ? $params['end_time'] : '';

        $condition = '';

        $query = static::select('id', DB::raw('ruangan as text'))
                        ->where('status','=',1)
                        ->where(function ($query) use ($search) {
                            $query->where('ruangan','like','%'.$search.'%');
                        })
                        ->whereNotExists(function ($query) use ($tanggal,$start_time,$end_time) {
                            $query->select('peminjaman_ruangrapat.id')
                                    ->from('peminjaman_ruangrapat')
                                    ->where('peminjaman_ruangrapat.status', '=', '1')
                                    ->whereRaw('peminjaman_ruangrapat.id_ruangrapat = ruangrapat.id')
                                    ->where('peminjaman_ruangrapat.tanggal', '=', $tanggal)
                                    // ->whereRaw('(("'.$start_time.'" > peminjaman_ruangrapat.jam_mulai and "'.$start_time.'" < peminjaman_ruangrapat.jam_selesai) OR ("'.$end_time.'" > peminjaman_ruangrapat.jam_mulai and "'.$end_time.'" < peminjaman_ruangrapat.jam_selesai))')
                                    ->whereRaw('((peminjaman_ruangrapat.jam_mulai between "'.$start_time.'" and "'.$end_time.'") OR (peminjaman_ruangrapat.jam_selesai between "'.$start_time.'" and "'.$end_time.'"))')
                                    // ->whereRaw('(("'.$start_datetime.'" >= peminjaman_ruangrapat.start_datetime and "'.$start_datetime.'" <= peminjaman_ruangrapat.end_datetime) OR ("'.$end_datetime.'" >= peminjaman_ruangrapat.start_datetime and "'.$end_datetime.'" <= peminjaman_ruangrapat.end_datetime))')
                                    ;
                        })
                        ->orderBy('ruangan', 'ASC')
                        ->offset($start)
                        ->limit($limit);

        $response = [
            'query' => $query->get(),
            'count' => $query->count()
        ];

        return $response;
    }
}