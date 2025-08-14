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
                                        ->where('tb_peminjaman.status', 1)
                                        ->where('tb_peminjaman.tipe_peminjaman', 'kendaraan');
                                })
                                ->whereNull('tb_peminjaman.id_peminjaman')
                                ->select('tb_kendaraan.*')
                                ->orderBy('no_plat', 'ASC')
                                ->get();
        $dRuangan = Ruangan::where('tb_ruang_rapat.active_st', 1)
                            ->leftJoin('tb_peminjaman', function($join) use ($tanggal_calendar) {
                                $join->on('tb_ruang_rapat.id_ruangrapat', '=', 'tb_peminjaman.id_ruangan')
                                    ->whereDate('tb_peminjaman.tanggal', $tanggal_calendar)
                                    ->where('tb_peminjaman.status', 1)
                                    ->where('tb_peminjaman.tipe_peminjaman', 'ruangan');
                            })
                            ->whereNull('tb_peminjaman.id_peminjaman')
                            ->select('tb_ruang_rapat.*')
                            ->orderBy('nama_ruangan', 'ASC')
                            ->get();
        return view('pegawai.peminjaman.form_modal',compact('dPegawaiPeminjamanKendaraan','dPegawaiPeminjamanRuangan','dPegawai','dKendaraan','dRuangan','tanggal_calendar'));
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
            'jumlah_peserta' => 'nullable|numeric',
            'keperluan' => 'required',
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
        $PegawaiPeminjaman->id_peminjam = $request->id_peminjam;
        $PegawaiPeminjaman->id_kendaraan = $request->id_kendaraan;
        $PegawaiPeminjaman->id_ruangan = $request->id_ruangan;
        $PegawaiPeminjaman->tipe_peminjaman = $request->tipe_peminjaman;
        $PegawaiPeminjaman->tanggal = $request->tanggal;
        $mulai = Carbon::createFromFormat('Y-m-d H:i', "{$request->tanggal} {$request->jam_mulai}");
        $selesai = Carbon::createFromFormat('Y-m-d H:i', "{$request->tanggal} {$request->jam_selesai}");
        $PegawaiPeminjaman->jam_mulai = $mulai;
        $PegawaiPeminjaman->jam_selesai = $selesai;
        $PegawaiPeminjaman->keperluan = $request->keperluan;
        $PegawaiPeminjaman->driver = $request->driver;
        $PegawaiPeminjaman->jumlah_peserta = $request->jumlah_peserta;
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
                            ->leftJoin('tb_pegawai', 'tb_peminjaman.id_peminjam', '=', 'tb_pegawai.id_pegawai')
                            ->select(
                                'tb_peminjaman.*',
                                'tb_kendaraan.no_plat',
                                'tb_kendaraan.keterangan',
                                'tb_ruang_rapat.nama_ruangan',
                                'tb_pegawai.nama_pegawai',
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
                ],
            ];
        });

        return response()->json($events);
    }
}