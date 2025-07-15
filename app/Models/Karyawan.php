<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Karyawan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'jabatan', 'karyawan'
    ];

    protected $table = 'karyawan';

    public static function select2_karyawan($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $search = isset($params['search']) ? $params['search'] : '';

        $condition = '';

        $query = static::select(DB::raw('CONCAT(karyawan, " - ", jabatan) as text, id, karyawan'))
                        ->where('status','=',1)
                        ->where(function ($query) use ($search) {
                            $query->where('karyawan','like','%'.$search.'%')
                                ->orWhere('jabatan','like','%'.$search.'%');
                        })
                        ->orderBy('karyawan', 'ASC')
                        ->offset($start)
                        ->limit($limit);

        $response = [
            'query' => $query->get(),
            'count' => $query->count()
        ];

        return $response;
    }

}
