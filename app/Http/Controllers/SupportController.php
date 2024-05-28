<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class SupportController extends Controller
{


    public function index()
    {
        return view('support');
    }

}
