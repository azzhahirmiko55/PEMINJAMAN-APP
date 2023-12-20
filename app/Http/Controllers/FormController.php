<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Master;

class FormController extends Controller
{
    
    public function form_kendaraan()
    {
        return view('form/kendaraan', [
            'page'      => 'Form Peminjaman Kendaraan',
            'js_script' => 'js/form/kendaraan.js'
        ]);
    }

}
