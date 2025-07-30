<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dUser = User::leftJoin('tb_pegawai', 'tb_user.id_pegawai', '=', 'tb_pegawai.id_pegawai')
                        ->select('tb_user.*', 'tb_pegawai.nama_pegawai')
                        ->get();
        return view('admin.user.index', [
            "page"  => "Master User",
            'js_script' => 'js/admin/user/index.js',
            'data_user' => $dUser,
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
        $dPegawai = Pegawai::leftJoin('tb_user', 'tb_user.id_pegawai', '=', 'tb_pegawai.id_pegawai')
                            ->where('tb_pegawai.active_st', 1)
                            ->whereNull('tb_user.id_pegawai')
                            ->select('tb_pegawai.*')
                            ->orderBy('nama_pegawai','ASC')
                            ->get();
        $dUser = [];
        if($id != 'add'){
            $dUser = User::find($id);
            $dPegawai =Pegawai::all()->where('active_st',1);
        }
        return view('admin.user.form_modal',compact('dUser','dPegawai'));
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
            'username' => 'required|string|max:255',
            'id_pegawai' => 'required|exists:tb_pegawai,id_pegawai',
            'role' => 'required|numeric|in:0,1,2,3,4',
            'password' => 'nullable|min:6|confirmed',
        ]);
        if($id === 'add'){// Tambah data
            $request->validate([
                'password' => 'required',
            ]);
            $user = new User();
            $user->password = Hash::make($request->password);
        }else { // Edit Data
            $user = User::findOrFail($id);
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
        }
        $user->username = $request->username;
        $user->id_pegawai     = $request->id_pegawai;
        $user->role     = $request->role;
        $user->save();

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
        $user = User::findOrFail($request->id);
        $user->active_st = $request->current_status == 1 ? 0 : 1;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Status berhasil diperbarui.'
        ]);
    }
}
