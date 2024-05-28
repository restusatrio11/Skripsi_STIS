<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class PegawaiController extends Controller
{


    public function index()
    {
        // $user_role = Session::get('role');
        // Menampilkan daftar pengguna
        $ignoredNames = ['Super Admin', 'user', 'admin'];
        $pegawai = User::whereNotIn('name', $ignoredNames)->join('users_tim','users.id','=','users_tim.NIPpegawai')->join('tim','users_tim.KodeTim','=','tim.kode')->orderBy('name', 'asc') // Mengurutkan secara ascending (A-Z)
        ->get();
        return view('pegawai', ['pegawai'=> $pegawai]);
    }

}
