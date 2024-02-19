<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;
use Session;

class LoginController extends Controller
{
    
    public function index()
    {
        if(Auth::check()){
            return Redirect('home');
        } else {
            return view('auth/login', [
                'page'      => 'Login',
                'js_script' => '/js/auth/login.js' 
            ]);
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

            if(!Auth::attempt($request->only(["username", "password"]))) {
                return response()->json([
                    "status"    => false,
                    "message"   => "Invalid credentials"
                ], 401);
            }

            return response()->json([
                'status'    => TRUE,
                'message'   => 'Login berhasil!',
                'redirect'  => url("index")
            ],200);
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }

}
