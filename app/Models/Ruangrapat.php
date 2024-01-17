<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

        $condition = '';

        $query = static::select('id', DB::raw('ruangan as text'))
                        ->where('status','=',1)
                        ->where(function ($query) use ($search) {
                            $query->where('ruangan','like','%'.$search.'%');
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
