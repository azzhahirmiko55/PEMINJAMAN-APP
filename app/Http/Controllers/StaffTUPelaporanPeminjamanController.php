<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tb_peminjaman;
use App\Models\Pegawai;
use App\Models\KendaraanV2;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
use Barryvdh\DomPDF\Facade\Pdf;


class StaffTUPelaporanPeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = FilterController::current();

        $awal  = $filter['tanggal_awal'] ?? null;
        $akhir = $filter['tanggal_akhir'] ?? null;

        $dRekapRuangan = DB::table('tb_peminjaman as p')
            ->leftJoin('tb_ruang_rapat as r', 'p.id_ruangan', '=', 'r.id_ruangrapat')
            ->leftJoin('tb_pegawai as pg', 'p.id_peminjam', '=', 'pg.id_pegawai')
            ->where('p.tipe_peminjaman', 'ruangan')
            ->when(!empty($awal) && !empty($akhir), function ($q) use ($awal, $akhir) {
                $q->whereBetween('p.tanggal', [$awal, $akhir]);
            })
            ->when(
                !empty($filter['status']) ,
                fn($q) => $q->where('p.status', [
                    $filter['status'],
                ])
            )
            ->when(
                !empty($filter['id_peminjam']) ,
                fn($q) => $q->where('p.id_peminjam', [
                    $filter['id_peminjam'],
                ])
            )
            ->when(
                !empty($filter['id_ruangan']) && ($filter['section_view']??'') ==0 ,
                fn($q) => $q->where('p.id_ruangan', [
                    $filter['id_ruangan'],
                ])
            )
            ->selectRaw("
                pg.id_pegawai,
                COALESCE(pg.nama_pegawai, '-') AS nama_pegawai,
                COALESCE(r.nama_ruangan, '-') AS nama_ruangan,
                COUNT(p.id_peminjaman) AS total_peminjaman,
                SUM(CASE WHEN p.status = 1 THEN 1 ELSE 0 END) AS total_disetujui,
                SUM(CASE WHEN p.status = -1 THEN 1 ELSE 0 END) AS total_tolak,
                SUM(CASE WHEN p.pengembalian_st = 1 THEN 1 ELSE 0 END) AS total_pengembalian
            ")
            ->groupBy('pg.id_pegawai', 'pg.nama_pegawai', 'r.nama_ruangan')
            ->orderBy('pg.nama_pegawai')
            ->orderByDesc('total_peminjaman')
            ->get();

        $dRekapKendaraan = DB::table('tb_peminjaman as p')
            ->leftJoin('tb_kendaraan as k', 'k.id_kendaraan', '=', 'p.id_kendaraan')
            ->leftJoin('tb_pegawai as pg', 'pg.id_pegawai', '=', 'p.id_peminjam')
            ->where('p.tipe_peminjaman', 'kendaraan')
            ->when(!empty($awal) && !empty($akhir), function ($q) use ($awal, $akhir) {
                $q->whereBetween('p.tanggal', [$awal, $akhir]);
            })
            ->when(
                !empty($filter['status']) ,
                fn($q) => $q->where('p.status', [
                    $filter['status'],
                ])
            )
            ->when(
                !empty($filter['id_peminjam']) ,
                fn($q) => $q->where('p.id_peminjam', [
                    $filter['id_peminjam'],
                ])
            )
            ->when(
                !empty($filter['id_kendaraan']) && ($filter['section_view']??'') ==-1 ,
                fn($q) => $q->where('p.id_kendaraan', [
                    $filter['id_kendaraan'],
                ])
            )
            ->selectRaw("
                pg.id_pegawai,
                COALESCE(pg.nama_pegawai, '-') AS nama_pegawai,
                COUNT(p.id_peminjaman) AS total_peminjaman,
                SUM(CASE WHEN k.jenis_kendaraan = 'Roda-2' THEN 1 ELSE 0 END) AS kendaraan_roda2,
                SUM(CASE WHEN k.jenis_kendaraan = 'Roda-4' THEN 1 ELSE 0 END) AS kendaraan_roda4,
                SUM(CASE WHEN p.status = 1 THEN 1 ELSE 0 END) AS total_disetujui,
                SUM(CASE WHEN p.status = -1 THEN 1 ELSE 0 END) AS total_tolak,
                SUM(CASE WHEN p.pengembalian_st = 1 THEN 1 ELSE 0 END) AS total_pengembalian
            ")
            ->groupBy('pg.id_pegawai', 'pg.nama_pegawai')
            ->orderByDesc('total_peminjaman')
            ->orderBy('pg.nama_pegawai')
            ->get();

        $mst_pegawai = Pegawai::all()->where('active_st',1);
        $mst_kendaraan = KendaraanV2::all()->where('active_st',1);
        $mst_ruangan = Ruangan::all()->where('active_st',1);
        return view('staff.pelaporan_peminjaman.index', [
            "page"  => "Data Pelaporan Peminjaman",
            'js_script' => 'js/staff/pelaporanpeminjaman/index.js',
            'dRekapRuangan' => $dRekapRuangan,
            'dRekapKendaraan' => $dRekapKendaraan,
            'filter' => $filter,
            'mst_kendaraan' => $mst_kendaraan,
            'mst_ruangan' => $mst_ruangan,
            'mst_pegawai' => $mst_pegawai,
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

    public function exportRuangan(Request $request)
    {
        $filter = FilterController::current();
        $awal  = $filter['tanggal_awal'] ?? null;
        $akhir = $filter['tanggal_akhir'] ?? null;

        $dRekapRuangan = DB::table('tb_peminjaman as p')
            ->leftJoin('tb_ruang_rapat as r', 'p.id_ruangan', '=', 'r.id_ruangrapat')
            ->leftJoin('tb_pegawai as pg', 'p.id_peminjam', '=', 'pg.id_pegawai')
            ->where('p.tipe_peminjaman', 'ruangan')
            ->when(!empty($awal) && !empty($akhir), function ($q) use ($awal, $akhir) {
                $q->whereBetween('p.tanggal', [$awal, $akhir]);
            })
            ->when(
                !empty($filter['status']) ,
                fn($q) => $q->where('p.status', [
                    $filter['status'],
                ])
            )
            ->when(
                !empty($filter['id_peminjam']) ,
                fn($q) => $q->where('p.id_peminjam', [
                    $filter['id_peminjam'],
                ])
            )
            ->when(
                !empty($filter['id_ruangan']) && ($filter['section_view']??'') ==0 ,
                fn($q) => $q->where('p.id_ruangan', [
                    $filter['id_ruangan'],
                ])
            )
            ->selectRaw("
                pg.id_pegawai,
                COALESCE(pg.nama_pegawai, '-') AS nama_pegawai,
                COALESCE(r.nama_ruangan, '-') AS nama_ruangan,
                COUNT(p.id_peminjaman) AS total_peminjaman,
                SUM(CASE WHEN p.status = 1 THEN 1 ELSE 0 END) AS total_disetujui,
                SUM(CASE WHEN p.status = -1 THEN 1 ELSE 0 END) AS total_tolak,
                SUM(CASE WHEN p.pengembalian_st = 1 THEN 1 ELSE 0 END) AS total_pengembalian
            ")
            ->groupBy('pg.id_pegawai', 'pg.nama_pegawai', 'r.nama_ruangan')
            ->orderBy('pg.nama_pegawai')
            ->orderByDesc('total_peminjaman')
            ->get();

        $periodeLabel = (!empty($awal) && !empty($akhir))
            ? date('d/m/Y', strtotime($awal)).' – '.date('d/m/Y', strtotime($akhir))
            : 'Semua Tanggal';

        $pdf = Pdf::loadView('staff.pelaporan_peminjaman.cetak_laporan_ruangan', [
            'dRekapRuangan' => $dRekapRuangan,
            'periodeLabel'  => $periodeLabel,
            'printedAt'     => now()->locale('id')->translatedFormat('d F Y'),
        ])->setPaper('a4', 'landscape');

        $filename = 'Pelaporan_Peminjaman_Ruangan_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->stream($filename);
    }

    public function exportKendaraan(Request $request)
    {
        $filter = FilterController::current();

        $awal  = $filter['tanggal_awal'] ?? null;
        $akhir = $filter['tanggal_akhir'] ?? null;

        $dRekapKendaraan = DB::table('tb_peminjaman as p')
            ->leftJoin('tb_kendaraan as k', 'k.id_kendaraan', '=', 'p.id_kendaraan')
            ->leftJoin('tb_pegawai as pg', 'pg.id_pegawai', '=', 'p.id_peminjam')
            ->where('p.tipe_peminjaman', 'kendaraan')
            ->when(!empty($awal) && !empty($akhir), function ($q) use ($awal, $akhir) {
                $q->whereBetween('p.tanggal', [$awal, $akhir]);
            })
            ->when(
                !empty($filter['status']) ,
                fn($q) => $q->where('p.status', [
                    $filter['status'],
                ])
            )
            ->when(
                !empty($filter['id_peminjam']) ,
                fn($q) => $q->where('p.id_peminjam', [
                    $filter['id_peminjam'],
                ])
            )
            ->when(
                !empty($filter['id_kendaraan']) && ($filter['section_view']??'') ==-1 ,
                fn($q) => $q->where('p.id_kendaraan', [
                    $filter['id_kendaraan'],
                ])
            )
            ->selectRaw("
                pg.id_pegawai,
                COALESCE(pg.nama_pegawai,'-') AS nama_pegawai,
                COUNT(p.id_peminjaman) AS total_peminjaman,
                SUM(CASE WHEN k.jenis_kendaraan = 'Roda-2' THEN 1 ELSE 0 END) AS kendaraan_roda2,
                SUM(CASE WHEN k.jenis_kendaraan = 'Roda-4' THEN 1 ELSE 0 END) AS kendaraan_roda4,
                SUM(CASE WHEN p.status = 1 THEN 1 ELSE 0 END) AS total_disetujui,
                SUM(CASE WHEN p.status = -1 THEN 1 ELSE 0 END) AS total_tolak,
                SUM(CASE WHEN p.pengembalian_st = 1 THEN 1 ELSE 0 END) AS total_pengembalian
            ")
            ->groupBy('pg.id_pegawai', 'pg.nama_pegawai')
            ->orderByDesc('total_peminjaman')
            ->orderBy('pg.nama_pegawai')
            ->get();

        $periodeLabel = (!empty($awal) && !empty($akhir))
            ? date('d/m/Y', strtotime($awal)).' – '.date('d/m/Y', strtotime($akhir))
            : 'Semua Tanggal';

        $pdf = Pdf::loadView('staff.pelaporan_peminjaman.cetak_laporan_kendaraan', [
            'dRekapKendaraan' => $dRekapKendaraan,
            'periodeLabel'    => $periodeLabel,
            'printedAt'       => now()->locale('id')->translatedFormat('d F Y'),
        ])->setPaper('a4', 'landscape');

        $filename = 'Pelaporan_Peminjaman_Kendaraan_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->stream($filename);
    }
}
