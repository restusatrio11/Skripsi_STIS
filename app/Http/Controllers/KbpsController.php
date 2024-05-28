<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TasksImport;
use App\Imports\TasksExport;
use App\Imports\NAExport;

use App\Models\Tugas;

use App\Models\User;
use App\Models\OutputNilai;
use App\Models\penilaian_KBPS;
use PDF;
use ZipArchive;
use Carbon\Carbon;

class KbpsController extends Controller

{
    public function index()
    {
        // Mengambil data penilaian_KBPS kecuali dengan NIP tertentu
        $nipToExclude = '197812252000121002';
        $datapkbps = penilaian_KBPS::where('nip', '!=', $nipToExclude)->join('users','penilaian_kbps.nip','=','users.id')->orderBy('nama_pegawai','asc')->get();


        return view('kbps', ['datapkbps' => $datapkbps]);
    }

    public function updatepkbps(Request $request){
        $data = penilaian_KBPS::where('nip',$request->input('id'))->first();
        $data->nilaiKBPS = $request->input('nilaiKBPS');
        $simpan = $data->save();
        if ($simpan) {
            Session::flash('success', 'berhasil menilai');
        } else {
            Session::flash('failed', 'gagal menilai');
        }
        return redirect('/simanja/kepala_BPS');
    }

    public function showPekerjaanByNip($nip)
    {
        $pegawai = Tugas::join('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')->join('tim','jenis_tasks.tim_id','=','tim.kode')->where('pegawai_id', $nip)->get();
        $nilai = OutputNilai::where('pegawai_id', $nip)->first();

        $combinedData = [
            'pegawai' => $pegawai,
            'nilai' => $nilai ? $nilai : null,
        ];

        return response()->json($combinedData);
    }

}
