<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tim;
use Illuminate\Support\Facades\Session;

class jenistimController extends Controller
{


    public function index()
    {
        // $user_role = Session::get('role');
        // Menampilkan daftar pengguna
        $jenis_tim = tim::all();
        return view('jenistim', ['jenis_tim'=> $jenis_tim]);
    }

    public function storetim(Request $request)
    {
        // Dapatkan semua kode tim yang ada di database
        $existing_codes = Tim::pluck('kode')->toArray();

        // Tentukan kode tim berikutnya berdasarkan urutan abjad
        $next_code = $this->generateNextCode($existing_codes);

        // Buat data tim baru
        $new_tim = new Tim;
        $new_tim->kode = $next_code;
        $new_tim->tim = $request->tim; // Misalnya, asumsikan 'tim' adalah nama tim dari form
        $saved = $new_tim->save();

        if ($saved) {
            Session::flash('success', 'Jenis tim berhasil dibuat.');
        } else {
            Session::flash('error', 'Gagal membuat jenis tim.');
        }

        return redirect('/simanja/jenistim');
    }

    private function generateNextCode($existing_codes)
    {
        // Jika tidak ada kode tim sebelumnya, mulai dari A
        if (empty($existing_codes)) {
            return 'A';
        }

        // Sorting secara alfabetis
        sort($existing_codes);

        // Dapatkan kode tim terakhir
        $last_code = end($existing_codes);

        // Ambil huruf terakhir dari kode tim terakhir
        $last_letter = substr($last_code, -1);

        // Tambahkan 1 huruf berikutnya
        $next_letter = ++$last_letter;

        // Jika huruf berikutnya adalah 'Z', atur kembali menjadi 'A'
        if ($next_letter === 'Z') {
            $next_letter = 'A';
        }

        return $next_letter;
    }

public function updatetim(Request $request){
    $data = tim::find($request->input('kode'));
    $data->tim = $request->input('tim');

    $simpan = $data->save();

    if ($simpan) {
        Session::flash('success', 'jenis tim berhasil diupdate.');
    } else {
        Session::flash('success', 'jenis tim gagal diupdate.');
    }

    return redirect('/simanja/jenistim');
}

public function deletetim(Request $request)
{
    $id = $request->input('kode');

        $data = tim::find($id);
        if (!$data) {
            Session::flash('error', 'jenis tim tidak ditemukan.');
            return redirect('/simanja/jenistim');
        }

        $delete = $data->delete();

        if ($delete) {
            Session::flash('success', 'jenis tim berhasil dihapus.');
        } else {
            Session::flash('error', 'jenis tim gagal dihapus.');
        }

        return redirect('/simanja/jenistim');
}

}
