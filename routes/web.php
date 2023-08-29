<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DataController;


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
    Route::get('admin', [AdminController::class, 'index'])->middleware('checkRole:admin');
    Route::get('user', [UserController::class, 'index'])->middleware(['checkRole:user,admin']);
    Route::get('admin/ckp-r', [AdminController::class, 'cetakCKPR'])->middleware(['checkRole:admin']);
    Route::get('admin/ckp-t', [AdminController::class, 'cetakCKPT'])->middleware(['checkRole:admin']);
    Route::get('visual', [ChartController::class, 'index'])->middleware(['checkRole:user,admin']);
    Route::get('getAvg', [ChartController::class, 'getAvg'])->middleware(['checkRole:user,admin']);
    Route::get('getCount', [ChartController::class, 'getCount'])->middleware(['checkRole:user,admin']);
});

Route::post('store',[AdminController::class, 'store'])->middleware('checkRole:admin')->name('store');
Route::post('updateUser', [UserController::class, 'update'])->middleware(['checkRole:user,admin'])->name("updateUser");
Route::post('update',[AdminController::class, 'update'])->middleware(['checkRole:admin'])->name("update");
Route::post('delete', [AdminController::class, 'delete'])->middleware(['checkRole:admin'])->name('delete');

Route::post('penilaian', [AdminController::class, 'penilaian'])->middleware(['checkRole:admin'])->name('penilaian');
