<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = User::join('tb_pegawai','tb_user.id_pegawai','=','tb_pegawai.id_pegawai')
                        ->select('tb_user.*','tb_pegawai.*')
                        ->where('tb_user.id_user', Auth::user()->id_user)
                        ->first();

            $view->with('user', $user);
        }
    });
    }
}
