<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\User;
use App\Models\OutputNilai;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\Imports\NAExport;
use Maatwebsite\Excel\Facades\Excel;


class timklatenController extends Controller
{
    public function index()
    {
        // Ambil data tasks sesuai filter default (bulan dan tahun saat ini)
        $tasks = $this->getFilteredTasks(Carbon::now()->year, Carbon::now()->month);

        $pegawai = DB::table('users')->where('role', '=', 'user')->get();

        $hasil = $this->getFilteredHasil(Carbon::now()->year, Carbon::now()->month);



        $dataavg =  DB::table('output_nilais')->select('nama', 'nilai_akhir')->get();



        $bulan = Carbon::now()->format('m');

        // return view('dashboard', compact('totalTasks', 'totalAsalTeam', 'productivity', 'mostActiveEmployee'));
        return view('timklaten', ['tasks' => $tasks,'pegawai' => $pegawai,'hasil'=>$hasil,'bulan'=> $bulan]);
    }

    public function filter(Request $request)
    {
        // Ambil data tasks sesuai filter bulan dan tahun yang dipilih
        $year = $request->input('year');
        $month = $request->input('month');

        $tasks = $this->getFilteredTasks($year, $month);
        $hasil = $this->getFilteredHasil($year,$month);

        $bulan = $request->input('month');
        if(!$bulan){
            $bulan = Carbon::now()->format('m');
        }


        return view('timklaten', ['tasks' => $tasks,'bulan'=>$bulan,'hasil'=> $hasil]);
    }

    private function getFilteredTasks($year, $month)
    {
        // Dapatkan tugas untuk bulan ini berdasarkan tgl_realisasi
        $tasks = DB::table('jenistasks_users')
                ->join('users', 'jenistasks_users.pegawai_id', '=', 'users.id')
                ->join('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')
                ->join('tim','jenis_tasks.tim_id','=','tim.kode')
                ->whereYear('jenistasks_users.deadline', '=', $year)
                ->whereMonth('jenistasks_users.deadline', '=', $month)
                ->orderBy('users.name', 'asc') // Mengurutkan secara ascending (A-Z)
                ->get();


        return $tasks;

    }

    private function getFilteredHasil($year,$month){

        $hasil = DB::table('output_nilais')->whereYear('output_nilais.updated_at', '=', $year)
        ->whereMonth('output_nilais.updated_at', '=', $month)->orderBy('nama', 'asc') // Mengurutkan secara ascending (A-Z)
        ->get();

        return $hasil;
    }

    private function konversiBobotKeNumerik($bobotString)
    {
        switch ($bobotString) {
            case 'Besar':
                return 0.8;
            case 'Sedang':
                return 0.6;
            case 'Kecil':
                return 0.3;
            default:
                return 0; // Nilai default jika tipe bobot tidak dikenali
        }
    }

    public function export_excel_NA(Request $request)
	{
        // Mendapatkan tahun dan bulan sekarang
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Mendapatkan tahun dan bulan dari permintaan
        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);
		return Excel::download(new NAExport($selectedYear,$selectedMonth), 'Nilai Akhir Pegawai '.$selectedMonth.' '.$selectedYear.'.xlsx');
	}

}
