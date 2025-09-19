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
use Illuminate\Support\Facades\DB;

class PegawaiPeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pegawai.peminjaman.index', [
            "page"  => "Data Peminjaman",
            'js_script' => 'js/pegawai/peminjaman/index.js',
            // 'data_pegawai' => $dPegawai,
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
        if (!Auth::check()) {
            return response()->json([], 401);
        }
        $tanggal_calendar = request()->query('tanggal');
        $type = request()->query('type');

        $user = User::join('tb_pegawai','tb_user.id_pegawai','=','tb_pegawai.id_pegawai')
            ->select('tb_user.*','tb_pegawai.*')
            ->where('tb_user.id_user', Auth::user()->id_user)
            ->first();

        $dPegawaiPeminjamanKendaraan = [];
        $dPegawaiPeminjamanRuangan = [];

        $dPegawaiPeminjamanKendaraan = Tb_peminjaman::where('id_peminjam', $user->id_pegawai)
            ->whereDate('tanggal', $tanggal_calendar)
            ->where('tipe_peminjaman', 'kendaraan')
            ->latest('id_peminjaman')
            ->first();


        $dPegawaiPeminjamanRuangan = Tb_peminjaman::where('id_peminjam', $user->id_pegawai)
            ->whereDate('tanggal', $tanggal_calendar)
            ->where('tipe_peminjaman', 'ruangan')
            ->latest('id_peminjaman')
            ->first();

        $dPegawai = Pegawai::leftJoin('tb_user', 'tb_user.id_pegawai', '=', 'tb_pegawai.id_pegawai')
                            ->where('tb_pegawai.active_st', 1)
                            ->whereNull('tb_user.id_pegawai')
                            ->select('tb_pegawai.*')
                            ->orderBy('nama_pegawai','ASC')
                            ->get();
        $dKendaraan = KendaraanV2::where('tb_kendaraan.active_st', 1)
                                ->leftJoin('tb_peminjaman', function($join) use ($tanggal_calendar) {
                                    $join->on('tb_kendaraan.id_kendaraan', '=', 'tb_peminjaman.id_kendaraan')
                                        ->whereDate('tb_peminjaman.tanggal', $tanggal_calendar)
                                        ->where('tb_peminjaman.tipe_peminjaman', 'kendaraan');
                                })
                                // ->whereNull('tb_peminjaman.id_peminjaman')
                                ->select('tb_kendaraan.*')
                                ->orderBy('no_plat', 'ASC')
                                ->get();
        if (empty($dPegawaiPeminjamanKendaraan)) {
            $dKendaraan->where('tb_peminjaman.status', 1);
        }
        $dRuangan = Ruangan::where('tb_ruang_rapat.active_st', 1)
                            ->leftJoin('tb_peminjaman', function($join) use ($tanggal_calendar) {
                                $join->on('tb_ruang_rapat.id_ruangrapat', '=', 'tb_peminjaman.id_ruangan')
                                    ->whereDate('tb_peminjaman.tanggal', $tanggal_calendar)
                                    ->where('tb_peminjaman.status', 1)
                                    ->where('tb_peminjaman.tipe_peminjaman', 'ruangan');
                            })
                            // ->whereNull('tb_peminjaman.id_peminjaman')
                            ->select('tb_ruang_rapat.*')
                            ->orderBy('nama_ruangan', 'ASC')
                            ->get();
        if (empty($dPegawaiPeminjamanRuangan)) {
            $dRuangan->where('tb_peminjaman.status', 1);
        }
        return view('pegawai.peminjaman.form_modal',compact('dPegawaiPeminjamanKendaraan','dPegawaiPeminjamanRuangan','dPegawai','dKendaraan','dRuangan','tanggal_calendar','type'));
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
        $request->validate([
            'id_peminjam' => 'required|exists:tb_pegawai,id_pegawai',
            'tipe_peminjaman' => 'required|in:kendaraan,ruangan',
            'id_kendaraan' => 'nullable|exists:tb_kendaraan,id_kendaraan',
            'id_ruangan' => 'nullable|exists:tb_ruang_rapat,id_ruangrapat',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'driver' => 'nullable|string',
            'jumlah_peserta' => 'nullable',
            'keperluan_bbm' => 'nullable',
            'keperluan_option' => 'required',
            'detail_lokasi' => 'nullable',
        ]);
        if($request->tipe_peminjaman === '1'){
            $request->validate([
                'jumlah_peserta' => 'required',
            ]);
        }
        if($id === 'add'){// Tambah data
            $PegawaiPeminjaman = new Tb_peminjaman();
            $PegawaiPeminjaman->status = 0;
        }else { // Edit Data
            $PegawaiPeminjaman = Tb_peminjaman::findOrFail($id);
        }
        // dd($request->keperluan_lain);
        $PegawaiPeminjaman->id_peminjam = $request->id_peminjam;
        $PegawaiPeminjaman->id_kendaraan = $request->id_kendaraan;
        $PegawaiPeminjaman->id_ruangan = $request->id_ruangan;
        $PegawaiPeminjaman->tipe_peminjaman = $request->tipe_peminjaman;
        $PegawaiPeminjaman->tanggal = $request->tanggal;
        $mulai = Carbon::createFromFormat('Y-m-d H:i', "{$request->tanggal} {$request->jam_mulai}");
        $selesai = Carbon::createFromFormat('Y-m-d H:i', "{$request->tanggal} {$request->jam_selesai}");
        $PegawaiPeminjaman->jam_mulai = $mulai;
        $PegawaiPeminjaman->jam_selesai = $selesai;
        $PegawaiPeminjaman->keperluan = $request->keperluan_option !== "__LAIN__"?$request->keperluan_option:$request->keperluan_lain;
        $PegawaiPeminjaman->keperluan_bbm = $request->keperluan_bbm;
        $PegawaiPeminjaman->driver = $request->driver;
        $PegawaiPeminjaman->jumlah_peserta = $request->jumlah_peserta;
        $PegawaiPeminjaman->detail_lokasi = $request->detail_lokasi;
        $PegawaiPeminjaman->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil disimpan!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Tb_peminjaman::find($id);
        $data->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function getDataPegawaiPeminjaman(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([], 401);
        }

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

        $q = Tb_peminjaman::where('id_peminjam', $user->id_pegawai)
                            ->leftJoin('tb_kendaraan', 'tb_peminjaman.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
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
                    'keperluan_bbm'     => $r->keperluan_bbm,
                ],
            ];
        });

        return response()->json($events);
    }

    public function getKetersediaan($type,$date){
        // dd($type,$date);
        // $main = [];
        // $dKendaraan = KendaraanV2::where('tb_kendaraan.active_st', 1)
        //                         ->leftJoin('tb_peminjaman', function($join) use ($date) {
        //                             $join->on('tb_kendaraan.id_kendaraan', '=', 'tb_peminjaman.id_kendaraan')
        //                                 ->whereDate('tb_peminjaman.tanggal', $date)
        //                                 // ->where('tb_peminjaman.status', 1)
        //                                 ->where('tb_peminjaman.tipe_peminjaman', 'kendaraan');
        //                         })
        //                         // ->whereNull('tb_peminjaman.id_peminjaman')
        //                         ->select('tb_kendaraan.*','tb_peminjaman.*')
        //                         // ->orderBy('no_plat', 'ASC')
        //                         ->orderBy('jenis_kendaraan', 'ASC')
        //                         ->get();
        // $dRuangan = Ruangan::where('tb_ruang_rapat.active_st', 1)
        //                     ->leftJoin('tb_peminjaman', function($join) use ($date) {
        //                         $join->on('tb_ruang_rapat.id_ruangrapat', '=', 'tb_peminjaman.id_ruangan')
        //                             ->whereDate('tb_peminjaman.tanggal', $date)
        //                             // ->where('tb_peminjaman.status', 1)
        //                             ->where('tb_peminjaman.tipe_peminjaman', 'ruangan');
        //                     })
        //                     // ->whereNull('tb_peminjaman.id_peminjaman')
        //                     ->select('tb_ruang_rapat.*','tb_peminjaman.*')
        //                     ->orderBy('nama_ruangan', 'ASC')
        //                     ->get();
        // if($type === 'kendaraan'){
        //     $main = $dKendaraan;
        // }else if ($type === 'ruangan'){
        //     $main = $dRuangan;
        // }

        // return view('pegawai.peminjaman.form_ketersediaan',compact('main','date','type'));

        // window 07:00–15:00
        $windowStart = '07:00:00';
        $windowEnd   = '17:00:00';

        if ($type === 'kendaraan') {
            $resources = KendaraanV2::where('tb_kendaraan.active_st', 1)
                ->select('tb_kendaraan.id_kendaraan as id','tb_kendaraan.no_plat','tb_kendaraan.jenis_kendaraan')
                ->orderBy('jenis_kendaraan','ASC')
                ->get();
            $fk = 'id_kendaraan';
            $tipePinjam = 'kendaraan';
            $makeLabel = function($r){ return ($r->no_plat).' - '.($r->jenis_kendaraan); };
        } else {
            $resources = Ruangan::where('tb_ruang_rapat.active_st', 1)
                ->select('tb_ruang_rapat.id_ruangrapat as id','tb_ruang_rapat.nama_ruangan','tb_ruang_rapat.warna_ruangan')
                ->orderBy('nama_ruangan','ASC')
                ->get();
            $fk = 'id_ruangan';
            $tipePinjam = 'ruangan';
            $makeLabel = function($r){ return ($r->nama_ruangan).' - '.($r->warna_ruangan); };
        }

        // AMBIL BOOKING: hanya kolom yang ADA di tabel Anda
       $bookingsAll = DB::table('tb_peminjaman')
                        ->leftJoin('tb_pegawai as pe', 'pe.id_pegawai', '=', 'tb_peminjaman.id_peminjam')
                        // ->leftJoin('tb_pegawai as ve', 've.id_pegawai', '=', 'tb_peminjaman.id_verifikator')
                        // ->leftJoin('tb_pegawai as png', 'png.id_pegawai', '=', 'tb_peminjaman.pengembalian_pegawai_id')
                        ->whereDate('tb_peminjaman.tanggal', $date)
                        ->where('tb_peminjaman.tipe_peminjaman', $tipePinjam)
                        ->select(
                            'tb_peminjaman.id_peminjaman',
                            DB::raw("tb_peminjaman.$fk as $fk"), // penting: nama kolom tetap id_kendaraan/id_ruangan
                            'tb_peminjaman.jam_mulai',
                            'tb_peminjaman.jam_selesai',
                            'tb_peminjaman.id_peminjam',
                            DB::raw('pe.nama_pegawai as nama_peminjam')
                            // (opsional)
                            // , DB::raw('ve.nama_pegawai as nama_verifikator')
                            // , DB::raw('png.nama_pegawai as nama_pengembali')
                        )
                        ->get()
                        ->groupBy($fk);


        // helper ambil menit dari kolom datetime/time
        $toMin = function($t){
            if (!$t) return null;
            // dukung format 'HH:MM:SS' atau 'YYYY-MM-DD HH:MM:SS'
            $time = strlen($t) >= 16 ? substr($t, 11, 5) : substr($t, 0, 5);
            [$h,$m] = array_pad(explode(':', $time), 2, '00');
            return ((int)$h)*60 + (int)$m;
        };
        $winS = $toMin($windowStart);
        $winE = $toMin($windowEnd);

        $tersedia = [];
        $terbatas = [];
        $terpakai = [];

        foreach ($resources as $r) {
            $label = $makeLabel($r);

            $bks = ($bookingsAll->get($r->id) ?? collect())->map(function($b) use ($toMin,$winS,$winE){
                $s = max($toMin($b->jam_mulai), $winS);
                $e = min($toMin($b->jam_selesai), $winE);
                return ($e > $s) ? [
                    'id'          => $b->id_peminjaman,
                    // belum ada nama → pakai placeholder; ganti via join jika perlu
                    'peminjam'    => $b->nama_peminjam,
                    'jam_mulai'   => (strlen($b->jam_mulai) >= 16 ? substr($b->jam_mulai,11,5) : substr($b->jam_mulai,0,5)),
                    'jam_selesai' => (strlen($b->jam_selesai) >= 16 ? substr($b->jam_selesai,11,5) : substr($b->jam_selesai,0,5)),
                    's' => $s, 'e' => $e,
                ] : null;
            })->filter()->values()->all();

            if (empty($bks)) {
                $tersedia[] = ['label'=>$label, 'bookings'=>[]];
                continue;
            }

            // merge intervals
            usort($bks, fn($a,$b)=> $a['s'] <=> $b['s']);
            $merged = [];
            foreach ($bks as $bk) {
                if (empty($merged)) { $merged[] = [$bk['s'],$bk['e']]; continue; }
                $last = $merged[count($merged)-1];
                if ($bk['s'] <= $last[1]) {
                    $merged[count($merged)-1] = [$last[0], max($last[1], $bk['e'])];
                } else {
                    $merged[] = [$bk['s'],$bk['e']];
                }
            }

            // cek coverage penuh 07–15
            $cursor = $winS;
            foreach ($merged as $m) {
                if ($m[0] > $cursor) break;   // ada celah
                $cursor = max($cursor, $m[1]);
                if ($cursor >= $winE) break; // sudah penuh
            }
            if ($cursor >= $winE) {
                $terpakai[] = ['label'=>$label, 'bookings'=>$bks];
            } else {
                $terbatas[] = ['label'=>$label, 'bookings'=>$bks];
            }
        }

        return view('pegawai.peminjaman.form_ketersediaan', compact(
            'type','date','tersedia','terbatas','terpakai','windowStart','windowEnd'
        ));
    }
}