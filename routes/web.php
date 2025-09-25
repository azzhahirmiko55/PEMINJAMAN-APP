<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PeminjamanKendaraanController;
use App\Http\Controllers\RuangrapatController;
use App\Http\Controllers\PeminjamanRuangrapatController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserPLoginController;
use App\Models\RekapitulasiKendaraanExport;
use Maatwebsite\Excel\Facades\Excel;
// Start Global Session
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FilterController;
// End Global Session

// Start Admin Session
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\KendaraanV2Controller;
// End Admin Session
// Start Pegawai Session
use App\Http\Controllers\PegawaiPeminjamanController;
// End Pegawai Session
// Start Staff TU Session
use App\Http\Controllers\StaffTuVerifikasiPeminjamanController;
use App\Http\Controllers\StaffTuRiwayatPeminjamanController;
use App\Http\Controllers\StaffTUPelaporanPeminjamanController;
// End Staff TU Session
// Start Satpam Session
use App\Http\Controllers\SatpamPengembalianContoller;
use App\Http\Controllers\SatpamLaporanPengembalianController;
// End Satpam Session
// Start Kasubag Session
use App\Http\Controllers\KasubagDataPeminjamanController;
// End Kasubag Session


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

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('IsLogout');


Route::get('/login', [LoginController::class, 'index'])->middleware('IsLogout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/processLogin', [LoginController::class, 'ajax_process_login']);
Route::get('/lupa_password', [LoginController::class, 'lupa_password'])->middleware('IsLogout');
Route::post('/lupa_password_cek_user', [LoginController::class, 'lupa_password_cek_user'])->middleware('IsLogout');
Route::post('/lupa_password_update_pass', [LoginController::class, 'lupa_password_update_pass'])->middleware('IsLogout');

# Start Halaman Dashboard #
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('IsLogin');
# End Halaman Dashboard #
# Start Profile Modal #
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.modal')->middleware('IsLogin');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('IsLogin');
# End Profile Modal #
# Start Search #
Route::post('/filter/save',  [FilterController::class, 'save'])->name('filter.save');
Route::post('/filter/reset', [FilterController::class, 'reset'])->name('filter.reset');
# End Search #

# Start Admin Session #
# User Session #
Route::resource('user', UserController::class)->name('index', 'user')->middleware(['IsLogin','IsAdmin']);
Route::post('/user/update_status', [UserController::class, 'update_status'])->name('user.status')->middleware(['IsLogin','IsAdmin']);
Route::post('/user/reset_password', [UserController::class, 'reset_password'])->name('user.reset_password')->middleware(['IsLogin','IsAdmin']);
# Pegawai Session #
Route::resource('pegawai', PegawaiController::class)->name('index', 'pegawai')->middleware(['IsLogin','IsAdmin']);
Route::post('/pegawai/update_status', [PegawaiController::class, 'update_status'])->name('pegawai.status')->middleware(['IsLogin','IsAdmin']);
# Ruangan Session #
Route::resource('ruangan', RuanganController::class)->name('index', 'ruangan')->middleware(['IsLogin','IsAdmin']);
Route::post('/ruangan/update_status', [RuanganController::class, 'update_status'])->name('ruangan.status')->middleware(['IsLogin','IsAdmin']);
# Kendaraan Session #
Route::resource('kendaraan', KendaraanV2Controller::class)->name('index', 'kendaraan')->middleware(['IsLogin','IsAdmin']);
Route::post('/kendaraan/update_status', [KendaraanV2Controller::class, 'update_status'])->name('kendaraan.status')->middleware(['IsLogin','IsAdmin']);
Route::resource('admin-pelaporan-peminjaman', StaffTUPelaporanPeminjamanController::class)->name('index', 'admin.pelaporan.peminjaman')->middleware(['IsLogin','IsAdmin']);
Route::post('/admin/pelaporan/peminjaman/export-ruangan', [StaffTUPelaporanPeminjamanController::class, 'exportRuangan'])
    ->name('admin.pelaporan.peminjaman.export_ruangan')
    ->middleware(['IsLogin','IsAdmin']);
Route::post('/admin/pelaporan/peminjaman/export-kendaraan', [StaffTUPelaporanPeminjamanController::class, 'exportKendaraan'])
    ->name('admin.pelaporan.peminjaman.export_kendaraan')
    ->middleware(['IsLogin','IsAdmin']);
# End Admin Session #

# Start Pegawai Session #
Route::resource('pegawai-peminjaman', PegawaiPeminjamanController::class)->name('index', 'pegawai.peminjaman')->middleware(['IsLogin','IsPegawai']);
Route::get('/getDataPegawaiPeminjaman', [PegawaiPeminjamanController::class, 'getDataPegawaiPeminjaman'])->middleware(['IsLogin','IsPegawai']);
Route::get('/getKetersediaan/{type}/{date}', [PegawaiPeminjamanController::class, 'getKetersediaan'])->middleware(['IsLogin','IsPegawai']);
# End Pegawai Session #

# Start Staff TU Session #
Route::resource('staff-verifikasi-peminjaman', StaffTuVerifikasiPeminjamanController::class)->name('index', 'staff.verifikasi.peminjaman')->middleware(['IsLogin','IsStaff']);
Route::get('/getDataStaffVerifikasiPeminjaman', [StaffTuVerifikasiPeminjamanController::class, 'getDataStaffVerifikasiPeminjaman'])->middleware(['IsLogin','IsStaff']);
Route::resource('staff-riwayat-peminjaman', StaffTuRiwayatPeminjamanController::class)->name('index', 'staff.riwayat.peminjaman')->middleware(['IsLogin','IsStaff']);
Route::post('/staff-riwayat-peminjaman/export', [StaffTuRiwayatPeminjamanController::class,'export_excel'])->name('staff.riwayat.peminjaman.export')->middleware(['IsLogin','IsStaff']);
// Route::get('/getDataPegawaiPeminjaman', [PegawaiPeminjamanController::class, 'getDataPegawaiPeminjaman'])->middleware(['IsLogin','IsPegawai']);
Route::resource('staff-pelaporan-peminjaman', StaffTUPelaporanPeminjamanController::class)->name('index', 'staff.pelaporan.peminjaman')->middleware(['IsLogin','IsStaff']);
Route::post('/pelaporan/peminjaman/export-ruangan', [StaffTUPelaporanPeminjamanController::class, 'exportRuangan'])
    ->name('staff.pelaporan.peminjaman.export_ruangan')
    ->middleware(['IsLogin','IsStaff']);
Route::post('/pelaporan/peminjaman/export-kendaraan', [StaffTUPelaporanPeminjamanController::class, 'exportKendaraan'])
    ->name('staff.pelaporan.peminjaman.export_kendaraan')
    ->middleware(['IsLogin','IsStaff']);
Route::post('/staff-data-peminjaman/export_ruangan', [KasubagDataPeminjamanController::class,'export_excel_ruangan'])->name('staff.data.peminjaman.export_ruangan')->middleware(['IsLogin','IsStaff']);
Route::post('/staff-data-peminjaman/export_kendaraan', [KasubagDataPeminjamanController::class,'export_excel_kendaraan'])->name('staff.data.peminjaman.export_kendaraan')->middleware(['IsLogin','IsStaff']);
# End Staff TU Session #

# Start Satpam Session #
Route::resource('satpam-pengembalian', SatpamPengembalianContoller::class)->name('index', 'satpam.pengembalian')->middleware(['IsLogin','IsSatpam']);
Route::get('/getDataSatpamPengembalian', [SatpamPengembalianContoller::class, 'getDataSatpamPengembalian'])->middleware(['IsLogin','IsSatpam']);
Route::resource('satpam-laporan-pengembalian', SatpamLaporanPengembalianController::class)->name('index', 'satpam.laporan.pengembalian')->middleware(['IsLogin','IsSatpam']);
Route::post('/satpam-laporan-pengembalian/export_kendaraan', [KasubagDataPeminjamanController::class,'export_excel_kendaraan'])->name('satpam.laporan.pengembalian.export_kendaraan')->middleware(['IsLogin','IsSatpam']);
# End Satpam Session #

# Start Kasubag Session #
Route::resource('kasubag-data-peminjaman', KasubagDataPeminjamanController::class)->name('index', 'kasubag.data.peminjaman')->middleware(['IsLogin','IsKasubag']);
Route::post('/kasubag-data-peminjaman/export', [KasubagDataPeminjamanController::class,'export_excel'])->name('kasubag.data.peminjaman.export')->middleware(['IsLogin','IsKasubag']);
Route::post('/kasubag-data-peminjaman/export_ruangan', [KasubagDataPeminjamanController::class,'export_excel_ruangan'])->name('kasubag.data.peminjaman.export_ruangan')->middleware(['IsLogin','IsKasubag']);
Route::post('/kasubag-data-peminjaman/export_kendaraan', [KasubagDataPeminjamanController::class,'export_excel_kendaraan'])->name('kasubag.data.peminjaman.export_kendaraan')->middleware(['IsLogin','IsKasubag']);
Route::get('/getDataKasubagPeminjaman', [KasubagDataPeminjamanController::class, 'getDataKasubagPeminjaman'])->middleware(['IsLogin','IsKasubag']);
Route::resource('kasubag-pelaporan-peminjaman', StaffTUPelaporanPeminjamanController::class)->name('index', 'kasubag.pelaporan.peminjaman')->middleware(['IsLogin','IsKasubag']);
Route::post('kasubag/pelaporan/peminjaman/export-ruangan', [StaffTUPelaporanPeminjamanController::class, 'exportRuangan'])
    ->name('kasubag.pelaporan.peminjaman.export_ruangan')
    ->middleware(['IsLogin','IsKasubag']);
Route::post('kasubag/pelaporan/peminjaman/export-kendaraan', [StaffTUPelaporanPeminjamanController::class, 'exportKendaraan'])
    ->name('kasubag.pelaporan.peminjaman.export_kendaraan')
    ->middleware(['IsLogin','IsKasubag']);
// Route::get('/getDataPegawaiPeminjaman', [PegawaiPeminjamanController::class, 'getDataPegawaiPeminjaman'])->middleware(['IsLogin','IsPegawai']);
# End Kasubag Session #

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
    Route::get('/masterKaryawan', [KaryawanController::class, 'page_master_karyawan']);

    Route::get('/DTMasterRuangRapat', [RuangrapatController::class, 'ajax_dt_master_ruangrapat']); // Table Master Ruang Rapat
    Route::get('/gtMasterRuangRapat', [RuangrapatController::class, 'ajax_gt_master_ruangrapat']); // Get Data Master Ruang Rapat
    Route::post('/processMasterRuangRapat', [RuangrapatController::class, 'ajax_pcs_master_ruangrapat']); // Proses Master Kendaraan
    Route::get('/deleteMasterRuangRapat', [RuangrapatController::class, 'ajax_del_master_ruangrapat']); // Proses Master Kendaraan

    Route::get('/DTMasterKaryawan', [KaryawanController::class, 'ajax_dt_master_karyawan']); // Table Master Ruang Rapat
    Route::get('/gtMasterKaryawan', [KaryawanController::class, 'ajax_gt_master_karyawan']); // Get Data Master Ruang Rapat
    Route::post('/processMasterKaryawan', [KaryawanController::class, 'ajax_pcs_master_karyawan']); // Proses Master Kendaraan
    Route::get('/deleteMasterKaryawan', [KaryawanController::class, 'ajax_del_master_karyawan']); // Proses Master Kendaraan

# End Ajax Master #

# Ajax Peminjaman #

    # Kendaraan
    Route::get('/calendarKendaraan', [PeminjamanKendaraanController::class, 'calendar_kendaraan']); // Kalender Kendaraan
    Route::get('/gtCalendarPeminjamanKendaraan', [PeminjamanKendaraanController::class, 'ajax_gt_calendar_kendaraan']); // Calendar Peminjaman
    Route::get('/gtPeminjamanKendaraan', [PeminjamanKendaraanController::class, 'ajax_gt_peminjaman_kendaraan']); // Ambil Data Peminjaman Preview
    Route::post('/processPinjamKendaraan', [PeminjamanKendaraanController::class, 'ajax_pcs_form_kendaraan']); // Proses Peminjaman Kendaraan
    Route::post('/processPindahPeminjaman', [PeminjamanKendaraanController::class, 'ajax_process_pindah_kendaraan']);

    Route::get('/rekapitulasiKendaraan', [PeminjamanKendaraanController::class, 'rekapitulasi_kendaraan']); // Rekapitulasi Kendaraan
    Route::get('/DTRekapitulasiKendaraan', [PeminjamanKendaraanController::class, 'ajax_dt_rekapitulasi_kendaraan']); // Tabel Rekapitulasi Kendaraan
    Route::get('/cancelPeminjamanKendaraan', [PeminjamanKendaraanController::class, 'ajax_cancel_form_kendaraan']); // Proses Cancel Peminjaman
    Route::get('/kembalikanPeminjamanKendaraan', [PeminjamanKendaraanController::class, 'ajax_kembalikan_form_peminjaman']); // Proses Cancel Peminjaman
    Route::get('/verifPeminjamanKendaraan', [PeminjamanKendaraanController::class, 'ajax_verif_form_peminjaman']); // Proses Cancel Peminjaman
    # #########

    # Ruang Rapat
    Route::get('/calendarRuangrapat', [PeminjamanRuangrapatController::class, 'calendar_ruangrapat']); // Kalender Ruang Rapat
    Route::get('/gtCalendarPeminjamanRuangrapat', [PeminjamanRuangrapatController::class, 'ajax_gt_calendar_ruangrapat']); // Calendar Ruang Rapat
    Route::get('/gtPeminjamanRuangrapat', [PeminjamanRuangrapatController::class, 'ajax_gt_peminjaman_ruangrapat']); // Ambil Data Peminjaman Preview
    Route::post('/processPinjamRuangrapat', [PeminjamanRuangrapatController::class, 'ajax_pcs_form_ruangrapat']); // Proses Peminjaman Kendaraan
    Route::get('/verifPeminjamanRuangRapat', [PeminjamanRuangrapatController::class, 'ajax_verif_form_ruangrapat']);

    Route::get('/rekapitulasiRuangrapat', [PeminjamanRuangrapatController::class, 'rekapitulasi_ruangrapat']); // Rekapitulasi Ruang Rapat
    Route::get('/DTRekapitulasiRuangrapat', [PeminjamanRuangrapatController::class, 'ajax_dt_rekapitulasi_ruangrapat']); // Tabel Rekapitulasi Ruang Rapat
    Route::get('/cancelPeminjamanRuangrapat', [PeminjamanRuangrapatController::class, 'ajax_cancel_form_ruangrapat']); // Proses Cancel Peminjaman
    # ###########

# End Ajax Peminjaman #

# Ajax Select #
Route::get('/selectKendaraan', [KendaraanController::class, 'ajax_select_kendaraan']);
Route::get('/selectKaryawan', [KaryawanController::class, 'ajax_select_karyawan']);
Route::get('/selectRuangRapat', [RuangrapatController::class, 'ajax_select_ruangrapat']);
# End Ajax Select #
