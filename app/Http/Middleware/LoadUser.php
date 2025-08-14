<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoadUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         if (Auth::check()) {
            $user = User::join('tb_pegawai', 'tb_user.id_pegawai', '=', 'tb_pegawai.id_pegawai')
                ->select('tb_user.*', 'tb_pegawai.*')
                ->where('tb_user.id_user', Auth::user()->id_user)
                ->first();

            $request->attributes->set('fullUser', $user);

            auth()->setUser($user);
        }

        return $next($request);
    }
}