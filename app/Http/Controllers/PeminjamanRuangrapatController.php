<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\PeminjamanRuangrapat;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class PeminjamanRuangrapatController extends Controller
{
    
    public function calendar_ruangrapat()
    {
        if(Auth::check()){
            return view('peminjaman/auth/ckendaraan', [
                'page'      => 'Kalender Peminjaman Kendaraan',
                'js_script' => 'js/peminjaman/auth/ckendaraan.js'
            ]);
        } else {
             return view('peminjaman/cruangrapat', [
                'page'      => 'Kalender Peminjaman Ruang Rapat',
                'js_script' => 'js/peminjaman/cruangrapat.js'
            ]);
        }
    }

}
