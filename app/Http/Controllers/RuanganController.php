<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dRuangan =  Ruangan::orderBy('nama_ruangan', 'ASC')->get();
        return view('admin.ruangan.index', [
            "page"  => "Master ruangan",
            'js_script' => 'js/admin/ruangan/index.js',
            'data_ruangan' => $dRuangan,
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
         $dRuangan = [];
        if($id != 'add'){
            $dRuangan = Ruangan::find($id);
        }
        return view('admin.ruangan.form_modal',compact('dRuangan'));
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
            'nama_ruangan' => 'required|string|max:255',
            'warna_ruangan' => 'nullable|string|max:255|regex:/^[a-zA-Z\s\'`]+$/u',
        ]);
        if($id === 'add'){// Tambah data
            $ruangan = new Ruangan();
        }else { // Edit Data
            $ruangan = Ruangan::findOrFail($id);
        }
        $ruangan->nama_ruangan     = $request->nama_ruangan;
        $ruangan->warna_ruangan     = $request->warna_ruangan;
        $ruangan->save();

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function update_status(Request $request)
    {
        $ruangan = Ruangan::findOrFail($request->id);
        $ruangan->active_st = $request->current_status == 1 ? 0 : 1;
        $ruangan->save();

        return response()->json([
            'status' => true,
            'message' => 'Status berhasil diperbarui.'
        ]);
    }
}
