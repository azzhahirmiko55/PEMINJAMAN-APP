<?php

use App\Http\Controllers\MasterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# Halaman #

Route::get('/', [DashboardController::class, 'index']);

Route::get('/master_kendaraan', [MasterController::class, 'master_kendaraan']);

# End Halaman #

# Ajax Master #

Route::post('/ajaxProsesMasterKendaraan', [MasterController::class, 'ajax_proses_master_kendaraan']);

# End Ajax Master #