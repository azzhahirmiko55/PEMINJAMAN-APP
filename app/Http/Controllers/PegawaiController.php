<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dPegawai =  Pegawai::orderBy('nama_pegawai', 'ASC')->get();
        return view('admin.pegawai.index', [
            "page"  => "Master Pegawai",
            'js_script' => 'js/admin/pegawai/index.js',
            'data_pegawai' => $dPegawai,
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
        $dPegawai = [];
        if($id != 'add'){
            $dPegawai = Pegawai::find($id);
        }
        return view('admin.pegawai.form_modal',compact('dPegawai'));
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
            'nama_pegawai' => 'required|string|max:255|regex:/^[a-zA-Z\s\'`]+$/u',
            'jabatan' => 'required|in:Kasubag,Staff TU,Satpam,Pegawai BPN',
            'jenis_kelamin' => 'required|in:0,1',
        ]);
        if($id === 'add'){// Tambah data
            $pegawai = new Pegawai();
        }else { // Edit Data
            $pegawai = Pegawai::findOrFail($id);
        }
        $pegawai->nama_pegawai     = $request->nama_pegawai;
        $pegawai->jabatan     = $request->jabatan;
        $pegawai->jenis_kelamin     = $request->jenis_kelamin;
        $pegawai->save();

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
        $pegawai = Pegawai::findOrFail($request->id);
        $pegawai->active_st = $request->current_status == 1 ? 0 : 1;
        $pegawai->save();

        return response()->json([
            'status' => true,
            'message' => 'Status berhasil diperbarui.'
        ]);
    }
}