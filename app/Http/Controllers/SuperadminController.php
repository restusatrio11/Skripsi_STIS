<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class SuperadminController extends Controller
{
    // public function index()
    // {
    //     // Menampilkan daftar pengguna
    //     $users = User::all();
    //     // return view('superadmin.index', compact('users'));
    //     return view('superadmin', ['users' => $users]);
    // }

    // public function create()
    // {
    //     // Menampilkan formulir untuk membuat pengguna baru
    //     return view('superadmin.create');
    // }

    // public function store(Request $request)
    // {
    //     // Menyimpan pengguna baru ke database
    //     $userData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|string|min:8',
    //         'role' => 'required|string',
    //     ]);

    //     $userData['password'] = bcrypt($userData['password']);
    //     User::create($userData);

    //     return redirect()->route('superadmin.index')
    //         ->with('success', 'Pengguna berhasil dibuat.');
    // }

    // public function edit(User $user)
    // {
    //     // Menampilkan formulir untuk mengedit pengguna
    //     return view('superadmin.edit', compact('user'));
    // }

    // public function update(Request $request, User $user)
    // {
    //     // Mengupdate data pengguna
    //     $userData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $user->id,
    //         'role' => 'required|string',
    //     ]);

    //     $user->update($userData);

    //     return redirect()->route('superadmin.index')
    //         ->with('success', 'Pengguna berhasil diperbarui.');
    // }

    // public function destroy(User $user)
    // {
    //     // Menghapus pengguna
    //     $user->delete();

    //     return redirect()->route('superadmin.index')
    //         ->with('success', 'Pengguna berhasil dihapus.');
    // }

    public function index()
    {
        // $user_role = Session::get('role');
        // Menampilkan daftar pengguna
        $users = User::all();
        return view('superadmin', ['users' => $users]);
    }

    public function store(Request $request){

        // Menyimpan pengguna baru ke database
        // $userData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|string|min:8',
        //     'role' => 'required|string',
        // ]);

        $userData = $request->except('email_verified_at','remember_token','created_at','updated_at');
        $userData['password'] = bcrypt($userData['password']);


        $simpan = User::create($userData);
        if ($simpan) {
            Session::flash('success', 'Akun berhasil dibuat.');
        } else {
            Session::flash('success', 'Akun gagal dibuat.');
        }

        // $user = Auth::user();
        // if($user->role == 'admin')
        return redirect('superadmin');
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


    // // Mengupdate data pengguna
    //     $userData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $user->id,
    //         'role' => 'required|string',
    //     ]);
    // dd($request->all());
    $data = User::find($request->input('id'));
    // $data->pegawai_id = $request->input('pegawai_id');
    $data->name = $request->input('name');
    $data->email = $request->input('email');
    $data->role = $request->input('role');
    $data->password = bcrypt($request->input('password'));

    $simpan = $data->save();


    if ($simpan) {
        Session::flash('success', 'Akun berhasil diupdate.');
    } else {
        Session::flash('success', 'Akun gagal diupdate.');
    }

    // $user = Auth::user();
    // if($user->role == 'admin')
    return redirect('superadmin');
    // return view('admin', ['data' => $data]);

}

public function delete(Request $request)
{
    $id = $request->input('id');

        $data = User::find($id);
        if (!$data) {
            Session::flash('error', 'User tidak ditemukan.');
            return redirect('admin');
        }

        $delete = $data->delete();

        if ($delete) {
            Session::flash('success', 'User berhasil dihapus.');
        } else {
            Session::flash('error', 'User gagal dihapus.');
        }

        // $user = Auth::user();
        // if ($user->role == 'admin') {
        //     return redirect('admin');
        // }
        return redirect('superadmin');
}
}
