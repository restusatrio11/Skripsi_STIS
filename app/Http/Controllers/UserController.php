<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $user_id = Session::get('id');
        $tasks = DB::table('tasks')->where('pegawai_id', '=', $user_id)->get();
        return view('user', ['tasks' => $tasks]);
    }
}
