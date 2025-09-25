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

class StaffTuRiwayatPeminjamanController extends Controller
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
                        !empty($filter['status']) ,
                        fn($q) => $q->where('p.status', [
                            $filter['status'],
                        ])
                    )
                    ->when(
                        !empty($filter['id_kendaraan']) && ($filter['section_view']??'') ==-1 ,
                        fn($q) => $q->where('p.id_kendaraan', [
                            $filter['id_kendaraan'],
                        ])
                    )
                    ->when(
                        !empty($filter['id_ruangan']) && ($filter['section_view']??'') ==0 ,
                        fn($q) => $q->where('p.id_ruangan', [
                            $filter['id_ruangan'],
                        ])
                    )
                    ->when(
                        !empty($filter['id_peminjam']) ,
                        fn($q) => $q->where('p.id_peminjam', [
                            $filter['id_peminjam'],
                        ])
                    )
                    ->orderBy('p.tanggal', 'asc')
                    ->orderBy('p.jam_mulai', 'asc')
                    ->get()
        ;
        $mst_kendaraan = KendaraanV2::all()->where('active_st',1);
        $mst_ruangan = Ruangan::all()->where('active_st',1);
        $mst_pegawai = Pegawai::all()->where('active_st',1);
        return view('staff.riwayat_peminjaman.index', [
            "page"  => "Data Riwayat Peminjaman",
            'js_script' => 'js/staff/riwayatpeminjaman/index.js',
            'dRiwayat' => $dRiwayat,
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

    public function export_excel(){
        $filter = FilterController::current();
        $dRiwayat = Tb_peminjaman::from('tb_peminjaman as p')
                    ->leftJoin('tb_kendaraan as k', 'p.id_kendaraan', '=', 'k.id_kendaraan')
                    ->leftJoin('tb_ruang_rapat as r', 'p.id_ruangan', '=', 'r.id_ruangrapat')
                    ->leftJoin('tb_pegawai as pg', 'p.id_peminjam', '=', 'pg.id_pegawai')
                    ->leftJoin('tb_pegawai as ve', 'p.id_verifikator', '=', 'pg.id_pegawai')
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
                        !empty($filter['id_peminjam']) ,
                        fn($q) => $q->where('p.id_peminjam', [
                            $filter['id_peminjam'],
                        ])
                    )
                    ->orderBy('p.tanggal', 'asc')
                    ->orderBy('p.jam_mulai', 'asc')
                    ->get()
        ;

        $header1 = [
            'No.',
            'Nama Pegawai',
            'Tanggal',
            'Waktu Peminjaman', '',
            'Tipe Peminjaman',
            'Verifikator',
            'Kendaraan','','',
            'Ruangan','',
            'Status',
            'Pengembalian',
        ];
        $header2 = [
            '', '', '', 'Mulai','Selesai', '', '', 'Driver','Plat Nomor','Jenis Kendaraan','Ruangan','Peserta','',''
        ];

        $rows = [];
        foreach ($dRiwayat as $i => $item) {
            $labelPengembalian = match((int)($item->pengembalian_st ?? 0)) {
                1       => 'Sudah Dikembalikan',
                0       => 'Belum Dikembalikan',
                default => 'Tidak Diketahui',
            };

            $rows[] = [
                $i+1,
                $item->nama_pegawai,
                $item->tanggal ? Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') : '',
                $item->jam_mulai ? Carbon::parse($item->jam_mulai)->format('H:i:s') : '',
                $item->jam_selesai ? Carbon::parse($item->jam_selesai)->format('H:i:s') : '',
                $item->tipe_peminjaman == 0 ? 'Kendaraan' : 'Ruangan',
                $item->verifikator_nama,
                $item->driver,
                $item->no_plat,
                $item->jenis_kendaraan,
                $item->nama_ruangan,
                $item->jumlah_peserta,
                $item->status == 1 ? 'Disetujui' : ($item->status == -1 ? 'Ditolak' : 'Proses Verifikasi'),
                $labelPengembalian,
            ];
        }


        $data = array_merge([$header1, $header2], $rows);

        $export = new class($data) implements FromArray, WithEvents, WithStyles, ShouldAutoSize {
            public function __construct(private array $data) {}

            public function array(): array { return $this->data; }

            public function registerEvents(): array
            {
                return [
                    AfterSheet::class => function(AfterSheet $event) {
                        $sheet = $event->sheet->getDelegate();

                        $sheet->mergeCells('A1:A2'); // No.
                        $sheet->mergeCells('B1:B2'); // Nama Pegawai
                        $sheet->mergeCells('C1:C2'); // Tanggal
                        $sheet->mergeCells('D1:E1'); // Waktu Peminjaman
                        $sheet->mergeCells('F1:F2'); // Tipe Peminjaman
                        $sheet->mergeCells('G1:G2'); // Verifikator
                        $sheet->mergeCells('H1:J1'); // Kendaraan
                        $sheet->mergeCells('K1:L1'); // Ruangan
                        $sheet->mergeCells('M1:M2'); // Status
                        $sheet->mergeCells('N1:N2'); // Pengembalian

                        // Style header
                        $sheet->getStyle('A1:N2')->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                            ->setVertical(Alignment::VERTICAL_CENTER)
                            ->setWrapText(true);

                        $sheet->getStyle('A1:N2')->getFont()->setBold(true);

                        $highestRow = $sheet->getHighestRow();   // total baris
                        $sheet->getStyle("A1:N{$highestRow}")->getBorders()->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);

                        $sheet->freezePane('A3');
                    }
                ];
            }

            public function styles(Worksheet $sheet)
            {
                $sheet->getRowDimension(1)->setRowHeight(24);
                $sheet->getRowDimension(2)->setRowHeight(24);
                return [];
            }
        };

        return Excel::download(
            $export,
            'riwayat-peminjaman-' . now()->format('Ymd_His') . '.xlsx',
            ExcelFormat::XLSX
        );
    }
}
