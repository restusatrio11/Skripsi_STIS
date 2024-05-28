<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\jenis_tugas;
use App\Models\tim;
use App\Models\JBT;
use Illuminate\Support\Facades\Session;

class SuperadminController extends Controller
{

    public function index()
    {

        $jenis_tim = tim::all();
        $users = User::join('users_tim','users.id','=','users_tim.NIPpegawai')->join('tim','users_tim.KodeTim','=','tim.kode')->orderBy('name', 'asc')// Mengurutkan secara ascending (A-Z)
        ->get();

        $users = $users->groupBy('NIPpegawai')->map(function ($userGroup) {
            $user = $userGroup->first();
            $user->tim = $userGroup->pluck('tim')->implode(",");
            $user->KodeTim = $userGroup->pluck('KodeTim')->implode(",");
            $user->JabatanPegawai = $userGroup->pluck('JabatanPegawai')->implode(",");
            return $user;
        });

        $jenis_tugas = jenis_tugas::all();
        return view('superadmin', ['users' => $users,'jenis_tugas'=> $jenis_tugas,'jenis_tim' => $jenis_tim]);
    }



    public function store(Request $request){

        $userData = $request->except('email_verified_at','remember_token','created_at','updated_at','jabatan','tim');
        $userData['password'] = bcrypt($userData['password']);

        $simpan = User::create($userData);

        if ($simpan) {
            foreach ($request->tim as $key => $tim) {
                $jabatan = $request->jabatan[$key]; // Mengambil jabatan yang sesuai dengan indeks tim

                JBT::create([
                    'NIPpegawai' => $userData['id'],
                    'JabatanPegawai' => $jabatan,
                    'KodeTim' => $tim,
                ]);
            }

            Session::flash('success', 'Akun berhasil dibuat.');
        } else {
            Session::flash('success', 'Akun gagal dibuat.');
        }

        return redirect('simanja/user');
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
    $data = User::join('users_tim','users.id','=','users_tim.NIPpegawai')->join('tim','users_tim.KodeTim','=','tim.kode')->where('urutan', $request->input('urutan'))->first();

    // Memperbarui data pengguna
    $data->name = $request->input('name');
    $data->email = $request->input('email');
    $data->role = $request->input('role');
    // $data->password = Hash::make($request->input('password'));
    $jbtpegawai = JBT::where('NIPpegawai', $data->id)->get();
    $banyakjbtpegawai =  JBT::where('NIPpegawai', $data->id)->count();
    $jumlahTimPermintaan = count($request->tim);


    foreach ($request->tim as $key => $tim) {
        $jabatan = $request->jabatan[$key];

        if ($jumlahTimPermintaan > $banyakjbtpegawai) {
            // Jika jumlah tim dalam permintaan lebih besar dari jumlah entri JBT yang sudah ada,
            // buat entri baru
            $jbtBaru = new JBT();
            $jbtBaru->NIPpegawai = $data->id;
            $jbtBaru->KodeTim = $tim;
            $jbtBaru->JabatanPegawai = $jabatan;
            $jbtBaru->save();

            // Perbarui jumlah entri JBT yang sudah ada
            $banyakjbtpegawai++;
        }
    }

        $jbtpegawai = JBT::where('NIPpegawai', $data->id)->get();

        foreach ($jbtpegawai as $key => $jbt) {
            $tim = $request->tim[$key];
            $jabatan = $request->jabatan[$key];
            $jbt->KodeTim = $tim;
            $jbt->JabatanPegawai = $jabatan;
            $jbt->save();
        }

    $simpan = $data->save();

    if ($simpan) {
        Session::flash('success', 'Akun berhasil diupdate.');
    } else {
        Session::flash('error', 'Akun gagal diupdate.');
    }

    return redirect('/simanja/user');
}




public function delete(Request $request)
{
    $id = $request->input('id');

    // Hapus entri JBT terkait dengan pengguna
    $jbtDelete = JBT::where('NIPpegawai', $id)->delete();

    // Hapus pengguna
    $data = User::find($id);
    if (!$data) {
        Session::flash('error', 'User tidak ditemukan.');
        return redirect('simanja/progress');
    }

    $delete = $data->delete();

    if ($delete && $jbtDelete !== false) {
        Session::flash('success', 'User berhasil dihapus');
    } else {
        Session::flash('error', 'User gagal dihapus atau terjadi kesalahan saat menghapus entri JBT terkait.');
    }

    return redirect('/simanja/user');
}


public function deleteJbtPegawai($id,$idtim)
{
    $jbtpegawai = JBT::where('no',$id)->where('KodeTim',$idtim)->first();

    if (!$jbtpegawai) {
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
    }

    $jbtpegawai->delete();

    return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.'], 200);
}


public function storejtugas(Request $request){
    $jtugas = $request->except('no');
    $simpan = jenis_tugas::create($jtugas);
    if ($simpan) {
        Session::flash('success', 'Jenis Tugas berhasil dibuat.');
    } else {
        Session::flash('success', 'Jenis Tugas dibuat.');
    }

    // $user = Auth::user();
    // if($user->role == 'admin')
    return redirect('/simanja/superadmin');
}

public function updatejtugas(Request $request){
    $data = jenis_tugas::find($request->input('no'));
    $data->tugas = $request->input('tugas');
    $data->satuan = $request->input('satuan');
    $data->bobot = $request->input('bobot');
    $data->asal_tim = $request->input('asal_tim');

    $simpan = $data->save();


    if ($simpan) {
        Session::flash('success', 'Akun berhasil diupdate.');
    } else {
        Session::flash('success', 'Akun gagal diupdate.');
    }

    // $user = Auth::user();
    // if($user->role == 'admin')
    return redirect('/simanja/superadmin');
}

public function deletejtugas(Request $request)
{
    $no = $request->input('no');

        $data = jenis_tugas::find($no);
        if (!$data) {
            Session::flash('error', 'Jenis Tugas tidak ditemukan.');
            return redirect('admin');
        }

        $delete = $data->delete();

        if ($delete) {
            Session::flash('success', 'Jenis Tugas berhasil dihapus.');
        } else {
            Session::flash('error', 'Jenis Tugas gagal dihapus.');
        }

        // $user = Auth::user();
        // if ($user->role == 'admin') {
        //     return redirect('admin');
        // }
        return redirect('/simanja/superadmin');
}

}
