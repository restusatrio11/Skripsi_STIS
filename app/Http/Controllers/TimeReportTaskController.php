<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tugas;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class TimeReportTaskController extends Controller
{


    public function halaman($pegawai_id)
    {
        // Ambil data pegawai berdasarkan pegawai_id
        $pegawai = User::join('users_tim','users.id','=','users_tim.NIPpegawai')->join('tim','users_tim.KodeTim','=','tim.kode')->where('id',$pegawai_id)->get();
        $pegawai = $pegawai->groupBy('NIPpegawai')->map(function ($userGroup) {
            $pegawai = $userGroup->first();
            $pegawai->tim = $userGroup->pluck('tim')->implode(",");
            $pegawai->JabatanPegawai = $userGroup->pluck('JabatanPegawai')->implode(", ");
            return $pegawai;
        });
        $task = $this->getFilteredTimeReport(Carbon::now()->year, Carbon::now()->month, $pegawai_id);

        // Hitung total waktu kerja berdasarkan jumlah dari bobot dikali realisasi
         $totalWaktukerja = $task->sum(function ($item) {
            // Mengalikan bobot dengan realisasi dan mengembalikan hasilnya
            return $item->jenisTask->bobot * $item->realisasi;
         });

         $totalWaktu = $task->sum('volume_tertimbang');

        // Jika pegawai tidak ditemukan, redirect atau berikan respons sesuai kebutuhan
        if (!$pegawai) {
            return redirect()->route('/simanja/timereport/{{$pegawai_id}}')->with('error', 'Pegawai tidak ditemukan');
        }

        // Kirim data ke tampilan
        return view('timereport', ['pegawai'=> $pegawai,'task'=> $task,'totalWaktukerja'=>$totalWaktukerja,'totalWaktu'=>$totalWaktu, 'pegawai_id' => $pegawai_id]);
    }

    public function filter(Request $request)
{
    // Ambil data tasks sesuai filter bulan dan tahun yang dipilih
    $year = $request->input('year');
    $month = $request->input('month');
    $pegawai_id = $request->input('pegawai_id');

    $task = $this->getFilteredTimeReport($year, $month, $pegawai_id);

    $bulan = $request->input('month');
    if(!$bulan){
        $bulan = now()->format('m');
    }

    // Ambil data pegawai berdasarkan pegawai_id
    $pegawai = User::join('users_tim','users.id','=','users_tim.NIPpegawai')->join('tim','users_tim.KodeTim','=','tim.kode')->where('id',$pegawai_id)->get();
    $pegawai = $pegawai->groupBy('NIPpegawai')->map(function ($userGroup) {
        $pegawai = $userGroup->first();
        $pegawai->tim = $userGroup->pluck('tim')->implode(",");
        $pegawai->JabatanPegawai = $userGroup->pluck('JabatanPegawai')->implode(", ");
        return $pegawai;
    });

    // Hitung total waktu kerja berdasarkan jumlah dari bobot dikali realisasi
     $totalWaktukerja = $task->sum(function ($item) {
        // Mengalikan bobot dengan realisasi dan mengembalikan hasilnya
        return $item->jenisTask->bobot * $item->realisasi;
     });

     $totalWaktu = $task->sum('volume_tertimbang');

    // Jika pegawai tidak ditemukan, redirect atau berikan respons sesuai kebutuhan
    if (!$pegawai) {
        return redirect()->route('timereport', ['pegawai_id' => $pegawai_id])->with('error', 'Pegawai tidak ditemukan');
    }

    // Kirim data ke tampilan
    return view('timereport', ['pegawai'=> $pegawai,'task'=> $task,'totalWaktukerja'=>$totalWaktukerja,'totalWaktu'=>$totalWaktu,'pegawai_id' => $pegawai_id]);
}
    private function getFilteredTimeReport($year, $month, $pegawai_id)
    {
        // Dapatkan tugas untuk bulan ini berdasarkan tgl_realisasi
        $tasks = Tugas::join('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')
        ->join('tim','jenis_tasks.tim_id','=','tim.kode')
        ->where('pegawai_id', $pegawai_id)
        ->whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->get();


        return $tasks;

    }

}
