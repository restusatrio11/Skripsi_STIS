<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ChartController extends Controller
{
    public function index()
    {
        $tasks = DB::table('tasks')->join('users','tasks.pegawai_id','=','users.id')->get();
        $pegawai = DB::table('users')->where('role', '=', 'user')->get();
        // return view('visual');

        // Menghitung total task
        $totalTasks = Tugas::count();

        // Menghitung total tugas yang sudah selesai
         $totalCompletedTasks = Tugas::where('keterangan', 'Telah dikonfirmasi')->count();

        // Menghitung total asal team
        $uniqueAsalTeams = DB::table('tasks')
            ->select('asal')
            ->distinct()
            ->get();

        $totalAsalTeam = $uniqueAsalTeams->count();

        // Menghitung produktivitas
        $totalRealisasi = Tugas::sum('realisasi');
        $totalTarget = Tugas::sum('target');
        $productivity = round( ($totalRealisasi / $totalTarget) * 100,0);

        // Menghitung produktivitas yang sudah selesai dalam persentase
        if ($totalTasks > 0) {
            $productivityCompleted = round(($totalCompletedTasks / $totalTasks) * 100, 0);
        } else {
            $productivityCompleted = 0;
        }

        // Mencari pegawai paling aktif
        $mostActiveEmployee = Tugas::join('users', 'tasks.pegawai_id', '=', 'users.id')
        ->select('users.name as nama', DB::raw('SUM(tasks.realisasi) as total_realisasi'))
        ->groupBy('users.name')
        ->orderByDesc('total_realisasi')
        ->first();

        // Mengambil data dari tabel tugas
        $completedTasks = Tugas::whereColumn('realisasi', '>=', 'target')->count();
        $progressTasks = Tugas::whereColumn('realisasi', '<', 'target')->count();
        $notStartedTasks = Tugas::whereNull('realisasi')->count();

        // Menghitung persentase
        $completedPercentage = round(($completedTasks / $totalTasks) * 100,2);
        $progressPercentage = round(($progressTasks / $totalTasks) * 100,2);
        $notStartedPercentage = round(($notStartedTasks / $totalTasks) * 100,2);


        // Menggabungkan data ke dalam format yang sesuai untuk grafik lingkaran
        $data = [
            'Selesai' => $completedTasks,
            'Progress' => $progressTasks,
            'Belum Dikerjakan' => $notStartedTasks,
        ];

        $completedTasksByAsal = DB::table('tasks')
        ->select('asal', DB::raw('COUNT(*) as total_completed'))
        ->where('keterangan', 'Telah dikonfirmasi')
        ->groupBy('asal')
        ->get();

        // Ambil semua data tugas
        $taskss = Tugas::all();

        // Inisialisasi array untuk menyimpan total bobot tiap pegawai
        $totalBobot = [];

        // Iterasi melalui setiap tugas
        foreach ($taskss as $task) {
            // Ambil bobot tugas dalam bentuk string
            $bobotString = $task->bobot;

            // Konversi bobot ke nilai numerik berdasarkan tipe bobot
            $bobot = $this->konversiBobotKeNumerik($bobotString);

            // Ambil nama pegawai yang mengerjakan tugas
            $pegawai = User::find($task->pegawai_id);

            // Hitung total bobot tiap pegawai
            if (isset($totalBobot[$pegawai->name])) {
                $totalBobot[$pegawai->name] += $bobot;
            } else {
                $totalBobot[$pegawai->name] = $bobot;
            }
        }

        // $dataavg = DB::table('users')
        //             ->select('name', DB::raw('round(avg(nilai),2) as nilai'))
        //             ->leftJoin('tasks', 'users.id', '=', 'tasks.pegawai_id')
        //             ->groupBy('name')
        //             ->get();

        // $datacount = DB::table('users')
        //             ->select('name', DB::raw('count(nama) as kegiatan'))
        //             ->leftJoin('tasks', 'users.id', '=', 'tasks.pegawai_id')
        //             ->groupBy('name')
        //             ->get();

        $dataavg = DB::table('users')
            ->select('name', DB::raw('round(avg(nilai),2) as nilai'))
            ->leftJoin('tasks', 'users.id', '=', 'tasks.pegawai_id')
            ->groupBy('name')
            ->whereNotIn('name', ['admin', 'user', 'Super Admin'])
            ->get();

        $datacount = DB::table('users')
            ->select('name', DB::raw('count(nama) as kegiatan'))
            ->leftJoin('tasks', 'users.id', '=', 'tasks.pegawai_id')
            ->groupBy('name')
            ->whereNotIn('name', ['admin', 'user', 'Super Admin'])
            ->get();

        $datacountxavg = DB::table('users')
                    ->select('name', DB::raw('round(avg(nilai), 2) as nilai'), DB::raw('count(*) as kegiatan'))
                    ->leftJoin('tasks', 'users.id', '=', 'tasks.pegawai_id')
                    ->groupBy('name')
                    ->get();

        // return view('dashboard', compact('totalTasks', 'totalAsalTeam', 'productivity', 'mostActiveEmployee'));
        return view('visual', ['tasks' => $tasks,'pegawai' => $pegawai,'totalTasks' => $totalTasks,
        'totalAsalTeam'=> $totalAsalTeam, 'productivity' => $productivity, 'mostActiveEmployee' => $mostActiveEmployee,
        'totalCompletedTasks'=>$totalCompletedTasks,'productivityCompleted' =>$productivityCompleted,'data'=>$data,
        'completedTasksByAsal' => $completedTasksByAsal,'completedPercentage' => $completedPercentage,'progressPercentage' => $progressPercentage,
        'notStartedPercentage' => $notStartedPercentage,'totalBobot' => $totalBobot,'dataavg' => $dataavg,
        'datacount'=>$datacount,'datacountxavg' => $datacountxavg]);
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
                    ->leftJoin('tasks', 'users.id', '=', 'tasks.pegawai_id')
                    ->where('role', '=', 'user')
                    ->groupBy('name')
                    ->get();
        return $data;
    }

    public function getCount()
    {
        $data = DB::table('users')
                    ->select('name', DB::raw('count(nama) as kegiatan'))
                    ->leftJoin('tasks', 'users.id', '=', 'tasks.pegawai_id')
                    ->where('role', '=', 'user')
                    ->groupBy('name')
                    ->get();
        return $data;
    }

}
