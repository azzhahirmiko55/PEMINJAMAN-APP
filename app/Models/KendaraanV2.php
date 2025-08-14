<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanV2 extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'tb_kendaraan';

    protected $primaryKey = 'id_kendaraan';

    public $incrementing = true;
    protected $keyType = 'int';

      protected $fillable = [
        'no_plat',
        'jenis_kendaraan',
        'warna_kendaraan',
        'keterangan',
        'active_st',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active_st' => 'boolean',
    ];
}
