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

class KasubagDataPeminjamanController extends Controller
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
                    ->leftJoin('tb_pegawai as png', 'p.pengembalian_pegawai_id', '=', 'png.id_pegawai')
                    ->select(
                        'p.*',
                        'k.no_plat',
                        'k.keterangan as kendaraan_ket',
                        'k.jenis_kendaraan',
                        'r.nama_ruangan',
                        'pg.nama_pegawai',
                        've.nama_pegawai as verifikator_nama',
                        'png.nama_pegawai as pengembalian_nm',
                    )
                    ->when(
                        !empty($filter['tanggal_awal']) && !empty($filter['tanggal_akhir']),
                        fn($q) => $q->whereBetween('p.tanggal', [
                            $filter['tanggal_awal'],
                            $filter['tanggal_akhir'],
                        ])
                    )
                    ->when(
                        !empty($filter['tipe_peminjaman']),
                        fn($q) => $q->where('p.tipe_peminjaman', [
                            $filter['tipe_peminjaman'],
                        ])
                    )
                    ->orderBy('p.tanggal', 'asc')
                    ->orderBy('p.jam_mulai', 'asc')
                    ->get()
        ;
        return view('kasubag.riwayat_peminjaman.index', [
            "page"  => "Data Riwayat Peminjaman",
            'js_script' => 'js/kasubag/riwayatpeminjaman/index.js',
            'dRiwayat' => $dRiwayat,
            'filter' => $filter,
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
                    ->leftJoin('tb_pegawai as ve', 'p.id_verifikator', '=', 've.id_pegawai')
                    ->leftJoin('tb_pegawai as png', 'p.pengembalian_pegawai_id', '=', 'png.id_pegawai')
                    ->select(
                        'p.*',
                        'k.no_plat',
                        'k.keterangan as kendaraan_ket',
                        'k.jenis_kendaraan',
                        'r.nama_ruangan',
                        'pg.nama_pegawai',
                        've.nama_pegawai as verifikator_nama',
                        'png.nama_pegawai as pengembalian_nm',
                    )
                    ->when(
                        !empty($filter['tanggal_awal']) && !empty($filter['tanggal_akhir']),
                        fn($q) => $q->whereBetween('p.tanggal', [
                            $filter['tanggal_awal'],
                            $filter['tanggal_akhir'],
                        ])
                    )
                    ->when(
                        !empty($filter['tipe_peminjaman']),
                        fn($q) => $q->where('p.tipe_peminjaman', [
                            $filter['tipe_peminjaman'],
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
            'Verifikasi','',
            'Kendaraan','','',
            'Ruangan','',
            'Status',
            'Keterangan',
            'Pengembalian',
        ];

        $header2 = [
            '', '', '',
            'Mulai','Selesai',
            '',
            'Verifikator','Tanggal',
            'Driver','Plat Nomor','Jenis Kendaraan',
            'Ruangan','Peserta',
            '',                 // Status (rowspan 2)
            '',                 // Keterangan (rowspan 2)
            'Status','Penerima','Tanggal Pengembalian' // 3 subkolom Pengembalian
        ];

        $rows = [];
        foreach ($dRiwayat as $i => $item) {
            $labelPengembalian = match((int)($item->pengembalian_st ?? 0)) {
                1       => 'Sudah Dikembalikan',
                0       => 'Belum Dikembalikan',
                default => 'Tidak Diketahui',
            };
            $tipe = $item->tipe_peminjaman;
            if (is_numeric($tipe)) {
                $tipe = ((int)$tipe === 0) ? 'KENDARAAN' : 'RUANGAN';
            } else {
                $tipe = strtoupper((string)$tipe);
            }

            $rows[] = [
                $i+1,                                                  // No.
                $item->nama_pegawai,                                   // Nama Pegawai
                $item->tanggal ? Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') : '',  // Tanggal
                $item->jam_mulai ? Carbon::parse($item->jam_mulai)->format('H:i:s') : '',                     // Mulai
                $item->jam_selesai ? Carbon::parse($item->jam_selesai)->format('H:i:s') : '',                 // Selesai
                $tipe,                                                 // Tipe Peminjaman
                $item->verifikator_nama,                               // Verifikator
                $item->verifikator_tgl ? Carbon::parse($item->verifikator_tgl)->locale('id')->translatedFormat('d F Y H:i:s') : '', // Verif Tgl
                $item->driver,                                         // Driver
                $item->no_plat,                                        // Plat Nomor
                $item->jenis_kendaraan,                                // Jenis Kendaraan
                $item->nama_ruangan,                                   // Ruangan
                $item->jumlah_peserta,                                 // Peserta
                ($item->status == 1 ? 'Disetujui' : ($item->status == -1 ? 'Ditolak' : 'Proses Verifikasi')),
                $item->keterangan,                                     // Keterangan (kolom tambahan)
                $labelPengembalian,                                    // Status Pengembalian
                $item->pengembalian_nm,                                // Penerima
                $item->pengembalian_tgl ? Carbon::parse($item->pengembalian_tgl)->locale('id')->translatedFormat('d F Y H:i:s') : '', // Tgl Pengembalian
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
                        $sheet->mergeCells('G1:H1'); // Verifikasi (2 kolom)
                        $sheet->mergeCells('I1:K1'); // Kendaraan (3 kolom)
                        $sheet->mergeCells('L1:M1'); // Ruangan (2 kolom)
                        $sheet->mergeCells('N1:N2'); // Status (rowspan)
                        $sheet->mergeCells('O1:O2'); // Keterangan (rowspan)
                        $sheet->mergeCells('P1:R1'); // Pengembalian (3 kolom)

                        // Style header (kedua baris header)
                        $sheet->getStyle('A1:R2')->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                            ->setWrapText(true);
                        $sheet->getStyle('A1:R2')->getFont()->setBold(true);

                        $highestRow = $sheet->getHighestRow();
                        $sheet->getStyle("A1:R{$highestRow}")
                            ->getBorders()->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                        $sheet->freezePane('A3');
                    }
                ];
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                $sheet->getRowDimension(1)->setRowHeight(24);
                $sheet->getRowDimension(2)->setRowHeight(24);
                return [];
            }
        };

        return Excel::download(
            $export,
            'riwayat-peminjaman-' . now()->format('Ymd_His') . '.xlsx',
            \Maatwebsite\Excel\Excel::XLSX
        );
    }

    public function getDataKasubagPeminjaman(Request $request)
    {
        $user = User::join('tb_pegawai','tb_user.id_pegawai','=','tb_pegawai.id_pegawai')
            ->select('tb_user.*','tb_pegawai.*')
            ->where('tb_user.id_user', Auth::user()->id_user)
            ->first();

        if (!$user) {
            return response()->json([]);
        }

        $start = $request->query('start') ? Carbon::parse($request->query('start'))->startOfDay() : null;
        $end   = $request->query('end')   ? Carbon::parse($request->query('end'))->endOfDay()   : null;
        $tanggal = $request->query('tanggal')?$request->query('tanggal'):null;

        $q = Tb_peminjaman::leftJoin('tb_kendaraan', 'tb_peminjaman.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
                            ->leftJoin('tb_ruang_rapat', 'tb_peminjaman.id_ruangan', '=', 'tb_ruang_rapat.id_ruangrapat')
                            ->leftJoin('tb_pegawai as pe', 'tb_peminjaman.id_peminjam', '=', 'pe.id_pegawai')
                            ->leftJoin('tb_pegawai as ve', 'tb_peminjaman.id_verifikator', '=', 've.id_pegawai')
                            ->leftJoin('tb_pegawai as png', 'tb_peminjaman.pengembalian_pegawai_id', '=', 'png.id_pegawai')
                            ->select(
                                'tb_peminjaman.*',
                                'tb_kendaraan.no_plat',
                                'tb_kendaraan.keterangan',
                                'tb_ruang_rapat.nama_ruangan',
                                'pe.nama_pegawai',
                                've.nama_pegawai as verikator_nm',
                                'png.nama_pegawai as pengembalian_nm',
                            );

        if(isset($tanggal)){
            $q->whereDate('tanggal', $tanggal);
        }

        if ($start && $end) {
            $q->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()]);
        }
        $rows = $q->get();

        $toIso = function (?string $tanggal, ?string $timeOrDt, bool $isEnd = false): string {
            if ($timeOrDt) {
                $s = trim($timeOrDt);
                if (preg_match('/[T ]\d{2}:\d{2}/', $s) || preg_match('/^\d{4}-\d{2}-\d{2}/', $s)) {
                    return Carbon::parse($s)->toIso8601String();
                }
                if ($tanggal) {
                    return Carbon::parse($tanggal.' '.$s)->toIso8601String();
                }
            }
            if ($tanggal) {
                return ($isEnd
                    ? Carbon::parse($tanggal)->endOfDay()
                    : Carbon::parse($tanggal)->startOfDay()
                )->toIso8601String();
            }
            return Carbon::now()->toIso8601String();
        };

        $mapTipe = function ($val) {
            if ($val === null) return null;
            $v = is_string($val) ? strtolower($val) : $val;
            if ($v === 0 || $v === '0' || $v === 'kendaraan') return 'kendaraan';
            if ($v === 1 || $v === '1' || $v === 'ruangan')   return 'ruangan';
            return (string)$val;
        };

        // dd($rows);

        $events = $rows->map(function ($r) use ($toIso, $mapTipe) {
            $startIso = $toIso($r->tanggal, $r->jam_mulai, false);
            $endIso   = $toIso($r->tanggal, $r->jam_selesai, true);

            return [
                'id'      => $r->id_peminjaman,
                'peminjam'      => $r->nama_pegawai,
                'status'      => $r->status,
                'title'   => 'Peminjaman',
                'start'   => $startIso,
                'end'     => $endIso,
                'allDay'  => empty($r->jam_mulai) && empty($r->jam_selesai),
                'extendedProps' => [
                    'tipe_peminjaman' => $mapTipe($r->tipe_peminjaman),
                    'tanggal'         => $r->tanggal,
                    'jam_mulai'       => $r->jam_mulai,
                    'jam_selesai'     => $r->jam_selesai,
                    'keperluan'     => $r->keperluan,
                    'no_plat'     => $r->no_plat,
                    'keterangan'     => $r->keterangan,
                    'nama_ruangan'     => $r->nama_ruangan,
                    'driver'     => $r->driver,
                    'verikator_nm'     => $r->verikator_nm,
                    'verifikator_tgl'     => $r->verifikator_tgl,
                    'verifikator_catatan'     => $r->verifikator_catatan,
                    'pengembalian_nm'     => $r->pengembalian_nm,
                    'pengembalian_tgl'     => $r->pengembalian_tgl,
                    'pengembalian_catatan'     => $r->pengembalian_catatan,
                ],
            ];
        });

        return response()->json($events);
    }
}