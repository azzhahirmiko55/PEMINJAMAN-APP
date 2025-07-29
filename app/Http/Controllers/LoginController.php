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

}