<?php

namespace App\Http\Controllers;
use App\Models\Dashboard;
use App\Models\User;
use App\Models\Tb_peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public static function index()
    {
        $now   = now('Asia/Jakarta');
        $start = $now->copy()->startOfMonth()->toDateString();
        $end   = $now->copy()->endOfMonth()->toDateString();

        $user = User::join('tb_pegawai','tb_user.id_pegawai','=','tb_pegawai.id_pegawai')
            ->select('tb_user.*','tb_pegawai.*')
            ->where('tb_user.id_user', Auth::user()->id_user)
            ->first();

        $base = DB::table('tb_peminjaman as p')
            ->whereBetween(DB::raw('DATE(p.tanggal)'), [$start, $end]);
        if ($user->role === 4) {
            $base->where('p.id_peminjam', $user->id_pegawai);
        }

        $totalAll = (clone $base)->count();

        $totalApproved = (clone $base)
            ->where('p.status', 1)
            ->count();

        $totalKendaraan = (clone $base)
            ->where('p.tipe_peminjaman', 'kendaraan')
            ->count();

        $totalRuangan = (clone $base)
            ->where('p.tipe_peminjaman', 'ruangan')
            ->count();

        if ($user->role === 3) {
            $base->where('p.pengembalian_pegawai_id', $user->id_pegawai);
        }

        $totalPengembalian = (clone $base)
            ->where('p.pengembalian_st', 1)
            ->count();

        $peminjamanToday = Tb_peminjaman::leftJoin('tb_pegawai as peg', 'peg.id_pegawai', '=', 'tb_peminjaman.id_peminjam')
            ->leftJoin('tb_kendaraan as k', 'k.id_kendaraan', '=', 'tb_peminjaman.id_kendaraan')
            ->leftJoin('tb_ruang_rapat as r', 'r.id_ruangrapat', '=', 'tb_peminjaman.id_ruangan')
            ->select(
                'tb_peminjaman.*',
                'peg.*',
                'k.*',
                'r.*'
            )
            ->whereDate('tb_peminjaman.tanggal', now('Asia/Jakarta')->toDateString())
            ->when($user->role === 4, function ($q) use ($user) {
                $q->where('tb_peminjaman.id_peminjam', $user->id_pegawai);
            })
            ->when($user->role === 3, function ($q) use ($user) {
                $q->where('tb_peminjaman.status', 1);
            })
            ->orderByDesc('tb_peminjaman.tanggal')
            ->get();


        return view('dashboard_mantis', [
            "page"  => "Dashboard",
            'js_script' => 'js/peminjaman/dashboard.js',
            'totalAll'=>$totalAll,
            'totalApproved'=>$totalApproved,
            'totalKendaraan'=>$totalKendaraan,
            'totalRuangan'=>$totalRuangan,
            'peminjamanToday'=>$peminjamanToday,
            'totalPengembalian'=>$totalPengembalian,
        ]);
    }
    public static function indexuser()
    {
        // $total_peminjaman = Dashboard::query_total_peminjaman();

        // Declare an associative array
        $arr = array("bg-success","bg-info","bg-warning","bg-danger","bg-primary");

        return view('dashboard_user', [
            "page"  => "Dashboard",
            "total" => $total_peminjaman,
            "arr_bg"    => $arr,
            'js_script' => 'js/peminjaman/dashboard.js'
        ]);
    }

}