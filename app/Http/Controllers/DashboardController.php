<?php

namespace App\Http\Controllers;
use App\Models\Dashboard;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public static function index()
    {
        // $total_peminjaman = Dashboard::query_total_peminjaman();

        // Declare an associative array
        // $arr = array("bg-success","bg-info","bg-warning","bg-danger","bg-primary");

        return view('dashboard_mantis', [
            "page"  => "Dashboard",
            'js_script' => 'js/peminjaman/dashboard.js'
        ]);
        // return view('dashboard', [
        //     "page"  => "Dashboard",
        //     // "total" => $total_peminjaman,
        //     // "arr_bg"    => $arr,
        //     'js_script' => 'js/peminjaman/dashboard.js'
        // ]);
    }
    public static function indexuser()
    {
        $total_peminjaman = Dashboard::query_total_peminjaman();

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
