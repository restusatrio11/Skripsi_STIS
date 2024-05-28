<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\jenis_tugas;
use App\Models\tim;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Validator;
use App\Imports\JenisTasksImport;
use Maatwebsite\Excel\Validators\ValidationException;

use Illuminate\Support\Facades\Session;

use App\Imports\JPExport;

class JenisPekerjaanController extends Controller
{


    public function index()
    {
        // $user_role = Session::get('role');
        // Menampilkan daftar pengguna
        $jenis_tim = tim::all();
        $jenis_tugas = jenis_tugas::join('tim','jenis_tasks.tim_id','=','tim.kode')->get();
        $satuan = jenis_tugas::select('satuan')->distinct()->orderBy('satuan','asc')->get();
        return view('jenispekerjaan', ['jenis_tugas'=> $jenis_tugas,'jenis_tim' => $jenis_tim,'satuan' => $satuan]);
    }

public function storejtugas(Request $request){
    $jtugas = $request->all();

    // Mengganti koma (,) dengan titik (.) dalam nilai 'bobot'
    if(isset($jtugas['bobot'])) {
        $jtugas['bobot'] = str_replace(',', '.', $jtugas['bobot']);
    }

    // Menghitung nomor urut pekerjaan yang masuk untuk tim tertentu
    $nomorUrut = jenis_tugas::where('tim_id', $jtugas['tim_id'])->count() + 1;

    // Gabungkan kode tim dan nomor urut untuk membuat nilai kolom 'no'
    $no = $jtugas['tim_id'] . '-' . $nomorUrut;
    $jtugas['no'] = $no;

    $simpan = jenis_tugas::create($jtugas);
    if ($simpan) {
        Session::flash('success', 'Jenis Tugas berhasil dibuat.');
    } else {
        Session::flash('success', 'Jenis Tugas dibuat.');
    }

    // $user = Auth::user();
    // if($user->role == 'admin')
    return redirect('/simanja/jenispekerjaan');
}

public function updatejtugas(Request $request)
{
    $data = jenis_tugas::find($request->input('no'));

    if (!$data) {
        // Data tidak ditemukan, berikan respons atau redirect
        return redirect('/simanja/jenispekerjaan')->with('failed', 'Jenis Tugas tidak ditemukan.');
    }

    $data->tugas = $request->input('tugas');
    $data->satuan = $request->input('satuan');
    $data->bobot = $request->input('bobot');
    $data->tim_id = $request->input('tim_id');

    $simpan = $data->save();

    if ($simpan) {
        Session::flash('success', 'Jenis Tugas berhasil diupdate.');
    } else {
        Session::flash('failed', 'Jenis Tugas gagal diupdate.');
    }

    return redirect('/simanja/jenispekerjaan');
}


public function deletejtugas(Request $request)
{
    $no = $request->input('no');

        $data = jenis_tugas::find($no);
        if (!$data) {
            Session::flash('error', 'Jenis Tugas tidak ditemukan.');
            return redirect('admin');
        }

        $delete = $data->delete();

        if ($delete) {
            Session::flash('success', 'Jenis Tugas berhasil dihapus.');
        } else {
            Session::flash('error', 'Jenis Tugas gagal dihapus.');
        }

        // $user = Auth::user();
        // if ($user->role == 'admin') {
        //     return redirect('admin');
        // }
        return redirect('/simanja/jenispekerjaan');
}

    public function export_excel_jp()
	{
		return Excel::download(new JPExport, 'Jenis Pekerjaan BPS Kabupaten Klaten.xlsx');
	}

    public function import_excel_jp(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_pegawai', $nama_file);

        // Validasi impor dengan aturan yang didefinisikan di fungsi model
        $validator = Validator::make([], []); // Buat validator kosong

        $import = new JenisTasksImport($validator);

        try {
            // Melakukan impor data dari file excel
            Excel::import($import, public_path('/file_pegawai/' . $nama_file));

            // Jika impor berhasil, alihkan kembali ke halaman dengan pesan sukses
            return redirect('/simanja/jenispekerjaan')->with('success', 'Data berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Jika terjadi kesalahan validasi selama proses impor
            $failures = $e->failures(); // Dapatkan informasi tentang kegagalan validasi


            // Simpan pesan kesalahan dalam array
            $errorMessages = [];

            foreach ($failures as $failure) {
                // $pegawai_id = $failure->values()['pegawai_id'];

                // if (!isset($pegawai_id) || empty($pegawai_id)) break;
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(", ", $failure->errors());
            }


            // Alihkan kembali ke halaman impor dengan pesan kesalahan
            return redirect('/simanja/jenispekerjaan')->with('failed',$errorMessages);
        }

    }
}
