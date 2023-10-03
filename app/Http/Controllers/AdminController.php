<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TasksImport;
use App\Imports\TasksExport;

use App\Models\Tugas;
use App\Models\File;
use PDF;
use ZipArchive;

class AdminController extends Controller

{
    public function index()
    {
        // Ambil admin yang sedang masuk
        $admin = auth()->user();

        // $user_role = Session::get('role');
        $tasks = DB::table('tasks')->join('users','tasks.pegawai_id','=','users.id')->where('asal',$admin->tim)->get();
        $pegawai = DB::table('users')->get();
        return view('admin', ['tasks' => $tasks,'pegawai' => $pegawai,'admin'=>$admin]);
    }

    public function store(Request $request){
        // Lakukan validasi
        // $request->validate([
        //     'nama' => 'required',
        //     'password' => 'required',
        //     'asal' => 'required',
        //     'target' => 'required',
        //     'realisasi' => 'required',
        //     'satuan' => 'required',
        //     'deadline' => 'required',
        // ]);


        $data = $request->except('tgl_realisasi');
        $data['keterangan'] = 'Belum dikerjakan';
        // $data['tgl_realisasi'] = null;
        // Tugas::create($request->all());

        $simpan = Tugas::create($data);
        if ($simpan) {
            Session::flash('success', 'Tugas berhasil dibuat.');
        } else {
            Session::flash('failed', 'Tugas gagal dibuat.');
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
    $data->bobot = $request->input('bobot');

    $simpan = $data->save();


    if ($simpan) {
        Session::flash('success', 'Tugas berhasil diupdate.');
    } else {
        Session::flash('failed', 'Tugas gagal diupdate.');
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
            Session::flash('failed', 'Tugas gagal dihapus.');
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
        Session::flash('failed', 'Nilai gagal dibuat.');
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

    // Cek apakah $tasks kosong
    if ($tasks->isEmpty()) {
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML('<p>Tidak ada data CKP-T yang tersedia.</p>')->setPaper('letter', 'portrait');
        return $pdf->download('CKP-T_Kosong.pdf');
    }

    $pdf = app('dompdf.wrapper');
    $pdf->loadview('ckp-t', ['tasks'=>$tasks])->setPaper('letter', 'portrait');
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

    // Cek apakah $tasks kosong
    if ($tasks->isEmpty()) {
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML('<p>Tidak ada data CKP-T yang tersedia karena task belum dikerjakan.</p>')->setPaper('letter', 'portrait');
        return $pdf->download('CKP-R_Kosong.pdf');
    }

        $pdf = app('dompdf.wrapper');
        $pdf->loadview('ckp-r', ['tasks'=>$tasks])->setPaper('letter', 'potrait');
	    return $pdf->download('CKP-R.pdf');
}

    public function download($fileId)
{
    // Ubah string $fileId menjadi array
    $fileIds = explode(',', $fileId);

    // Cari file yang sesuai berdasarkan array file_id
    $files = File::whereIn('file_id', $fileIds)->get();


    // Inisialisasi objek ZipArchive
    $zip = new ZipArchive();

    // Nama berkas ZIP yang akan dibuat
    $zipFileName = 'downloaded_files.zip';

    if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        // Loop melalui setiap file yang ditemukan
        foreach ($files as $file) {
            // Tentukan path file yang akan dimasukkan ke dalam ZIP
            $filePath = public_path('file/' . $file->file_name);

            if (file_exists($filePath)) {
                // Tambahkan file ke dalam ZIP dengan nama yang sama
                $zip->addFile($filePath, $file->file_name);
            }
        }

        // Tutup ZIP setelah menambahkan semua file
        $zip->close();

        // Mengembalikan respon untuk mengunduh berkas ZIP
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    } else {
        // Handle jika tidak dapat membuat berkas ZIP
        abort(500, 'Tidak dapat membuat berkas ZIP.');
    }
}

public function import(Request $request)
    {
        // Excel::import(new TasksImport(), $request->file('file')->store('temp')); // Gantilah 'nama_file_excel.xlsx' dengan nama file yang sesuai
        // return redirect()->route('tasks.index')->with('success', 'Data berhasil diimpor.');

        // validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);

		// menangkap file excel
		$file = $request->file('file');

		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();

		// upload ke folder file_siswa di dalam folder public
		$file->move('file_pegawai',$nama_file);

		// import data
		Excel::import(new TasksImport(), public_path('/file_pegawai/'.$nama_file));

        // alihkan halaman kembali
		return redirect('/admin')->with('success', 'Data berhasil diimpor.');
    }

    public function export_excel()
	{
		return Excel::download(new TasksExport, 'Pegawai.xlsx');
	}

}
