<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\User;
use App\Models\tim;
use App\Models\OutputNilai;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CTBAExport;
use App\Imports\NNAExport;
use App\Imports\TBExport;
use App\Imports\KPExport;

class ChartController extends Controller
{
    public function index()
    {
        // Dapatkan tugas untuk bulan ini berdasarkan tgl_realisasi
        $tasks = DB::table('jenistasks_users')
                ->join('users', 'jenistasks_users.pegawai_id', '=', 'users.id')
                ->join('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')
                ->whereYear('jenistasks_users.deadline', '=', Carbon::now()->year)
                ->whereMonth('jenistasks_users.deadline', '=', Carbon::now()->month)
                ->get();
        $pegawai = DB::table('users')->where('role', '=', 'user')->get();
        $hasil = DB::table('output_nilais')->get();
        // return view('visual');

        // (1)
        $totalTasks = $this->getFilteredTotalTasks(Carbon::now()->year, Carbon::now()->month);

         //(2)
         $totalCompletedTasks = $this->getFilteredTotalCompletedTasks(Carbon::now()->year, Carbon::now()->month);

        // Menghitung total asal team
        $uniqueAsalTeams = DB::table('tim')
            ->where('kode','!=','H')
            ->select('tim')
            ->distinct()
            ->get();

        $totalAsalTeam = $uniqueAsalTeams->count();

        //(3)
        $totalRealisasi = $this->getFilteredTotalRealisasi(Carbon::now()->year, Carbon::now()->month);

        //(4)
        $totalTarget = $this->getFilteredTotalTarget(Carbon::now()->year, Carbon::now()->month);

        if ($totalTarget != 0) {
            // Melakukan pembagian hanya jika $totalTarget tidak sama dengan nol
            $productivity = round(($totalRealisasi / $totalTarget) * 100, 0);
        } else {
            // Menetapkan nilai default jika $totalTarget sama dengan nol
            $productivity = 0; // Atau nilai default yang sesuai dengan logika bisnis Anda
        }

        // Menghitung produktivitas yang sudah selesai dalam persentase
        if ($totalTasks > 0) {
            $productivityCompleted = round(($totalCompletedTasks / $totalTasks) * 100, 0);
        } else {
            $productivityCompleted = 0;
        }

        //(5)
        $mostActiveEmployee = $this->getFilteredMostActiveEmployee(Carbon::now()->year, Carbon::now()->month);

        //(6)
        $completedTasks = $this->getFilteredCompletedTasks(Carbon::now()->year, Carbon::now()->month);

        //(7)
        $progressTasks = $this->getFilteredProgressTasks(Carbon::now()->year, Carbon::now()->month);

        //(8)
        $notStartedTasks = $this->getFilteredNotStartedTasks(Carbon::now()->year, Carbon::now()->month);

        // Menghitung persentase
        if($totalTasks != 0){
            $completedPercentage = round(($completedTasks / $totalTasks) * 100,2);
            $progressPercentage = round(($progressTasks / $totalTasks) * 100,2);
            $notStartedPercentage = round(($notStartedTasks / $totalTasks) * 100,2);
        }else{
            $completedPercentage = 0;
            $progressPercentage = 0;
            $notStartedPercentage = 0;
        }



        // Menggabungkan data ke dalam format yang sesuai untuk grafik lingkaran
        $data = [
            'Selesai' => $completedTasks,
            'Progress' => $progressTasks,
            'Belum Dikerjakan' => $notStartedTasks,
        ];

        //(9)
        $completedTasksByAsal = $this->getFilteredCompletedTasksByAsal(Carbon::now()->year, Carbon::now()->month);

        $allTeams = Tim::where('kode', '!=', 'H')->pluck('tim');

        // Menggabungkan dengan semua tim
        $mergedData = collect($allTeams)->map(function ($team) use ($completedTasksByAsal) {
        $foundTeam = $completedTasksByAsal->firstWhere('tim', $team);

        return [
            'asal' => $team,
            'total_completed' => $foundTeam ? $foundTeam->presentase_tasks : 0,
        ];
        });

    $currentMonth = Carbon::now()->month; // Ambil bulan saat ini


        //(10)
        $dataavg = $this->getFilteredDataAvg(Carbon::now()->year, Carbon::now()->month);

        //(11)
        $datatotalbobot = $this->getFilteredDataTotalBobot(Carbon::now()->year, Carbon::now()->month);

        //(12)
        $datacount = $this->getFilteredDataCount(Carbon::now()->year, Carbon::now()->month);

            $allpegawai = User::join('users_tim','users.id','=','users_tim.NIPpegawai')->join('tim','users_tim.KodeTim','=','tim.kode')->whereNotIn('name', ['admin', 'user', 'Super Admin'])
            ->whereNotIn('KodeTim', ['H'])
            ->get();

            $allpegawai = $allpegawai->groupBy('NIPpegawai')->map(function ($userGroup) {
                $allpegawai = $userGroup->first();
                $allpegawai->tim = $userGroup->pluck('tim')->implode(",");
                $allpegawai->KodeTim = $userGroup->pluck('KodeTim')->implode(",");
                $allpegawai->JabatanPegawai = $userGroup->pluck('JabatanPegawai')->implode(",");
                return $allpegawai;
            });

            $allpegawai = $allpegawai->pluck('name');

            // Menggabungkan dengan semua pegawai
            $mergedDatacount = collect($allpegawai)->map(function ($allname) use ($datacount) {
            $foundname = $datacount->firstWhere('name', $allname);

            return [
                'name' => $allname,
                'kegiatan' => $foundname ? $foundname->kegiatan : 0,
            ];
            });

            // Menggabungkan dengan semua pegawai
            $mergedDataavg = collect($allpegawai)->map(function ($allname) use ($dataavg) {
                $foundnama = $dataavg->firstWhere('nama', $allname);

                return [
                    'nama' => $allname,
                    'nilai_akhir' => $foundnama ? $foundnama->nilai_akhir : 0,
                ];
            });

            // Menggabungkan dengan semua pegawai
            $mergedDatatotalbobot = collect($allpegawai)->map(function ($allnamee) use ($datatotalbobot) {
                $foundnamaa = $datatotalbobot->firstWhere('nama', $allnamee);

                return [
                    'nama' => $allnamee,
                    'total_bobot' => $foundnamaa ? $foundnamaa->total_bobot : 0,
                ];
            });


        $bulan = Carbon::now()->format('m');
        // return view('dashboard', compact('totalTasks', 'totalAsalTeam', 'productivity', 'mostActiveEmployee'));
        return view('visual', ['tasks' => $tasks,'pegawai' => $pegawai,'totalTasks' => $totalTasks,
        'totalAsalTeam'=> $totalAsalTeam, 'productivity' => $productivity, 'mostActiveEmployee' => $mostActiveEmployee,
        'totalCompletedTasks'=>$totalCompletedTasks,'productivityCompleted' =>$productivityCompleted,'data'=>$data,
        'completedTasksByAsal' => $mergedData,'completedPercentage' => $completedPercentage,'progressPercentage' => $progressPercentage,'notStartedPercentage' => $notStartedPercentage,'totalBobot' => $mergedDatatotalbobot,'dataavg' => $mergedDataavg,'datacount'=>$mergedDatacount,'hasil'=>$hasil,'bulan'=>$bulan]);
    }

    public function filter(Request $request)
    {
        // Ambil data tasks sesuai filter bulan dan tahun yang dipilih
        $year = $request->input('year');
        $month = $request->input('month');

        // Dapatkan tugas untuk bulan ini berdasarkan tgl_realisasi
        $tasks = DB::table('jenistasks_users')
                ->join('users', 'jenistasks_users.pegawai_id', '=', 'users.id')
                ->join('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')
                ->whereYear('jenistasks_users.deadline', '=', Carbon::now()->year)
                ->whereMonth('jenistasks_users.deadline', '=', Carbon::now()->month)
                ->get();
        $pegawai = DB::table('users')->where('role', '=', 'user')->get();
        $hasil = DB::table('output_nilais')->get();
        // return view('visual');

        // (1)
        $totalTasks = $this->getFilteredTotalTasks($year, $month);

         //(2)
         $totalCompletedTasks = $this->getFilteredTotalCompletedTasks($year, $month);

        // Menghitung total asal team
        $uniqueAsalTeams = DB::table('tim')
            ->select('tim')
            ->distinct()
            ->get();

        $totalAsalTeam = $uniqueAsalTeams->count();

        //(3)
        $totalRealisasi = $this->getFilteredTotalRealisasi($year, $month);

        //(4)
        $totalTarget = $this->getFilteredTotalTarget($year, $month);

        if ($totalTarget != 0) {
            // Melakukan pembagian hanya jika $totalTarget tidak sama dengan nol
            $productivity = round(($totalRealisasi / $totalTarget) * 100, 0);
        } else {
            // Menetapkan nilai default jika $totalTarget sama dengan nol
            $productivity = 0; // Atau nilai default yang sesuai dengan logika bisnis Anda
        }

        // Menghitung produktivitas yang sudah selesai dalam persentase
        if ($totalTasks > 0) {
            $productivityCompleted = round(($totalCompletedTasks / $totalTasks) * 100, 0);
        } else {
            $productivityCompleted = 0;
        }

        //(5)
        $mostActiveEmployee = $this->getFilteredMostActiveEmployee($year, $month);

        //(6)
        $completedTasks = $this->getFilteredCompletedTasks($year, $month);

        //(7)
        $progressTasks = $this->getFilteredProgressTasks($year, $month);

        //(8)
        $notStartedTasks = $this->getFilteredNotStartedTasks($year, $month);

        // Menghitung persentase
        if($totalTasks != 0){
            $completedPercentage = round(($completedTasks / $totalTasks) * 100,2);
            $progressPercentage = round(($progressTasks / $totalTasks) * 100,2);
            $notStartedPercentage = round(($notStartedTasks / $totalTasks) * 100,2);
        }else{
            $completedPercentage = 0;
            $progressPercentage = 0;
            $notStartedPercentage = 0;
        }


        // Menggabungkan data ke dalam format yang sesuai untuk grafik lingkaran
        $data = [
            'Selesai' => $completedTasks,
            'Progress' => $progressTasks,
            'Belum Dikerjakan' => $notStartedTasks,
        ];

        //(9)
        $completedTasksByAsal = $this->getFilteredCompletedTasksByAsal($year, $month);


        $allTeams = DB::table('tim')->whereNotIn('kode', ['H'])->pluck('tim');

        // Menggabungkan dengan semua tim
        $mergedData = collect($allTeams)->map(function ($team) use ($completedTasksByAsal) {
        $foundTeam = $completedTasksByAsal->firstWhere('tim', $team);

        return [
            'asal' => $team,
            'total_completed' => $foundTeam ? $foundTeam->presentase_tasks : 0,
        ];
        });


    $currentMonth = Carbon::now()->month; // Ambil bulan saat ini


        //(10)
        $dataavg = $this->getFilteredDataAvg($year, $month);

        //(11)
        $datatotalbobot = $this->getFilteredDataTotalBobot($year, $month);

        //(12)
        $datacount = $this->getFilteredDataCount($year, $month);

            $allpegawai = User::whereNotIn('name', ['admin', 'user', 'Super Admin','RUDI CAHYONO, SST., M.Si
            '])->pluck('name');

            // Menggabungkan dengan semua pegawai
            $mergedDatacount = collect($allpegawai)->map(function ($allname) use ($datacount) {
            $foundname = $datacount->firstWhere('name', $allname);

            return [
                'name' => $allname,
                'kegiatan' => $foundname ? $foundname->kegiatan : 0,
            ];
            });

            // Menggabungkan dengan semua pegawai
            $mergedDataavg = collect($allpegawai)->map(function ($allname) use ($dataavg) {
                $foundnama = $dataavg->firstWhere('nama', $allname);

                return [
                    'nama' => $allname,
                    'nilai_akhir' => $foundnama ? $foundnama->nilai_akhir : 0,
                ];
            });

            // Menggabungkan dengan semua pegawai
            $mergedDatatotalbobot = collect($allpegawai)->map(function ($allnamee) use ($datatotalbobot) {
                $foundnamaa = $datatotalbobot->firstWhere('nama', $allnamee);

                return [
                    'nama' => $allnamee,
                    'total_bobot' => $foundnamaa ? $foundnamaa->total_bobot : 0,
                ];
            });

        // $datacountxavg = DB::table('users')
        //             ->select('name', DB::raw('round(avg(nilai), 2) as nilai'), DB::raw('count(*) as kegiatan'))
        //             ->leftJoin('jenistasks_users', 'users.id', '=', 'jenistasks_users.pegawai_id')
        //             ->groupBy('name')
        //             ->get();





        $bulan = $request->input('month');
        if(!$bulan){
            $bulan = Carbon::now()->format('m');
        }


         // return view('dashboard', compact('totalTasks', 'totalAsalTeam', 'productivity', 'mostActiveEmployee'));
         return view('visual', ['tasks' => $tasks,'pegawai' => $pegawai,'totalTasks' => $totalTasks,
         'totalAsalTeam'=> $totalAsalTeam, 'productivity' => $productivity, 'mostActiveEmployee' => $mostActiveEmployee,
         'totalCompletedTasks'=>$totalCompletedTasks,'productivityCompleted' =>$productivityCompleted,'data'=>$data,
         'completedTasksByAsal' => $mergedData,'completedPercentage' => $completedPercentage,'progressPercentage' => $progressPercentage,'notStartedPercentage' => $notStartedPercentage,'totalBobot' => $mergedDatatotalbobot,'dataavg' => $mergedDataavg,'datacount'=>$mergedDatacount,'hasil'=>$hasil,'bulan'=>$bulan]);
    }

    private function getFilteredTotalTasks($year, $month)
    {
        // Menghitung total tugas di bulan dan tahun saat ini
        $totalTasks = Tugas::whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->count();

        return $totalTasks;
    }

    private function getFilteredTotalCompletedTasks($year, $month){
        // Menghitung total tugas yang sudah selesai
        $totalCompletedTasks = Tugas::whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->where('keterangan', 'Telah dikonfirmasi')->count();

        return $totalCompletedTasks;
    }

    private function getFilteredTotalRealisasi($year,$month){
        // Menghitung produktivitas
        $totalRealisasi = Tugas::whereYear('jenistasks_users.deadline', '=', $year)
                        ->whereMonth('jenistasks_users.deadline', '=', $month)
                        ->sum('realisasi');

        return $totalRealisasi;
    }

    private function getFilteredTotalTarget($year,$month){
        $totalTarget = Tugas::whereYear('jenistasks_users.deadline', '=', $year)
                        ->whereMonth('jenistasks_users.deadline', '=', $month)
                        ->sum('target');

        return $totalTarget;
    }


    private function getFilteredMostActiveEmployee($year,$month){
        // Mencari pegawai paling aktif
        $mostActiveEmployee = Tugas::join('users', 'jenistasks_users.pegawai_id', '=', 'users.id')
        ->whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->select('users.name as nama', DB::raw('SUM(jenistasks_users.realisasi) as total_realisasi'))
        ->groupBy('users.name')
        ->orderByDesc('total_realisasi')
        ->first();

        return $mostActiveEmployee;

    }

    private function getFilteredCompletedTasks($year,$month){
               // Mengambil data dari tabel tugas
               $completedTasks = Tugas::whereYear('jenistasks_users.deadline', '=', $year)
               ->whereMonth('jenistasks_users.deadline', '=', $month)
               ->whereColumn('realisasi', '>=', 'target')->count();

               return $completedTasks;
    }

    private function getFilteredProgressTasks($year,$month){

        $progressTasks = Tugas::whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->whereColumn('realisasi', '<', 'target')->where('realisasi', '>', 0)->count();

        return $progressTasks;
    }

    private function getFilteredNotStartedTasks($year,$month){

        $notStartedTasks = Tugas::whereYear('jenistasks_users.deadline', '=', $year)
                        ->whereMonth('jenistasks_users.deadline', '=', $month)
                        ->where(function ($query) {
                            $query->whereNull('realisasi')
                                ->orWhere('realisasi', '=', 0);
                        })
                        ->count();

        return $notStartedTasks;

    }

    private function getFilteredCompletedTasksByAsal($year,$month){

        $tasksByAsal = DB::table('jenistasks_users')
        ->join('jenis_tasks', 'jenistasks_users.jenistask_id', '=', 'jenis_tasks.no')
        ->join('tim', 'jenis_tasks.tim_id', '=', 'tim.kode')
        ->whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->select('tim.tim', DB::raw('(SUM(CASE WHEN jenistasks_users.keterangan = "Telah dikonfirmasi" THEN 1 ELSE 0 END)/COUNT(*)) as presentase_tasks'))
        ->groupBy('tim.tim')
        ->get();

        return $tasksByAsal;
    }

    private function getFilteredDataAvg($year,$month){
        $dataavg =  DB::table('output_nilais')->select('nama', 'nilai_akhir')
                    ->whereYear('output_nilais.updated_at', '=', $year)
                    ->whereMonth('output_nilais.updated_at', '=', $month)
                    ->get();

        return $dataavg;
    }

    private function getFilteredDataTotalBobot($year,$month){
        $datatotalbobot =  DB::table('output_nilais')->select('nama', 'total_bobot')
                            ->whereYear('output_nilais.updated_at', '=', $year)
                            ->whereMonth('output_nilais.updated_at', '=', $month)
                            ->get();

        return $datatotalbobot;
    }

    private function getFilteredDataCount($year,$month){

        $datacount = DB::table('users')
        ->whereYear('jenistasks_users.deadline', '=', $year)
        ->whereMonth('jenistasks_users.deadline', '=', $month)
        ->select('name', DB::raw('count(jenistask_id) as kegiatan'))
        ->leftJoin('jenistasks_users', 'users.id', '=', 'jenistasks_users.pegawai_id')
        ->groupBy('name')
        ->whereNotIn('name', ['admin', 'user', 'Super Admin'])
        ->get();

        return $datacount;

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

    public function getAvg()
    {
        $data = DB::table('users')
                    ->select('name', DB::raw('round(avg(nilai),2) as nilai'))
                    ->leftJoin('jenistasks_users', 'users.id', '=', 'jenistasks_users.pegawai_id')
                    ->where('role', '=', 'user')
                    ->groupBy('name')
                    ->get();
        return $data;
    }

    public function getCount()
    {
        $data = DB::table('users')
                    ->select('name', DB::raw('count(nama) as kegiatan'))
                    ->leftJoin('jenistasks_users', 'users.id', '=', 'jenistasks_users.pegawai_id')
                    ->where('role', '=', 'user')
                    ->groupBy('name')
                    ->get();
        return $data;
    }

    public function export_excel_ctba(Request $request)
	{
        // Mendapatkan tahun dan bulan sekarang
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Mendapatkan tahun dan bulan dari permintaan
        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);

		return Excel::download(new CTBAExport($selectedYear,$selectedMonth), 'Jumlah selesai tiap Tim '.$selectedMonth.' '.$selectedYear.'.xlsx');
	}

    public function export_excel_namanilaiakhir(Request $request)
	{
        // Mendapatkan tahun dan bulan sekarang
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Mendapatkan tahun dan bulan dari permintaan
        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);

		return Excel::download(new NNAExport($selectedYear,$selectedMonth), 'Nilai Akhir Pegawai '.$selectedMonth.' '.$selectedYear.'.xlsx');
	}

    public function export_excel_totalbobot(Request $request)
	{
        // Mendapatkan tahun dan bulan sekarang
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Mendapatkan tahun dan bulan dari permintaan
        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);

		return Excel::download(new TBExport($selectedYear,$selectedMonth), 'Total Bobot Pegawai '.$selectedMonth.' '.$selectedYear.'.xlsx');
	}

    public function export_excel_kp(Request $request)
	{
        // Mendapatkan tahun dan bulan sekarang
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Mendapatkan tahun dan bulan dari permintaan
        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);

		return Excel::download(new KPExport($selectedYear,$selectedMonth), 'Jumlah Kegiatan Pegawai '.$selectedMonth.' '.$selectedYear.'.xlsx');
	}

}
