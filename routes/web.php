<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PeminjamanKendaraanController;
use App\Http\Controllers\RuangrapatController;
use App\Http\Controllers\LoginController;

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

Route::get('/login', [LoginController::class, 'index']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/processLogin', [LoginController::class, 'ajax_process_login']);

# End Halaman #

# Ajax Master #

    # Kendaraan
    Route::get('/masterKendaraan', [KendaraanController::class, 'page_master_kendaraan']);

    Route::get('/DTMasterKendaraan', [KendaraanController::class, 'ajax_dt_master_kendaraan']); // Tabel Master Kendaraan
    Route::get('/gtMasterKendaraan', [KendaraanController::class, 'ajax_gt_master_kendaraan']); // Get Data Master Kendaraan
    Route::post('/processMasterKendaraan', [KendaraanController::class, 'ajax_pcs_master_kendaraan']); // Proses Master Kendaraan
    Route::get('/deleteMasterKendaraan', [KendaraanController::class, 'ajax_del_master_kendaraan']); // Proses Hapus Master Kendaraan

    # RuangRapat
    Route::get('/masterRuangRapat', [RuangrapatController::class, 'page_master_ruangrapat']);

    Route::get('/DTMasterRuangRapat', [RuangrapatController::class, 'ajax_dt_master_ruangrapat']); // Table Master Ruang Rapat
    Route::get('/gtMasterRuangRapat', [RuangrapatController::class, 'ajax_gt_master_ruangrapat']); // Get Data Master Ruang Rapat
    Route::post('/processMasterRuangRapat', [RuangrapatController::class, 'ajax_pcs_master_ruangrapat']); // Proses Master Kendaraan

# End Ajax Master #

# Ajax Peminjaman #

    # Kendaraan
    Route::get('/formKendaraan', [PeminjamanKendaraanController::class, 'form_kendaraan']); // Form Kendaraan
    Route::get('/rekapitulasiKendaraan', [PeminjamanKendaraanController::class, 'rekapitulasi_kendaraan']); // Rekapitulasi Kendaraan
    Route::get('/DTRekapitulasiKendaraan', [PeminjamanKendaraanController::class, 'ajax_dt_rekapitulasi_kendaraan']); // Tabel Rekapitulasi Kendaraan
    Route::post('/processPinjamKendaraan', [PeminjamanKendaraanController::class, 'ajax_pcs_form_kendaraan']); // Proses Peminjaman Kendaraan
    Route::get('/cancelPeminjamanKendaraan', [PeminjamanKendaraanController::class, 'ajax_cancel_form_kendaraan']); // Proses Cancel Peminjaman

    Route::get('/calendarKendaraan', [PeminjamanKendaraanController::class, 'calendar_kendaraan']); // Kalender Kendaraan
    Route::get('/gtCalendarPeminjamanKendaraan', [PeminjamanKendaraanController::class, 'ajax_gt_calendar_kendaraan']); // Calendar Peminjaman
    Route::get('/gtPeminjamanKendaraan', [PeminjamanKendaraanController::class, 'ajax_gt_peminjaman_kendaraan']); // Ambil Data Peminjaman Preview
    Route::post('/processPindahPeminjaman', [PeminjamanKendaraanController::class, 'ajax_process_pindah_kendaraan']);
    
# End Ajax Peminjaman #

# Ajax Select #
Route::get('/selectKendaraan', [KendaraanController::class, 'ajax_select_kendaraan']);
# End Ajax Select #