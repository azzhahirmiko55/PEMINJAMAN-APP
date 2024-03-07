<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dashboard 
{

    public static function query_total_peminjaman()
    {
        
        $total_peminjaman_kendaraan_bulan = DB::table('peminjaman_kendaraan');
        $total_peminjaman_kendaraan = DB::table('peminjaman_kendaraan');
        $total_peminjaman_kendaraan_hari = DB::table('peminjaman_kendaraan');

        $total_peminjaman_ruangrapat_bulan = DB::table('peminjaman_ruangrapat');
        $total_peminjaman_ruangrapat = DB::table('peminjaman_ruangrapat');
        $total_peminjaman_ruangrapat_hari = DB::table('peminjaman_ruangrapat');

        $query_kendaraan = DB::table('peminjaman_kendaraan')
                            ->join('kendaraan', 'kendaraan.id', '=', 'peminjaman_kendaraan.id_kendaraan')
                            ->select('peminjaman_kendaraan.*', DB::raw('CONCAT(kendaraan.plat, " - ", kendaraan.keterangan) as ket_kendaraan, kendaraan.jenis, kendaraan.warna, kendaraan.plat, kendaraan.keterangan'))->where('peminjaman_kendaraan.status',1);

        $query_ruangrapat = DB::table('peminjaman_ruangrapat')
                                ->join('ruangrapat', 'ruangrapat.id', '=', 'peminjaman_ruangrapat.id_ruangrapat')
                                ->select('peminjaman_ruangrapat.*','ruangrapat.ruangan','ruangrapat.warna',DB::raw('CONCAT(peminjaman_ruangrapat.jam_mulai, " - ", peminjaman_ruangrapat.jam_selesai) as jam'))->where('peminjaman_ruangrapat.status',1);

        $kendaraan_available = DB::table('kendaraan')
                                ->select('id', DB::raw('CONCAT(plat, " - ", keterangan) as text'),'plat','keterangan')
                                ->where('status','=',1)
                                ->whereNotExists(function ($query) {
                                    $query->select('peminjaman_kendaraan.id')
                                            ->from('peminjaman_kendaraan')
                                            ->where('peminjaman_kendaraan.status', '=', '1')
                                            ->whereRaw('peminjaman_kendaraan.id_kendaraan = kendaraan.id')
                                            ->where('peminjaman_kendaraan.tanggal', '=', date('Y-m-d'));
                                });
        
        $ruangrapat_available = DB::table('ruangrapat')
                                ->select('id', DB::raw('ruangan as text'))
                                ->where('status','=',1)
                                ->whereNotExists(function ($query) {
                                    $query->select('peminjaman_ruangrapat.id')
                                            ->from('peminjaman_ruangrapat')
                                            ->where('peminjaman_ruangrapat.status', '=', '1')
                                            ->whereRaw('peminjaman_ruangrapat.id_ruangrapat = ruangrapat.id')
                                            ->where('peminjaman_ruangrapat.tanggal', '=', date('Y-m-d'))
                                            ->whereRaw('("'.date('H:i:s').'" between peminjaman_ruangrapat.jam_mulai and peminjaman_ruangrapat.jam_selesai)')
                                        ;
                                });

        return [
            'list_kendaraan'        => $query_kendaraan->orderBy('created_at', 'DESC')->take(5)->get(),
            'kendaraan_available'   => $kendaraan_available->get(),
            'total_kendaraan_bulan' => $total_peminjaman_kendaraan_bulan->where(['status' => 1])->whereMonth('tanggal', date('m'))->count(),
            'total_kendaraan'       => $total_peminjaman_kendaraan->where(['status' => 1])->whereYear('tanggal', date('Y'))->count(),
            'total_kendaraan_hari'  => $total_peminjaman_kendaraan_hari->where(['status' => 1])->whereDate('tanggal', date('Y-m-d'))->count(),

            'list_ruangrapat'        => $query_ruangrapat->orderBy('created_at', 'DESC')->take(5)->get(),
            'ruangrapat_available'   => $ruangrapat_available->get(),
            'total_ruangrapat_bulan'    => $total_peminjaman_ruangrapat_bulan->where(['status' => 1])->whereMonth('tanggal', date('m'))->count(),
            'total_ruangrapat'          => $total_peminjaman_ruangrapat->where(['status' => 1])->whereYear('tanggal', date('Y'))->count(),
            'total_ruangrapat_hari'     => $total_peminjaman_ruangrapat_hari->where(['status' => 1])->whereDate('tanggal', date('Y-m-d'))->count(),
        ];
    }
}
