<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TasksImport;
use App\Imports\TasksExport;


use App\Models\Tugas;

use App\Models\User;
use App\Models\OutputNilai;
use App\Models\tim;
use App\Models\jenis_tugas;

use PDF;
use ZipArchive;
use Carbon\Carbon;
use Maatwebsite\Excel\Validators\ValidationException;

use App\Notifications\create_job;
use App\Notifications\return_tugas;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller

{
    public function index()
    {
        // Ambil admin yang sedang masuk
        $admin = auth()->user();
        $role = auth()->user()->role;

        //ambil jenis tugas berdasarkan tim
        $tim_admin = auth()->user()->JenisJabatan->NamaTim->tim;


        // $jenis_tasks = $this->getFilteredJenis_Tasks(Carbon::now()->year, Carbon::now()->month);
        if($role === 'admin'){
            $jenis_tasks = DB::table('jenis_tasks')->join('tim','jenis_tasks.tim_id','=','tim.kode')->where('tim.tim',$admin->JenisJabatan->NamaTim->tim)->orderBy('jenis_tasks.tugas', 'asc')->get();
        }elseif($role === 'kepala_bps'){
            $jenis_tasks = DB::table('jenis_tasks')->orderBy('jenis_tasks.tugas', 'asc')->get();
        }elseif($role === 'superadmin'){
            $jenis_tasks = DB::table('jenis_tasks')->orderBy('jenis_tasks.tugas', 'asc')->get();
        }


        $jenis_tim = tim::all();

        // Ambil data tasks sesuai filter default (bulan dan tahun saat ini)
        $tasks = $this->getFilteredTasks(Carbon::now()->year, Carbon::now()->month);



        $pegawai = DB::table('users')
        ->whereNotIn('id', [1, 2, 3])
        ->orderBy('name') // Urutkan berdasarkan kolom 'name'
        ->get();

        $hasil = DB::table('output_nilais')->get();

        $currentMonth = Carbon::now()->month; // Ambil bulan saat ini

        // Ambil semua data tugas yang memiliki deadline pada bulan dan tahun saat ini
        $taskss = Tugas::whereYear('deadline', '=', Carbon::now()->year)
            ->whereMonth('deadline', '=', Carbon::now()->month)
            ->get();

        // Inisialisasi array untuk menyimpan total bobot tiap pegawai
        $totalBobot = [];
        $jumlahTugasPegawai = [];
        $total_nilai_kualitas = [];
        $total_nilai_kuantitas = [];
        $nilaiAkhir = [];

        // Iterasi melalui setiap tugas
        foreach ($taskss as $task) {

            // Validasi dan konversi nilai bobot
            $bobot = is_numeric($task->volume_tertimbang) ? $task->volume_tertimbang : 0;
            $nilai_kualitas = $task->nilai_kualitas;
            $nilai_kuantitas = $task->nilai_kuantitas;

            // Ambil nama pegawai yang mengerjakan tugas
            $pbps = User::find($task->pegawai_id);

            // Hitung total bobot tiap pegawai
            if (!isset($totalBobot[$pbps->name])) {
                $totalBobot[$pbps->name] = 0;
                $jumlahTugasPegawai[$pbps->name] = 0;
                $total_nilai_kualitas[$pbps->name] = 0;
                $total_nilai_kuantitas[$pbps->name] = 0;
            }

            $totalBobot[$pbps->name] += $bobot;
            $jumlahTugasPegawai[$pbps->name] += 1; // Tambahkan jumlah tugas
            $total_nilai_kualitas[$pbps->name] += $nilai_kualitas;
            $total_nilai_kuantitas[$pbps->name] += $nilai_kuantitas;

        }

        // Menghapusi pegawai yang tidak memiliki pekerjaan
        // Mencari entri-entri yang masih relevan di tabel output_nilai
        $outputNilais = OutputNilai::whereMonth('updated_at', Carbon::now()->month)
                        ->whereYear('updated_at', Carbon::now()->year)
                        ->get();



        foreach ($outputNilais as $outputNilaii) {
            // Periksa apakah pegawai tersebut masih memiliki tugas yang terkait
            $pegawaibps = !Tugas::whereYear('deadline', '=', Carbon::now()->year)
            ->whereMonth('deadline', '=', Carbon::now()->month)
            ->where('pegawai_id', $outputNilaii->pegawai_id)
            ->exists();

            if ($pegawaibps) {
                // Jika pegawai tidak ditemukan, hapus entri dari tabel output_nilai
                $outputNilaii->delete();
            }
        }


        // Iterasi ulang untuk menghitung dan menyimpan nilai akhir
        foreach ($totalBobot as $pegawaiName => $totalBobotPegawai) {

            // Hitung nilai akhir
            $nilaiAkhir[$pegawaiName] = ($jumlahTugasPegawai[$pegawaiName] > 0) ?
                round(($totalBobotPegawai / (22 * $jumlahTugasPegawai[$pegawaiName])) * (($total_nilai_kualitas[$pegawaiName] + $total_nilai_kuantitas[$pegawaiName]) / (2 * $jumlahTugasPegawai[$pegawaiName])), 2) : 0;

            // Tentukan total bobot pegawai
            $totalBobotPegawai = ($jumlahTugasPegawai[$pegawaiName] > 0) ? $totalBobotPegawai : 0;

            // Ambil bobot tertinggi dari tabel output_nilais
            $bobotTertinggi = DB::table('output_nilais')
                            ->whereMonth('updated_at', Carbon::now()->month)
                            ->whereYear('updated_at', Carbon::now()->year)
                            ->max('total_bobot');

            // Hitung sepertiga dari bobot tertinggi
            $sepertigaBobotTertinggi = $bobotTertinggi / 3;

            // Tentukan kategori bobot berdasarkan total bobot pegawai
            if ($totalBobotPegawai <= $sepertigaBobotTertinggi) {
                $kategoriBobot = 'kecil';
            } elseif ($totalBobotPegawai <= 2 * $sepertigaBobotTertinggi) {
                $kategoriBobot = 'sedang';
            } else {
                $kategoriBobot = 'besar';
            }

            // Cari atau buat entri baru di OutputNilai
            $outputNilai = OutputNilai::where('pegawai_id', User::where('name', $pegawaiName)->first()->id)->latest('updated_at')->first();

            if ($outputNilai) {
                // Jika entri sudah ada, periksa apakah bulan created_at sama dengan bulan saat ini
                $updatedMonth = Carbon::parse($outputNilai->updated_at)->month;
                if ($updatedMonth != $currentMonth) {
                    // Jika tidak sama, buat entri baru
                    OutputNilai::create([
                        'pegawai_id' => User::where('name', $pegawaiName)->first()->id,
                        'nama' => $pegawaiName,
                        'nilai_akhir' => $nilaiAkhir[$pegawaiName],
                        'total_bobot' => $jumlahTugasPegawai[$pegawaiName] > 0 ? $totalBobotPegawai : 0, // Set bobot menjadi nol jika tidak ada tugas
                        'kategori_bobot' => $kategoriBobot
                    ]);
                } else {
                    // Jika sama, update entri yang ada
                    $outputNilai->update([
                        'nilai_akhir' => $nilaiAkhir[$pegawaiName],
                        'total_bobot' => $jumlahTugasPegawai[$pegawaiName] > 0 ? $totalBobotPegawai : 0, // Set bobot menjadi nol jika tidak ada tugas
                        'kategori_bobot' => $kategoriBobot
                    ]);
                }
            } else {
                // Jika belum ada entri, buat entri baru
                OutputNilai::create([
                    'pegawai_id' => User::where('name', $pegawaiName)->first()->id,
                    'nama' => $pegawaiName,
                    'nilai_akhir' => $nilaiAkhir[$pegawaiName],
                    'total_bobot' => $jumlahTugasPegawai[$pegawaiName] > 0 ? $totalBobotPegawai : 0, // Set bobot menjadi nol jika tidak ada tugas
                    'kategori_bobot' => $kategoriBobot
                ]);
            }

        }

            // Ambil data monitoring pekerjaan sesuai filter default (bulan dan tahun saat ini)
            $jenisPekerjaan = $this->getFilteredMonitoring(Carbon::now()->year, Carbon::now()->month);



        $bulan = Carbon::now()->format('m');


        return view('admin', ['tasks' => $tasks,'pegawai' => $pegawai,'admin'=>$admin,'jenis_tasks' => $jenis_tasks,'hasil'=>$hasil, 'jenisPekerjaan' => $jenisPekerjaan,'tim_admin' => $tim_admin,'jenis_tim'=>$jenis_tim,'bulan'=> $bulan]);

        // return view('app',['tim_admin' => $tim_admin]);
    }

    public function filter(Request $request)
    {
        // Ambil data tasks sesuai filter bulan dan tahun yang dipilih
        $year = $request->input('year');
        $month = $request->input('month');

        $tasks = $this->getFilteredTasks($year, $month);

        // Ambil data monitoring pekerjaan sesuai filter bulan dan tahun yang dipilih
        $jenisPekerjaan = $this->getFilteredMonitoring($year, $month);
        // $jenis_tasks = $this->getFilteredJenis_Tasks($year,$month);

        $bulan = $request->input('month');
        if(!$bulan){
            $bulan = Carbon::now()->format('m');
        }

        $admin = auth()->user();
        $role = auth()->user()->role;
        if($role === 'admin'){
            $jenis_tasks = DB::table('jenis_tasks')->join('tim','jenis_tasks.tim_id','=','tim.kode')->where('tim.tim',$admin->JenisJabatan->NamaTim->tim)->orderBy('jenis_tasks.tugas', 'asc')->get();
        }elseif($role === 'kepala_bps'){
            $jenis_tasks = DB::table('jenis_tasks')->orderBy('jenis_tasks.tugas', 'asc')->get();
        }elseif($role === 'superadmin'){
            $jenis_tasks = DB::table('jenis_tasks')->orderBy('jenis_tasks.tugas', 'asc')->get();
        }

        $jenis_tim = tim::all();
        $pegawai = DB::table('users')
        ->whereNotIn('id', [1, 2, 3])
        ->orderBy('name') // Urutkan berdasarkan kolom 'name'
        ->get();

        return view('admin', ['tasks' => $tasks, 'jenisPekerjaan' => $jenisPekerjaan,'bulan'=>$bulan,'admin'=>$admin,'jenis_tasks'=>$jenis_tasks,'jenis_tim'=>$jenis_tim,'pegawai'=>$pegawai]);
    }

    private function getFilteredJenis_Tasks($year,$month){
        $admin = auth()->user();
        $role = auth()->user()->role;
        if($role === 'admin'){
            $jenis_tasks = DB::table('jenis_tasks')->join('tim','jenis_tasks.tim_id','=','tim.kode')->where('tim.tim',$admin->JenisJabatan->NamaTim->tim)->whereYear('jenis_tasks.created_at','=', $year)
            ->whereMonth('jenis_tasks.created_at','=', $month)->orderBy('jenis_tasks.tugas', 'asc')->get();

            return $jenis_tasks;
        }elseif($role === 'kepala_bps'){
            $jenis_tasks = DB::table('jenis_tasks')->whereYear('jenis_tasks.created_at','=', $year)
            ->whereMonth('jenis_tasks.created_at','=', $month)->orderBy('jenis_tasks.tugas', 'asc')->get();
            return $jenis_tasks;
        }elseif($role === 'superadmin'){
            $jenis_tasks = DB::table('jenis_tasks')->whereYear('jenis_tasks.created_at','=', $year)
            ->whereMonth('jenis_tasks.created_at','=', $month)->orderBy('jenis_tasks.tugas', 'asc')->get();
            return $jenis_tasks;
        }
    }

    private function getFilteredTasks($year, $month)
    {
        $role = auth()->user()->role;
        if($role === 'admin'){

            $tasks = Tugas::join('users','jenistasks_users.pegawai_id','=','users.id')
            ->join('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')
            ->join('tim','jenis_tasks.tim_id','=','tim.kode')
            ->where('tim.tim', auth()->user()->JenisJabatan->NamaTim->tim)
            ->whereYear('jenistasks_users.deadline', '=', $year)
            ->whereMonth('jenistasks_users.deadline', '=', $month)
            ->orderBy('jenis_tasks.tugas', 'asc') // Mengurutkan secara ascending (A-Z)
            ->get();

            return $tasks;

        }elseif($role === 'kepala_bps'){
            $tasks = Tugas::join('users','jenistasks_users.pegawai_id','=','users.id')
            ->join('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')
            ->join('tim','jenis_tasks.tim_id','=','tim.kode')
            ->whereYear('jenistasks_users.deadline', '=', $year)
            ->whereMonth('jenistasks_users.deadline', '=', $month)
            ->get();

            return $tasks;
        }elseif($role === 'superadmin'){
            $tasks = Tugas::join('users','jenistasks_users.pegawai_id','=','users.id')
            ->join('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')
            ->join('tim','jenis_tasks.tim_id','=','tim.kode')
            ->whereYear('jenistasks_users.deadline', '=', $year)
            ->whereMonth('jenistasks_users.deadline', '=', $month)
            ->get();

            return $tasks;
        }


    }

    private function getFilteredMonitoring($year, $month)
    {
        $role = auth()->user()->role;
        if($role === 'admin'){

            $jenisPekerjaan = Tugas::join('jenis_tasks', 'jenistasks_users.jenistask_id', '=', 'jenis_tasks.no')
            ->join('tim','jenis_tasks.tim_id','=','tim.kode')
            ->where('tim.tim', auth()->user()->JenisJabatan->NamaTim->tim)
            ->whereYear('jenistasks_users.deadline', '=', $year)
            ->whereMonth('jenistasks_users.deadline', '=', $month)
            ->select('jenis_tasks.tugas', DB::raw('SUM(jenistasks_users.target) as total_target'), DB::raw('SUM(jenistasks_users.realisasi) as total_realisasi'))
            ->groupBy('jenis_tasks.tugas')
            ->get();

            return $jenisPekerjaan;
        }elseif($role === 'kepala_bps'){
            $jenisPekerjaan = Tugas::join('jenis_tasks', 'jenistasks_users.jenistask_id', '=', 'jenis_tasks.no')
            ->join('tim','jenis_tasks.tim_id','=','tim.kode')
            ->whereYear('jenistasks_users.deadline', '=', $year)
            ->whereMonth('jenistasks_users.deadline', '=', $month)
            ->select('jenis_tasks.tugas', DB::raw('SUM(jenistasks_users.target) as total_target'), DB::raw('SUM(jenistasks_users.realisasi) as total_realisasi'))
            ->groupBy('jenis_tasks.tugas')
            ->get();

            return $jenisPekerjaan;
        }elseif($role === 'superadmin'){
            $jenisPekerjaan = Tugas::join('jenis_tasks', 'jenistasks_users.jenistask_id', '=', 'jenis_tasks.no')
            ->join('tim','jenis_tasks.tim_id','=','tim.kode')
            ->whereYear('jenistasks_users.deadline', '=', $year)
            ->whereMonth('jenistasks_users.deadline', '=', $month)
            ->select('jenis_tasks.tugas', DB::raw('SUM(jenistasks_users.target) as total_target'), DB::raw('SUM(jenistasks_users.realisasi) as total_realisasi'))
            ->groupBy('jenis_tasks.tugas')
            ->get();

            return $jenisPekerjaan;
        }

    }

public function store(Request $request)
{
    $data = $request->except(['tgl_realisasi', 'pegawai_id']);
    $data['keterangan'] = 'Belum dikerjakan';
    $data['realisasi'] = 0;

    // Ambil pegawai_ids dari form (berupa array)
    $pegawaiIds = $request->input('pegawai_id', []);

    // Dapatkan ID jenis_tasks dari formulir atau sumber data lainnya
    $idJenisTasks = $request->input('jenistask_id');

    // Dapatkan bobot dari tabel jenis_tasks berdasarkan ID
    $jenisTasks = DB::table('jenis_tasks')->where('no', $idJenisTasks)->first();

    if (!$jenisTasks) {
        // Handle jika ID jenis_tasks tidak ditemukan
        return response()->json(['error' => 'ID jenis_tasks tidak valid'], 404);
    }

    // Ambil data target dari formulir
    $selectedTargets = json_decode($request->input('selectedTargets'), true);

    // Simpan pegawai_ids ke tabel tasks (tugas)
    foreach ($selectedTargets as $pegawaiId => $targetValue) {

    // Ganti koma dengan titik untuk memastikan nilai desimal
     $targetValue = str_replace(',', '.', $targetValue);

    // Validasi apakah nilai target adalah numerik
    if (!is_numeric($targetValue)) {
        return response()->json(['error' => 'Nilai target harus berupa angka'], 422);
    }

        // Dapatkan bobot dari $jenisTasks
        $bobot = $jenisTasks->bobot;

        // Hitung volume tertimbang untuk setiap pegawai
        $volumeTertimbang = $bobot * $targetValue;

        // Langsung buat tugas baru tanpa cek apakah sudah ada
        $job = Tugas::updateOrCreate([
            'pegawai_id' => $pegawaiId,
            // 'asal' => $data['asal'],
            'target' => $targetValue,
            'realisasi' => $data['realisasi'],
            'deadline' => $data['deadline'],
            'keterangan' => $data['keterangan'],
            'volume_tertimbang' => $volumeTertimbang,
            'catatan' => $data['catatan'],
            'jenistask_id' => $data['jenistask_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kirim notifikasi kepada pegawai yang ditugaskan
        $pegawai = User::find($pegawaiId); // Anda perlu menyesuaikan dengan model pengguna Anda
        $pegawai->notify(new create_job($job));
    }

    if ($job) {
        Session::flash('success', 'Tugas berhasil dibuat.');
    } else {
        Session::flash('failed', 'Tugas gagal dibuat.');
    }

    $user = Auth::user();
    if ($user->role == 'admin') {
        return redirect('/simanja/progress');
    } else {
        return redirect('/simanja/progress');
    }
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

    $data = Tugas::find($request->input('id'));
    $data->pegawai_id = $request->input('pegawai_id');

    $data->target = $request->input('target');
    $data->realisasi = $request->input('realisasi');

    $data->deadline = $request->input('deadline');

    $data->catatan = $request->input('catatan');
    $data->jenistask_id = $request->input('jenistask_id');
    // Ganti koma dengan titik untuk memastikan nilai desimal
    $data->target = str_replace(',', '.', $data->target);

    // Dapatkan bobot dari tabel jenis_tasks berdasarkan ID
    $jenisTasks = DB::table('jenis_tasks')->where('no', $data->jenistask_id)->first();
    $data->volume_tertimbang = $data->target * $jenisTasks->bobot;
    $simpan = $data->save();



    if ($simpan) {
        Session::flash('success', 'Tugas berhasil diupdate.');
    } else {
        Session::flash('failed', 'Tugas gagal diupdate.');
    }

    $user = Auth::user();
    if($user->role == 'admin'){
    return redirect('/simanja/progress');}else{
        return redirect('/simanja/progress');
    }


}

public function delete(Request $request)
{
    $id = $request->input('task_id');
        $data = Tugas::find($id);
        if (!$data) {
            Session::flash('error', 'Tugas tidak ditemukan.');
            return redirect('/simanja/progress');
        }

        $delete = $data->delete();

        if ($delete) {
            Session::flash('success', 'Tugas berhasil dihapus.');
        } else {
            Session::flash('failed', 'Tugas gagal dihapus.');
        }

        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect('/simanja/progress');
        }else{
            return redirect('/simanja/progress');
        }
}

public function penilaian(Request $request){

    $data = Tugas::find($request->input('task_id'));
    $data->nilai_kuantitas = $request->input('nilai_kuantitas');
    $data->nilai_kualitas = $request->input('nilai_kualitas');
    $data->keterangan = 'Telah dikonfirmasi';



    // $task->save();
    $simpan = $data->save();
    if ($simpan) {
        Session::flash('success', 'Nilai berhasil dibuat.');
    } else {
        Session::flash('failed', 'Nilai gagal dibuat.');
    }

    $user = Auth::user();
    if($user->role == 'admin'){
    return redirect()->back();}else{
        return redirect()->back();
    }
}

public function kembalikan(Request $request){
    $data = Tugas::find($request->input('task_id'));
    $data->nilai_kuantitas = null;
    $data->nilai_kualitas = null;
    $data->keterangan = 'Belum dikerjakan';
    $data->realisasi = null;
    $data->tgl_realisasi = null;


    $simpan = $data->save();
    if ($simpan) {
        // Kirim notifikasi kepada pegawai yang ditugaskan
        $pegawai = User::find($data->pegawai_id); // Anda perlu menyesuaikan dengan model pengguna Anda
        $pegawai->notify(new return_tugas($data));
        Session::flash('success', 'Pekerjaan berhasil dikembalikan.');
    } else {
        Session::flash('failed', 'Pekerjaan gagal dikembalikan.');
    }
    return redirect('/simanja/progress');
}

public function cetakCKPT(Request $request)
{
    $user_id = $request->input('pegawai_id');
    $tasks = DB::table('jenistasks_users')
            ->join('users', 'jenistasks_users.pegawai_id', '=', 'users.id')
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
        $tasks = DB::table('jenistasks_users')
                ->join('users', 'jenistasks_users.pegawai_id', '=', 'users.id')
                ->whereYear('deadline', '=', Carbon::now()->year)
                ->whereMonth('deadline', '=', Carbon::now()->month)
                ->where('id', '=', $user_id)
                ->get();
        // $bulan = $tasks->

    // Cek apakah $tasks kosong
    if ($tasks->isEmpty()) {
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML('<p>Tidak ada data CKP-T yang tersedia karena task belum dikerjakan.</p>')->setPaper('letter', 'landscape');
        return $pdf->download('CKP-R_Kosong.pdf');
    }

        $pdf = app('dompdf.wrapper');
        $pdf->loadview('ckp-r', ['tasks'=>$tasks])->setPaper('letter', 'landscape');
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

        $import = new TasksImport($validator);

        try {
            // Melakukan impor data dari file excel
            Excel::import($import, public_path('/file_pegawai/' . $nama_file));

            // Jika impor berhasil, alihkan kembali ke halaman dengan pesan sukses
            return redirect('/simanja/progress')->with('success', 'Data berhasil diimpor.');
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
            return redirect('/simanja/progress')->with('failed',$errorMessages);
        }

    }


    public function export_excel(Request $request)
	{
        // Mendapatkan tahun dan bulan sekarang
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Mendapatkan tahun dan bulan dari permintaan
        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);

		return Excel::download(new TasksExport($selectedYear, $selectedMonth), 'Daftar Pekerjaan Pegawai '.$selectedMonth.' '.$selectedYear.'.xlsx');
	}

}
