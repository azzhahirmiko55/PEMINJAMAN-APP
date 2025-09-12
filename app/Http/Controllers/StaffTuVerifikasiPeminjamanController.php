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

class StaffTuVerifikasiPeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.verifikasi_peminjaman.index', [
            "page"  => "Data Verifikasi Peminjaman",
            'js_script' => 'js/staff/verifikasipeminjaman/index.js',
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
        $p = Tb_peminjaman::findOrFail($id);

        return response()->json([
            'id'              => $p->id,
            'status'          => (int) $p->status,     // -1 / 0 / 1
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
            'status'  => 'required|in:-1,0,1',
            'keperluan_bbm' => 'nullable|string',
            'catatan' => 'nullable|string|max:1000',
        ]);


        $user = User::join('tb_pegawai','tb_user.id_pegawai','=','tb_pegawai.id_pegawai')
            ->select('tb_user.*','tb_pegawai.*')
            ->where('tb_user.id_user', Auth::user()->id_user)
            ->first();

        // $p = Tb_peminjaman::findOrFail($id);
        // $p->status      = $data['status'];
        // $p->verifikator_catatan     = $data['catatan'] ?? null;
        // $p->id_verifikator = $user->id_pegawai;
        // $p->verifikator_tgl = now();
        // $p->save();


        DB::transaction(function () use ($id, $data, $user) {
            /** @var Tb_peminjaman $p */
            $p = Tb_peminjaman::lockForUpdate()->findOrFail($id);

            $targetStatus = (int) ($data['status'] ?? 0);
            if ($targetStatus !== 1) {
                // bukan setujui → simpan biasa
                $p->status              = $targetStatus;
                $p->verifikator_catatan = $data['catatan'] ?? null;
                $p->id_verifikator      = $user->id_pegawai;
                $p->verifikator_tgl     = now();
                $p->save();
                return;
            }

            // resource (pastikan hanya salah satu yang terisi)
            $resourceCol = $p->id_kendaraan ? 'id_kendaraan' : ($p->id_ruangan ? 'id_ruangan' : null);
            $resourceVal = $resourceCol ? $p->{$resourceCol} : null;

            // validasi waktu (format jam HH:MM[:SS] zero-padded)
            $tanggal   = $p->tanggal;
            $jamMulai  = $p->jam_mulai;
            $jamSelesai= $p->jam_selesai;
            if ($jamSelesai <= $jamMulai) {
                throw new \RuntimeException('Jam selesai harus > jam mulai.');
            }

            if ($resourceCol && $resourceVal) {
                // Cari semua peminjaman lain di TANGGAL yang sama, resource sama, dan overlap jam
                $conflictIds = Tb_peminjaman::query()
                    ->where('id_peminjaman', '!=', $p->id_peminjaman)
                    ->where('active_st', 1)
                    ->where('status', '!=', -1)
                    ->whereDate('tanggal', $tanggal)
                    ->where($resourceCol, $resourceVal)
                    // Overlap (back-to-back diizinkan): (mulai_lain < jamSelesai) AND (selesai_lain > jamMulai)
                    ->where('jam_mulai', '<', $jamSelesai)
                    ->where('jam_selesai', '>', $jamMulai)
                    ->lockForUpdate()
                    ->pluck('id_peminjaman');

                if ($conflictIds->isNotEmpty()) {
                        Tb_peminjaman::whereIn('id_peminjaman', $conflictIds)->update([
                            'status'               => -1,
                            'verifikator_catatan'  => 'Ditolak otomatis: bentrok dengan peminjaman yang lain.',
                            'id_verifikator'       => $user->id_pegawai,
                            'verifikator_tgl'      => now(),
                        ]);
                }
            }

            // setujui yang ini
            $p->status              = 1;
            $p->keperluan_bbm = $data['keperluan_bbm'] ?? null;
            $p->verifikator_catatan = $data['catatan'] ?? null;
            $p->id_verifikator      = $user->id_pegawai;
            $p->verifikator_tgl     = now();
            $p->save();
        });

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

    public function getDataStaffVerifikasiPeminjaman(Request $request)
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
}
