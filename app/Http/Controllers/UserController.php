<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\File;
use App\Http\Requests;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use ZipArchive;
use DateTime;
use DateTimeZone;


class UserController extends Controller
{
    public function index()
    {
        $user_id = Session::get('id');
        $tasks = DB::table('tasks')->where('pegawai_id', '=', $user_id)->get();
        $file = DB::table('files')->join('tasks','files.file_id','=','tasks.task_id')->where('pegawai_id', '=', $user_id)->get();
        return view('user', ['tasks' => $tasks,'file'=>$file]);
    }

    public function update(Request $request)
    {
        $data = Tugas::find($request->input('idhidden'));
        if ($request->input('update') != ""){
            $realisasiSaatIni = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $data->tgl_realisasi = $realisasiSaatIni->format('Y-m-d');
            // Ambil nilai "realisasi" sebelumnya
            $realisasiSebelumnya = $data->realisasi;
            // $data->tgl_realisasi = date("Y-m-d", strtotime($request->input('update')));
        }
        if ($request->file('file') != null) {
            $file = $request->file('file');

            foreach($file as $key => $files){
            $nama_file = 'Tugas ID '.$request->input('idhidden').$key.'.'.$files->getClientOriginalExtension();
            $files->move('file',$nama_file);
            // Simpan informasi file ke dalam tabel 'files' dan mengaitkannya dengan 'Tugas'
            $fileModel = File::create([
                'file_name' => $nama_file,
                'file_path' => 'file/' . $nama_file,
                'file_id' => $request->input('idhidden'),
            ]);
            $data->file = $nama_file;
        };
        }

        if ($data->tgl_realisasi > $data->deadline) $data->nilai = 90;

        $data->keterangan = 'Tunggu Konfirmasi';
        // $data->realisasi = $request->input('realisasi');

        // Ambil nilai "realisasi" baru dari request
        $realisasiBaru = $request->input('realisasi');

        // Akumulasi nilai "realisasi" baru dengan nilai "realisasi" sebelumnya
        $realisasiAkumulasi = $realisasiSebelumnya + $realisasiBaru;

        // Simpan nilai "realisasi" yang telah diakumulasi ke dalam database
        $data->realisasi = $realisasiAkumulasi;

        // Cek apakah nilai "realisasi" yang baru melebihi "target"
        if ($data->realisasi > $data->target) {
            Session::flash('status', 'Nilai realisasi tidak boleh melebihi target');
            return redirect()->back()
                ->with('error', 'Nilai "realisasi" tidak boleh melebihi "target"');
        }

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


}
