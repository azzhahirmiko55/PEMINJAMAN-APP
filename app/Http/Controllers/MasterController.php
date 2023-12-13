<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{

    public function master_kendaraan()
    {
        return view('master/kendaraan', [
            "page"  => "Master Kendaraan"
        ]);
    }

}
