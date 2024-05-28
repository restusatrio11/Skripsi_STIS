<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\OutputNilai;
use App\Models\User;
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
use Carbon\Carbon;

use App\Notifications\upload_tugas;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    public function index()
    {
        $user_id = Session::get('id');

        // Ambil data tasks sesuai filter default (bulan dan tahun saat ini)
        $tasks = $this->getFilteredTasks(Carbon::now()->year, Carbon::now()->month);

        // $file = DB::table('files')->join('tasks','files.file_id','=','tasks.task_id')->where('pegawai_id', '=', $user_id)->get();

                // Dapatkan ID pegawai yang sedang login
                $pegawaiId = auth()->user()->id;

                $tugasSelesai = $this->getFilteredTugasSelesai(Carbon::now()->year, Carbon::now()->month);

                $totalTugas = $this->getFilteredTotalTugas(Carbon::now()->year, Carbon::now()->month);

                // Hitung persentase tugas yang sudah diselesaikan
                $persentaseSelesai = ($totalTugas > 0) ? round((($tugasSelesai / $totalTugas) * 100),2) : 0;

                $bulan = Carbon::now()->format('m');

                $projectCount = $this->getFilteredProjectCount(Carbon::now()->year, Carbon::now()->month);

                // Mengambil nilai akhir berdasarkan pegawai yang sedang login
                $nilaiAkhir = $this->getFilteredNilaiAkhir(Carbon::now()->year, Carbon::now()->month);


        $taskes = Tugas::whereYear('jenistasks_users.deadline', '=', Carbon::now()->year)->whereMonth('jenistasks_users.deadline', '=', Carbon::now()->month)->get();

        foreach ($taskes as $task) {
            if ($task->keterangan == 'Belum dikerjakan') {
                // Mendapatkan tanggal saat ini dalam format Y-m-d
                $tanggalSekarang = date('Y-m-d');

                // Mendapatkan tanggal deadline
                $tanggalDeadline = $task->deadline;

                // Mendapatkan tanggal terakhir bulan
                $bulanSekarang = date('n', strtotime($tanggalDeadline));
                $tanggalTerakhirBulan = date('d', strtotime($tanggalDeadline));

                // Ambil tahun saat ini
                $tahunSekarang = date('Y');

                // Tentukan apakah tahun saat ini adalah tahun kabisat atau bukan
                $adalahTahunKabisat = ($tahunSekarang % 4 == 0 && ($tahunSekarang % 100 != 0 || $tahunSekarang % 400 == 0));

                // Jika tanggal deadline adalah 30 atau 31
                if ($tanggalTerakhirBulan == 30 || $tanggalTerakhirBulan == 31 || ($tanggalTerakhirBulan == 29 && $adalahTahunKabisat) || ($bulanSekarang == 2 && $tanggalTerakhirBulan == 28)) {
                    // Mendapatkan tanggal deadline + 3 hari
                    $tanggalDeadlinePlus3Hari = date('Y-m-d', strtotime($tanggalDeadline . ' + 3 days'));


                    // Jika tanggal sekarang melebihi tanggal deadline + 3 hari
                    if ($tanggalSekarang > $tanggalDeadlinePlus3Hari) {
                        // Set nilai_kualitas dan nilai_kuantitas ke 90
                        $task->nilai_kualitas = 90;
                        $task->nilai_kuantitas = 90;
                        // Set keterangan
                        $task->keterangan = "Telah dikonfirmasi";
                    }
                } else {
                    // Jika tanggal deadline melebihi tanggal 27
                    if ($tanggalSekarang >= 27) {
                        // Set nilai_kualitas dan nilai_kuantitas ke 90
                        $task->nilai_kualitas = 90;
                        $task->nilai_kuantitas = 90;
                        // Set keterangan
                        $task->keterangan = "Telah dikonfirmasi";
                    }
                }

                // Simpan perubahan ke database
                $task->save();
            }
        }



        return view('user', ['tasks' => $tasks, 'persentaseSelesai' => $persentaseSelesai,'bulan' => $bulan,'projectCount' => $projectCount,'nilaiAkhir' => $nilaiAkhir]);
    }

    public function filter(Request $request)
    {
        // Ambil data tasks sesuai filter bulan dan tahun yang dipilih
        $year = $request->input('year');
        $month = $request->input('month');

        $tasks = $this->getFilteredTasks($year, $month);
        $user_id = Session::get('id');

        $bulan = $request->input('month');
        if(!$bulan){
            $bulan = Carbon::now()->format('m');
        }

                // Dapatkan ID pegawai yang sedang login
                $pegawaiId = auth()->user()->id;

                // Hitung jumlah tugas yang sudah diselesaikan oleh pegawai tersebut
                $tugasSelesai = $this->getFilteredTugasSelesai($year, $month);

                // Hitung jumlah total tugas yang dimiliki pegawai tersebut
                $totalTugas = $this->getFilteredTotalTugas($year, $month);

                // Hitung persentase tugas yang sudah diselesaikan
                $persentaseSelesai = ($totalTugas > 0) ? round((($tugasSelesai / $totalTugas) * 100),2) : 0;

                $projectCount = $this->getFilteredProjectCount($year, $month);

                // Mengambil nilai akhir berdasarkan pegawai yang sedang login

                $nilaiAkhir = $this->getFilteredNilaiAkhir($year, $month);

        return view('user', ['tasks' => $tasks, 'persentaseSelesai' => $persentaseSelesai,'bulan' => $bulan,'projectCount' => $projectCount,'nilaiAkhir' => $nilaiAkhir]);
    }

    private function getFilteredTasks($year, $month)
    {
        $user_id = Session::get('id');

        $tasks = Tugas::join('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')->join('tim','jenis_tasks.tim_id','=','tim.kode')->whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->where('pegawai_id', '=', $user_id)->get();

        return $tasks;
    }

    private function getFilteredNilaiAkhir($year, $month)
    {
        // Dapatkan ID pegawai yang sedang login
        $pegawaiId = auth()->user()->id;

        $nilaiAkhir = OutputNilai::where('pegawai_id', $pegawaiId)->whereYear('output_nilais.updated_at', '=', $year)
        ->whereMonth('output_nilais.updated_at', '=', $month)->value('nilai_akhir');

        return $nilaiAkhir;
    }

    private function getFilteredTugasSelesai($year, $month)
    {
        // Dapatkan ID pegawai yang sedang login
        $pegawaiId = auth()->user()->id;

        // Hitung jumlah tugas yang sudah diselesaikan oleh pegawai tersebut
        $tugasSelesai = Tugas::where('pegawai_id', $pegawaiId)
        ->whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->where('keterangan', 'Telah dikonfirmasi')
        ->count();

        return $tugasSelesai;
    }

    private function getFilteredTotalTugas($year, $month)
    {
         // Dapatkan ID pegawai yang sedang login
         $pegawaiId = auth()->user()->id;

        // Hitung jumlah total tugas yang dimiliki pegawai tersebut
        $totalTugas = Tugas::whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->where('pegawai_id', $pegawaiId)
        ->count();

        return $totalTugas;
    }

    private function getFilteredProjectCount($year, $month)
    {
        // Dapatkan ID pegawai yang sedang login
        $pegawaiId = auth()->user()->id;

        $projectCount = Tugas::where('pegawai_id', $pegawaiId)
                                ->whereYear('jenistasks_users.deadline', '=', $year)
                                ->whereMonth('jenistasks_users.deadline', '=', $month)
                                ->count();

        return $projectCount;
    }

    public function update(Request $request)
    {
        $data = Tugas::find($request->input('idhidden'));

        // Ambil ID ketua tim dari model Tugas
        $tugas = Tugas::find($request->input('idhidden'));


        $timketua = $tugas->jenisTask->JenisTim->kode;


        // Cari user yang merupakan ketua tim
        $ketuaTim = User::join('users_tim','users.id','=','users_tim.NIPpegawai')->join('tim','users_tim.KodeTim','=','tim.kode')->where('JabatanPegawai','Ketua Tim')->where('KodeTim',$timketua)->first();


        if ($request->input('update') != ""){
            $realisasiSaatIni = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            // $data->tgl_realisasi = $realisasiSaatIni->format('Y-m-d');

            $data->tgl_realisasi = date("Y-m-d", strtotime($request->input('update')));
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

        };
        }

        $data->keterangan = 'Tunggu Konfirmasi';
        // $data->realisasi = $request->input('realisasi');

        // Simpan nilai "realisasi" yang baru dari request ke dalam database
        $data->realisasi = $request->input('realisasi');

        // Ganti koma dengan titik untuk memastikan nilai desimal
        $data->realisasi = str_replace(',', '.', $data->realisasi);

        $data->link_file = $request->input('link_file');

        // Cek apakah nilai "realisasi" yang baru melebihi "target"
        if ($data->realisasi > $data->target) {
            Session::flash('status', 'Nilai realisasi tidak boleh melebihi target');
            return redirect()->back()
                ->with('error', 'Nilai "realisasi" tidak boleh melebihi "target"');
        }

        $simpan = $data->save();

        // Kirim notifikasi ke ketua tim
        $ketuaTim->notify(new upload_tugas($tugas));

        if ($simpan) {
            Session::flash('status', 'Tugas berhasil diupdate');
        } else {
            Session::flash('status', 'Tugas gagal diupdate');
        }
        $user = Auth::user();
        // if ($user->role == 'admin') return redirect('admin');
        // else
        return redirect('/simanja/pekerjaan');
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
