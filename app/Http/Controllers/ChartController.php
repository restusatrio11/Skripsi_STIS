<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
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
        return view('visual');
    }

    public function getAvg()
    {
        $data = DB::table('users')
                    ->select('name', DB::raw('avg(nilai) as nilai'))
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