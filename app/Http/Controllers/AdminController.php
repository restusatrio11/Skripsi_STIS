<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Tugas;
use PDF;

class AdminController extends Controller

{
    public function index()
    {
        // $user_role = Session::get('role');
        $tasks = DB::table('tasks')->join('users','tasks.pegawai_id','=','users.id')->get();
        $pegawai = DB::table('users')->where('role', '=', 'user')->get();
        return view('admin', ['tasks' => $tasks,'pegawai' => $pegawai]);
    }

    public function store(Request $request){
        $data = $request->except('tgl_realisasi');
        $data['keterangan'] = 'Belum dikerjakan';
        // $data['tgl_realisasi'] = null;
        // Tugas::create($request->all());
    
        $simpan = Tugas::create($data);
        if ($simpan) {
            Session::flash('success', 'Tugas berhasil dibuat.');
        } else {
            Session::flash('success', 'Tugas gagal dibuat.');
        }

        $user = Auth::user();
        if($user->role == 'admin')
        return redirect('admin');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
{
    // dd($request->all());
    $data = Tugas::find($request->input('id'));
    $data->pegawai_id = $request->input('pegawai_id');
    $data->nama = $request->input('nama');
    $data->asal = $request->input('asal');
    $data->target = $request->input('target');
    $data->realisasi = $request->input('realisasi');
    $data->satuan = $request->input('satuan');
    $data->deadline = $request->input('deadline');

    $simpan = $data->save();

    
    if ($simpan) {
        Session::flash('success', 'Tugas berhasil diupdate.');
    } else {
        Session::flash('success', 'Tugas gagal diupdate.');
    }

    $user = Auth::user();
    if($user->role == 'admin')
    return redirect('admin');
    // return view('admin', ['data' => $data]);
    
}

public function delete(Request $request)
{
    $id = $request->input('task_id');

        $data = Tugas::find($id);
        if (!$data) {
            Session::flash('error', 'Tugas tidak ditemukan.');
            return redirect('admin');
        }

        $delete = $data->delete();

        if ($delete) {
            Session::flash('success', 'Tugas berhasil dihapus.');
        } else {
            Session::flash('error', 'Tugas gagal dihapus.');
        }

        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect('admin');
        }
}

public function penilaian(Request $request){
    
    $data = Tugas::find($request->input('task_id'));
    $data->nilai = $request->input('nilai');
    $data->keterangan = 'Telah dikonfirmasi';
    $simpan = $data->save();
    if ($simpan) {
        Session::flash('success', 'Nilai berhasil dibuat.');
    } else {
        Session::flash('success', 'Nilai gagal dibuat.');
    }

        

    $user = Auth::user();
    if($user->role == 'admin')
    return redirect('admin');
}

// public function cetak_pdf(Request $request){
//     $tasks = DB::table('tasks')->join('users','tasks.pegawai_id','=','users.id')->get();
//     $data = Tugas::find($request->input('task_id'));

//     $pdf = PDF::loadview('layout_ckp',['tasks'=>$tasks]);
//     return $pdf->download('laporan-pegawai-pdf');
// }

public function cetakCKPT(Request $request) 
{
    $user_id = $request->input('pegawai_id');
    $tasks = DB::table('tasks')
            ->join('users', 'tasks.pegawai_id', '=', 'users.id')
            ->where('id', '=', $user_id)
            ->get();
    // $bulan = $tasks->
    
    $pdf = app('dompdf.wrapper');
    $pdf->loadview('ckp-t', ['tasks'=>$tasks])->setPaper('letter', 'potrait');
    return $pdf->download('CKP-T.pdf');
}

public function cetakCKPR(Request $request) 
    {
        $user_id = $request->input('pegawai_id');
        $tasks = DB::table('tasks')
                ->join('users', 'tasks.pegawai_id', '=', 'users.id')
                ->where('id', '=', $user_id)
                ->get();
        // $bulan = $tasks->
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadview('ckp-r', ['tasks'=>$tasks])->setPaper('letter', 'potrait');
	    return $pdf->download('CKP-R.pdf');
    }

}
