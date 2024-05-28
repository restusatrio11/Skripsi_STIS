<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tugas;
use Illuminate\Support\Facades\Session;

class ProfilController extends Controller
{


    public function profil($pegawai_id)
    {
        // Ambil data pegawai berdasarkan pegawai_id
        $pegawai = User::join('users_tim','users.id','=','users_tim.NIPpegawai')->join('tim','users_tim.KodeTim','=','tim.kode')->where('id',$pegawai_id)->first();

        // Jika pegawai tidak ditemukan, redirect atau berikan respons sesuai kebutuhan
        if (!$pegawai) {
            return redirect()->route('/simanja/profil/{{$pegawai_id}}')->with('error', 'Pegawai tidak ditemukan');
        }

        // Kirim data ke tampilan
        return view('profil', ['pegawai'=> $pegawai]);
    }

}
