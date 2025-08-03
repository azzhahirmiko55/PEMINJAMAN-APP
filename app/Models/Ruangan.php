<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'tb_ruang_rapat';

    protected $primaryKey = 'id_ruangrapat';

    public $incrementing = true;
    protected $keyType = 'int';

      protected $fillable = [
        'nama_ruangan',
        'warna_ruangan',
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