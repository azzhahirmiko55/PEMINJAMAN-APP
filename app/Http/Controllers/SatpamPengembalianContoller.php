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

class SatpamPengembalianContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('satpam.pengembalian.index', [
            "page"  => "Data Pengembalian",
            'js_script' => 'js/satpam/pengembalian/index.js',
            // 'dRiwayat' => $dRiwayat,
            // 'filter' => $filter,
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
        $p = Tb_peminjaman::findOrFail($id);

        return response()->json([
            'id'              => $p->id,
            'status'          => (int) $p->status,     // -1 / 0 / 1
            'pengembalian_st'          => (int) $p->pengembalian_st,     // -1 / 0 / 1
            'catatan'         => $p->catatan ?? '',
            'tipe_peminjaman' => $p->tipe_peminjaman,
            'peminjam'        => $p->peminjam,         // sesuaikan fieldmu
            'start'           => $p->start,
            'end'             => $p->end,
        ]);
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
        $data = $request->validate([
                    'pengembalian_st'  => 'required|in:0,1',
                    'catatan' => 'nullable|string|max:1000',
                ]);


        $user = User::join('tb_pegawai','tb_user.id_pegawai','=','tb_pegawai.id_pegawai')
            ->select('tb_user.*','tb_pegawai.*')
            ->where('tb_user.id_user', Auth::user()->id_user)
            ->first();

        $p = Tb_peminjaman::findOrFail($id);
        $p->pengembalian_st      = $data['pengembalian_st'];
        $p->pengembalian_catatan     = $data['catatan'] ?? null;
        $p->pengembalian_pegawai_id = $user->id_pegawai;
        $p->pengembalian_tgl = now();
        $p->save();
        return response()->json(['ok' => true]);
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

    public function getDataSatpamPengembalian(Request $request)
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
        $type = $request->query('type')?$request->query('type'):null;

        $q = Tb_peminjaman::leftJoin('tb_kendaraan', 'tb_peminjaman.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
                            ->leftJoin('tb_ruang_rapat', 'tb_peminjaman.id_ruangan', '=', 'tb_ruang_rapat.id_ruangrapat')
                            ->leftJoin('tb_pegawai  as peminjam', 'tb_peminjaman.id_peminjam', '=', 'peminjam.id_pegawai')
                            ->leftJoin('tb_pegawai  as pengembalian', 'tb_peminjaman.pengembalian_pegawai_id', '=', 'pengembalian.id_pegawai')
                            ->leftJoin('tb_pegawai as ve', 'tb_peminjaman.id_verifikator', '=', 've.id_pegawai')
                            ->select(
                                'tb_peminjaman.*',
                                'tb_kendaraan.no_plat',
                                'tb_kendaraan.keterangan',
                                'tb_ruang_rapat.nama_ruangan',
                                'peminjam.nama_pegawai as peminjam_nm',
                                'pengembalian.nama_pegawai as pengembali_nm',
                                've.nama_pegawai as verikator_nm',
                            )
                            ->where('tb_peminjaman.active_st', 1)
                            ->where('tb_peminjaman.status', 1)
                            ->where('tb_peminjaman.tipe_peminjaman', 'kendaraan')
                            ;

        // if(isset($tanggal)){
        if($type == 'get'){
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
                'peminjam'      => $r->peminjam_nm,
                'pengembali'      => $r->pengembali_nm,
                'status'      => $r->status,
                'pengembalian_st'      => $r->pengembalian_st,
                'title'   => 'Peminjaman',
                'start'   => $startIso,
                'end'     => $endIso,
                'allDay'  => empty($r->jam_mulai) && empty($r->jam_selesai),
                'extendedProps' => [
                    'tipe_peminjaman' => $mapTipe($r->tipe_peminjaman),
                    'tanggal'         => $r->tanggal||$tanggal,
                    'jam_mulai'       => $r->jam_mulai,
                    'jam_selesai'     => $r->jam_selesai,
                    'keperluan'     => $r->keperluan,
                    'no_plat'     => $r->no_plat,
                    'keterangan'     => $r->keterangan,
                    'nama_ruangan'     => $r->nama_ruangan,
                    'driver'     => $r->driver,
                    'pengembalian_catatan'     => $r->pengembalian_catatan,
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