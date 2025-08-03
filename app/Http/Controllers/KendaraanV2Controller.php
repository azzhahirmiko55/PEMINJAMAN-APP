<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KendaraanV2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class KendaraanV2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dKendaraan =  KendaraanV2::orderBy('created_at', 'DESC')->get();
        return view('admin.kendaraan.index', [
            "page"  => "Master Kendaraan",
            'js_script' => 'js/admin/kendaraan/index.js',
            'data_kendaraan' => $dKendaraan,
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
        $dKendaraan = [];
        if($id != 'add'){
            $dKendaraan = KendaraanV2::find($id);
        }
        return view('admin.kendaraan.form_modal',compact('dKendaraan'));
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
            'no_plat' => 'required|max:255',
            'jenis_kendaraan' => 'required|in:Roda-2,Roda-4',
            'warna_kendaraan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);
        if($id === 'add'){// Tambah data
            $request->validate([
                'no_plat' => 'unique:tb_kendaraan,no_plat',
            ]);
            $kendaraan = new KendaraanV2();
        }else { // Edit Data
            $kendaraan = KendaraanV2::findOrFail($id);
        }
        $kendaraan->no_plat     = $request->no_plat;
        $kendaraan->jenis_kendaraan     = $request->jenis_kendaraan;
        $kendaraan->warna_kendaraan     = $request->warna_kendaraan;
        $kendaraan->keterangan     = $request->keterangan;
        $kendaraan->save();

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
        $kendaraan = KendaraanV2::findOrFail($request->id);
        $kendaraan->active_st = $request->current_status == 1 ? 0 : 1;
        $kendaraan->save();

        return response()->json([
            'status' => true,
            'message' => 'Status berhasil diperbarui.'
        ]);
    }
}