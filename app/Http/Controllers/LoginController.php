<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;
use Session;

class LoginController extends Controller
{

    public function index()
    {
        if(Auth::check()){
            return Redirect('/index');
        } else {
            return view('auth/login_mantis', [
                'page'      => 'Login',
                'js_script' => '/js/auth/login.js'
            ]);
            // return view('auth/login', [
            //     'page'      => 'Login',
            // ]);
        }

    }

    public function ajax_process_login(Request $request)
    {
        if($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'username'  => 'required',
                'password'  => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(implode(",",$validator->errors()->all()), 401);
            }

            \Log::info('Attempting login for user', ['username' => $request->username]);

            if(!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                \Log::warning('Login failed', ['username' => $request->username]);
                return response()->json([
                    "status"    => false,
                    "message"   => "Username dan Password Salah!"
                ], 401);
            }

            if(Auth::user()->active_st != 1){
                \Log::warning('Login failed', ['username' => $request->username]);
                return response()->json([
                    "status"    => false,
                    "message"   => "Username dan Password Salah!"
                ], 401);
            }

            return response()->json([
                'status'    => TRUE,
                'message'   => 'Login berhasil!',
                'redirect'  => url("dashboard")
            ],200);
        }
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function lupa_password()
    {
        if(Auth::check()){
            return Redirect('/index');
        } else {
            return view('auth/lupa_password', [
                'page'      => 'Lupa Password',
                'js_script' => '/js/auth/login.js'
            ]);
        }
    }

    public function lupa_password_cek_user(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'username'  => 'required|exists:tb_user,username',
            ], [
                'username.exists' => 'Username tidak ditemukan.',
                'username.required' => 'Username wajib diisi.',
            ]);
            if ($validator->fails()) {
                return response()->json(implode(",",$validator->errors()->all()), 401);
            }

            $user = User::firstWhere('username', $request->username);
            return response()->json([
                'status'    => TRUE,
                'message'   => 'Data ditemukan',
                'data'  => $user
            ],200);
        }
    }

    public function lupa_password_update_pass(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id_user'  => 'required|exists:tb_user,id_user',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Password tidak sesuai.',
                'password.min' => 'Password minimal 6 karakter.',
            ]);
            if ($validator->fails()) {
                return response()->json(implode(",",$validator->errors()->all()), 401);
            }

            $user = User::firstWhere('id_user', $request->id_user);
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json([
                'status'    => true,
            ],200);
        }
    }

}
