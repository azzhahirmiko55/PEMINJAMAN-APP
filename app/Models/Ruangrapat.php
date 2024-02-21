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
        $start_datetime = isset($params['start_datetime']) ? $params['start_datetime'] : '';
        $end_datetime = isset($params['end_datetime']) ? $params['end_datetime'] : '';

        $condition = '';

        $query = static::select('id', DB::raw('ruangan as text'))
                        ->where('status','=',1)
                        ->where(function ($query) use ($search) {
                            $query->where('ruangan','like','%'.$search.'%');
                        })
                        ->whereNotExists(function ($query) use ($start_datetime,$end_datetime) {
                            $query->select('peminjaman_ruangrapat.id')
                                    ->from('peminjaman_ruangrapat')
                                    ->where('peminjaman_ruangrapat.status', '=', '1')
                                    ->whereRaw('peminjaman_ruangrapat.id_ruangrapat = ruangrapat.id')
                                    ->whereRaw('(("'.$start_datetime.'" >= peminjaman_ruangrapat.start_datetime and "'.$start_datetime.'" <= peminjaman_ruangrapat.end_datetime) OR ("'.$end_datetime.'" >= peminjaman_ruangrapat.start_datetime and "'.$end_datetime.'" <= peminjaman_ruangrapat.end_datetime))');
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
