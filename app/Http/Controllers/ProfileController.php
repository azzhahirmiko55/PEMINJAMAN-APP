<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::join('tb_pegawai','tb_user.id_pegawai','=','tb_user.id_pegawai')
            ->select('tb_user.*','tb_pegawai.*')
            ->where('tb_user.id_user',Auth::User()->id_user)
            ->first();
        return view('modal.profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::User()->id_user);
        $pegawai = Pegawai::find(Auth::User()->id_pegawai);
        $request->validate([
            'nama_pegawai' => 'required|regex:/^[a-zA-Z\s\'`]+$/u|max:255',

            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);
        $pegawai->nama_pegawai = $request->input('nama_pegawai');
        $pegawai->save();

        $user->password = Hash::make($request->input('password'));
        $user->save();
        // $user->email = $request->input('email');
        // // Add other fields as necessary

        // if ($request->hasFile('profile_picture')) {
        //     $file = $request->file('profile_picture');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('images/profile'), $filename);
        //     $user->profile_picture = 'images/profile/' . $filename;
        // }


        return response()->json(['success' => true, 'message' => 'Profile berhasil diperbarui']);
    }

}