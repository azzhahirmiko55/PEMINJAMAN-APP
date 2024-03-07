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

    public static function query_peminjaman_kendaraan($id = 0,$type = 0)
    {
        $query = static::leftJoin('kendaraan','kendaraan.id', '=', 'peminjaman_kendaraan.id_kendaraan')
                ->select('peminjaman_kendaraan.*', DB::raw('CONCAT(kendaraan.plat, " - ", kendaraan.keterangan) as ket_kendaraan, kendaraan.jenis, kendaraan.warna, kendaraan.plat, kendaraan.keterangan'))
                ->where(function ($query) use ($type) {
                    if(empty($type)) $query->where('peminjaman_kendaraan.status','=','1');
                })
                ->where(function ($query) use ($id) {
                    if(!empty($id)) $query->where('peminjaman_kendaraan.id','=',$id);
                });

        return $query;
    }

    public static function process_pindah_jadwal($params = [])
    {
        $id = isset($params['id']) ? $params['id'] : 0;
        $days = isset($params['days']) ? $params['days'] : 0;

        DB::beginTransaction();

            try {

                $get_peminjaman_kendaraan = DB::table('peminjaman_kendaraan')->where('id', $id)->first();

                $tanggal = date("Y-m-d", strtotime($get_peminjaman_kendaraan->tanggal));
                $id_kendaraan = $get_peminjaman_kendaraan->id_kendaraan;

                $update_tanggal = date("Y-m-d", strtotime("".$days." day", strtotime($tanggal)));
                
                $check_kendaraan = DB::table('peminjaman_kendaraan')->where(['id_kendaraan' => $id_kendaraan,'tanggal' => $update_tanggal,'status' => 1])->first();

                if(!empty($check_kendaraan)){
                    return ['status' => false,'message' => 'Peminjaman gagal, Sudah ada peminjaman kendaraan ini pada tanggal tersebut !'];
                }

                $arr_peminjaman_kendaraan = [
                    'tanggal'    => $update_tanggal,
                    'updated_at' => now()
                ];

                DB::table('peminjaman_kendaraan')->where('id', $id)->update($arr_peminjaman_kendaraan);

                DB::commit();

                return ['status' => true,'message' => 'Peminjaman kendaraan berhasil diperbarui'];

            }catch(\Exception $e){

                DB::rollback();

                return ['status' => false,'message' => ''];

            }
    }
}
