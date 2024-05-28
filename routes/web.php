<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\KbpsController;
use App\Http\Controllers\timklatenController;
use App\Http\Controllers\JenisPekerjaanController;
use App\Http\Controllers\jenistimController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TimeReportTaskController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SupportController;
// use App\Http\Controllers\Auth\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/simanja', [LoginController::class,'showloginform'])->name('login');

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/simanja/progress', [AdminController::class, 'index'])->middleware('checkRole:admin,superadmin,kepala_bps')->name('admin');
    Route::post('/simanja/progress', [AdminController::class, 'filter'])->middleware('checkRole:admin,superadmin,kepala_bps')->name('admin');
    Route::get('/simanja/pekerjaan', [UserController::class, 'index'])->middleware(['checkRole:user,admin,superadmin,kepala_bps'])->name('user');
    Route::post('/simanja/pekerjaan', [UserController::class, 'filter'])->middleware(['checkRole:user,admin,superadmin,kepala_bps'])->name('user');
    Route::get('admin/ckp-r', [AdminController::class, 'cetakCKPR'])->middleware(['checkRole:admin,superadmin,kepala_bps']);
    Route::get('admin/ckp-t', [AdminController::class, 'cetakCKPT'])->middleware(['checkRole:admin,superadmin,kepala_bps']);
    Route::get('/simanja/dashboard', [ChartController::class, 'index'])->middleware(['checkRole:user,admin,superadmin,kepala_bps'])->name('visual');
    Route::post('/simanja/dashboard', [ChartController::class, 'filter'])->middleware(['checkRole:user,admin,superadmin,kepala_bps'])->name('visual');
    Route::get('/simanja/master/pegawai', [PegawaiController::class, 'index'])->middleware(['checkRole:user,admin,superadmin,kepala_bps'])->name('pegawai');
    // Route::get('getAvg', [ChartController::class, 'getAvg'])->middleware(['checkRole:user,admin,superadmin,kepala_bps']);
    // Route::get('getCount', [ChartController::class, 'getCount'])->middleware(['checkRole:user,admin,superadmin,kepala_bps']);
    Route::get('getBobot', [ChartController::class, 'getBobot'])->middleware(['checkRole:user,admin,superadmin,kepala_bps']);
    Route::get('/simanja/user', [SuperadminController::class,'index'])->middleware('checkRole:superadmin,kepala_bps')->name('superadmin');
    Route::get('/simanja/kepala_BPS', [KbpsController::class,'index'])->middleware('checkRole:kepala_bps')->name('kbps');
    Route::get('/simanja/Tim_Klaten', [timklatenController::class,'index'])->middleware('checkRole:user,admin,superadmin,kepala_bps')->name('timklaten');
    Route::post('/simanja/Tim_Klaten', [timklatenController::class,'filter'])->middleware('checkRole:user,admin,superadmin,kepala_bps')->name('timklaten');
    Route::get('/simanja/jenispekerjaan', [JenisPekerjaanController::class,'index'])->middleware('checkRole:superadmin,kepala_bps')->name('jenispekerjaan');
    Route::get('/simanja/jenistim', [jenistimController::class,'index'])->middleware('checkRole:superadmin,kepala_bps')->name('jenistim');
    Route::get('/simanja/timereport/{pegawai_id}', [TimeReportTaskController::class,'halaman'])->middleware('checkRole:kepala_bps')->name('timereport');
    Route::post('/simanja/timereport/{pegawai_id}', [TimeReportTaskController::class,'filter'])->middleware('checkRole:kepala_bps')->name('timereport');
    Route::get('/simanja/profil/{pegawai_id}', [ProfilController::class,'profil'])->middleware('checkRole:user,admin,superadmin,kepala_bps')->name('profil');
    Route::get('/simanja/support', [SupportController::class,'index'])->middleware('checkRole:admin,user,superadmin,kepala_bps')->name('support');
});

Route::delete('/jbtpegawai/delete/{id}/{idtim}',[SuperadminController::class, 'deleteJbtPegawai']);

Route::post('store',[AdminController::class, 'store'])->middleware('checkRole:admin,superadmin,kepala_bps')->name('store');

Route::post('updateUser', [UserController::class, 'update'])->middleware(['checkRole:user,admin,superadmin,kepala_bps'])->name("updateUser");

Route::post('update',[AdminController::class, 'update'])->middleware(['checkRole:admin,superadmin,kepala_bps'])->name("update");
Route::post('kembalikan',[AdminController::class, 'kembalikan'])->middleware(['checkRole:admin,superadmin,kepala_bps'])->name("kembalikan");

Route::post('delete', [AdminController::class, 'delete'])->middleware(['checkRole:admin,superadmin,kepala_bps'])->name('delete');

Route::get('/download-file/{fileId}', [UserController::class, 'download'])->name('downloadFile');
Route::post('/tasks/download/{fileId}', [UserController::class, 'download'])->name('tasks.download');



Route::post('penilaian', [AdminController::class, 'penilaian'])->middleware(['checkRole:admin,superadmin,kepala_bps'])->name('penilaian');
// Route::get('/import', 'ImportController@index')->name('import');
Route::post('/import', [AdminController::class, 'import'])->name('import');
Route::post('/importjt', [JenisPekerjaanController::class, 'import_excel_jp'])->name('importjt');
Route::get('/export_excel', [AdminController::class, 'export_excel'])->name('export_excel');
Route::get('/export_excel_jp', [JenisPekerjaanController::class, 'export_excel_jp'])->name('export_excel_jp');
Route::get('/export_excel_NA', [timklatenController::class, 'export_excel_NA'])->middleware(['checkRole:admin,superadmin,kepala_bps'])->name('export_excel_NA');
Route::get('/export_excel_ctba', [ChartController::class, 'export_excel_ctba'])->name('export_excel_ctba');
Route::get('/export_excel_namanilaiakhir', [ChartController::class, 'export_excel_namanilaiakhir'])->name('export_excel_namanilaiakhir');
Route::get('/export_excel_totalbobot', [ChartController::class, 'export_excel_totalbobot'])->name('export_excel_totalbobot');
Route::get('/export_excel_kp', [ChartController::class, 'export_excel_kp'])->name('export_excel_kp');

//superadmin
Route::resource('superadmin', SuperadminController::class);
Route::post('storeSA',[SuperadminController::class, 'store'])->name('storeSA');
Route::post('storeJT',[JenisPekerjaanController::class, 'storejtugas'])->name('storeJT');
Route::post('updateJT',[JenisPekerjaanController::class, 'updatejtugas'])->name('updateJT');
Route::post('deleteJT', [JenisPekerjaanController::class, 'deletejtugas'])->name('deleteJT');
Route::post('updateSA',[SuperadminController::class, 'update'])->name("updateSA");
Route::post('deleteSA', [SuperadminController::class, 'delete'])->name('deleteSA');


Route::post('storetim',[jenistimController::class, 'storetim'])->name('storetim');
Route::post('updatetim',[jenistimController::class, 'updatetim'])->name('updatetim');
Route::post('deletetim', [jenistimController::class, 'deletetim'])->name('deletetim');

Route::post('updatepkbps', [KbpsController::class, 'updatepkbps'])->middleware(['checkRole:kepala_bps'])->name("updatepkbps");
Route::get('/simanja/kepala_BPS/{nip}/pekerjaan', [KbpsController::class, 'showPekerjaanByNip']);
Route::get('/simanja/kepala_BPS/{nip}/nilai', [KbpsController::class, 'shownilaiakhirbynip']);

// routes/web.php
// Route::get('/forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/notif.list', function () {
    auth()->user()->notifications->markAsRead();
    return redirect()->back();
})->name('notif.list');


