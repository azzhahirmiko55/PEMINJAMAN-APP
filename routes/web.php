<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RuangrapatController;

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

// Master
Route::get('/masterKendaraan', [KendaraanController::class, 'page_master_kendaraan']);
//

// Form
Route::get('/formKendaraan', [PeminjamanController::class, 'form_kendaraan']);
//

// Rekapitulasi
Route::get('/rekapitulasiKendaraan', [PeminjamanController::class, 'rekapitulasi_kendaraan']);
//
# End Halaman #

# Ajax Master #

    # Kendaraan
    Route::get('/gtMasterKendaraan', [KendaraanController::class, 'ajax_gt_master_kendaraan']);
    Route::post('/processMasterKendaraan', [KendaraanController::class, 'ajax_pcs_master_kendaraan']);
    Route::get('/deleteMasterKendaraan', [KendaraanController::class, 'ajax_del_master_kendaraan']);
    Route::get('/DTMasterKendaraan', [KendaraanController::class, 'ajax_dt_master_kendaraan']);
    Route::get('/DTRekapitulasiKendaraan', [PeminjamanController::class, 'ajax_dt_rekapitulasi_kendaraan']);
    Route::get('/cancelPeminjamanKendaraan', [PeminjamanController::class, 'ajax_cancel_form_kendaraan']);

    # RuangRapat
    Route::get('/gtMasterKendaraan', [RuangrapatController::class, 'ajax_gt_master_ruangrapat']);

# End Ajax Master #

# Ajax Form #
Route::post('/processPinjamKendaraan', [PeminjamanController::class, 'ajax_pcs_form_kendaraan']);
# End Ajax Master #

# Ajax Select #
Route::get('/selectKendaraan', [KendaraanController::class, 'ajax_select_kendaraan']);
# End Ajax Select #