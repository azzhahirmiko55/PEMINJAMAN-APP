<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tb_peminjaman;
use App\Models\Pegawai;
use App\Models\KendaraanV2;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SatpamLaporanPengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = FilterController::current();

        $dRiwayat = Tb_peminjaman::from('tb_peminjaman as p')
                    ->leftJoin('tb_kendaraan as k', 'p.id_kendaraan', '=', 'k.id_kendaraan')
                    ->leftJoin('tb_ruang_rapat as r', 'p.id_ruangan', '=', 'r.id_ruangrapat')
                    ->leftJoin('tb_pegawai as pg', 'p.id_peminjam', '=', 'pg.id_pegawai')
                    ->leftJoin('tb_pegawai as ve', 'p.id_verifikator', '=', 've.id_pegawai')
                    ->select(
                        'p.*',
                        'k.no_plat',
                        'k.keterangan as kendaraan_ket',
                        'k.jenis_kendaraan',
                        'r.nama_ruangan',
                        'pg.nama_pegawai',
                        've.nama_pegawai as verifikator_nama',
                    )
                    ->when(
                        !empty($filter['tanggal_awal']) && !empty($filter['tanggal_akhir']),
                        fn($q) => $q->whereBetween('p.tanggal', [
                            $filter['tanggal_awal'],
                            $filter['tanggal_akhir'],
                        ])
                    )
                    ->when(
                        isset($filter['pengembalian_st']),
                        fn($q) => $q->where('p.pengembalian_st', [
                            $filter['pengembalian_st'],
                        ])
                    )
                    ->when(
                        !empty($filter['id_kendaraan']) && ($filter['section_view']??'') ==-1 ,
                        fn($q) => $q->where('p.id_kendaraan', [
                            $filter['id_kendaraan'],
                        ])
                    )
                    ->orderBy('p.tanggal', 'asc')
                    ->orderBy('p.jam_mulai', 'asc')
                    ->get()
        ;

        $mst_kendaraan = KendaraanV2::all()->where('active_st',1);
        return view('satpam.laporan_pengembalian.index', [
            "page"  => "Laporan Pengembalian",
            'js_script' => 'js/satpam/laporan_pengembalian/index.js',
            'dRiwayat' => $dRiwayat,
            'filter' => $filter,
            'mst_kendaraan' => $mst_kendaraan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}