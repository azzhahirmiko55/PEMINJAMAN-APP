<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [DashboardController::class, 'index']);

# Halaman #

Route::get('/index', [DashboardController::class, 'index']);

Route::get('/masterKendaraan', [MasterController::class, 'master_kendaraan']);

# End Halaman #

# Ajax Master #
Route::get('/gtMasterKendaraan', [MasterController::class, 'ajax_gt_master_kendaraan']);
Route::post('/processMasterKendaraan', [MasterController::class, 'ajax_pcs_master_kendaraan']);
Route::get('/deleteMasterKendaraan', [MasterController::class, 'ajax_del_master_kendaraan']);
Route::get('/DTMasterKendaraan', [MasterController::class, 'ajax_dt_master_kendaraan']);
# End Ajax Master #

# Ajax Form #
Route::get('/formKendaraan', [FormController::class, 'form_kendaraan']);
Route::post('/processPinjamKendaraan', [FormController::class, 'ajax_pcs_form_kendaraan']);
# End Ajax Master #

# Ajax Select #
Route::get('/selectKendaraan', [MasterController::class, 'ajax_select_kendaraan']);
# End Ajax Select #