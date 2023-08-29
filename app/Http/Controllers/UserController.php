<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Http\Requests;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $user_id = Session::get('id');
        $tasks = DB::table('tasks')->where('pegawai_id', '=', $user_id)->get();
        return view('user', ['tasks' => $tasks]);
    }

    public function update(Request $request)
    {
        $data = Tugas::find($request->input('idhidden'));
        if ($request->input('update') != "") 
            $data->tgl_realisasi = date("Y-m-d", strtotime($request->input('update')));

        if ($request->file('file') != null) {
            $file = $request->file('file');
            $nama_file = 'Tugas ID '.$request->input('idhidden').'.'.$file->getClientOriginalExtension();
            $file->move('file',$nama_file);
            $data->file = $nama_file;
        }

        if ($data->tgl_realisasi > $data->deadline) $data->nilai = 90;

        $data->keterangan = 'Tunggu Konfirmasi';

        $simpan = $data->save();
        if ($simpan) {
            Session::flash('status', 'Tugas berhasil diupdate');
        } else {
            Session::flash('status', 'Tugas gagal diupdate');
        }
        $user = Auth::user();
        if ($user->role == 'admin') return redirect('admin');
        else return redirect('user');
    }

    public function cetakCKPR() 
    {
        $user_id = Session::get('id');
        $tasks = DB::table('tasks')
                ->join('users', 'tasks.pegawai_id', '=', 'users.id')
                ->where('pegawai_id', '=', $user_id)
                ->get();
        // $bulan = $tasks->
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadview('ckp-r', ['tasks'=>$tasks])->setPaper('letter', 'potrait');
	    return $pdf->download('CKP-R.pdf');
    }
}