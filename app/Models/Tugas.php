<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\jenis_tugas;
use App\Models\User;


class Tugas extends Model
{

    protected $table = 'jenistasks_users'; // Tentukan nama tabel
    protected $primaryKey = 'task_id';


    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(File::class,'file_id');
    }

    public function jenisTask(){
        return $this->belongsTo(jenis_tugas::class, 'jenistask_id', 'no');
    }

    public function namaUser(){
        return $this->belongsTo(User::class, 'pegawai_id', 'id');
    }
}
