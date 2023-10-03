<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\SuperadminController;


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

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('admin', [AdminController::class, 'index'])->middleware('checkRole:admin,superadmin');
    Route::get('user', [UserController::class, 'index'])->middleware(['checkRole:user,admin,superadmin']);
    Route::get('admin/ckp-r', [AdminController::class, 'cetakCKPR'])->middleware(['checkRole:admin,superadmin']);
    Route::get('admin/ckp-t', [AdminController::class, 'cetakCKPT'])->middleware(['checkRole:admin,superadmin']);
    Route::get('visual', [ChartController::class, 'index'])->middleware(['checkRole:user,admin,superadmin']);
    Route::get('getAvg', [ChartController::class, 'getAvg'])->middleware(['checkRole:user,admin,superadmin']);
    Route::get('getCount', [ChartController::class, 'getCount'])->middleware(['checkRole:user,admin,superadmin']);
    Route::get('getBobot', [ChartController::class, 'getBobot'])->middleware(['checkRole:user,admin,superadmin']);
    Route::get('superadmin', [SuperadminController::class,'index'])->middleware('checkRole:superadmin');
});

Route::post('store',[AdminController::class, 'store'])->middleware('checkRole:admin,superadmin')->name('store');
Route::post('updateUser', [UserController::class, 'update'])->middleware(['checkRole:user,admin,superadmin'])->name("updateUser");
Route::post('update',[AdminController::class, 'update'])->middleware(['checkRole:admin,superadmin'])->name("update");
Route::post('delete', [AdminController::class, 'delete'])->middleware(['checkRole:admin,superadmin'])->name('delete');
Route::get('/download-file/{fileId}', [UserController::class, 'download'])->name('downloadFile');
Route::post('penilaian', [AdminController::class, 'penilaian'])->middleware(['checkRole:admin,superadmin'])->name('penilaian');
// Route::get('/import', 'ImportController@index')->name('import');
Route::post('/import', [AdminController::class, 'import'])->name('import');
Route::get('/export_excel', [AdminController::class, 'export_excel']);

//superadmin
Route::resource('superadmin', SuperadminController::class);
Route::post('storeSA',[SuperadminController::class, 'store'])->name('storeSA');
Route::post('updateSA',[SuperadminController::class, 'update'])->name("updateSA");
Route::post('deleteSA', [SuperadminController::class, 'delete'])->name('deleteSA');



