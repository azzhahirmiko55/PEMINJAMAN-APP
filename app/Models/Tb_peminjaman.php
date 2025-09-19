<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_peminjaman extends Model
{
    use HasFactory;


     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'tb_peminjaman';

    protected $primaryKey = 'id_peminjaman';

    public $incrementing = true;
    protected $keyType = 'int';

      protected $fillable = [
        'id_peminjam',
        'id_kendaraan',
        'id_ruangan',
        'tipe_peminjaman',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'keperluan',
        'driver',
        'jumlah_peserta',
        'status',
        'active_st',
        'detail_lokasi',
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