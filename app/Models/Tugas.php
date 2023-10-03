<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{

    protected $table = 'tasks'; // Tentukan nama tabel
    protected $primaryKey = 'task_id';
    // protected $fillable = [
    //     'Pegawai',
    //     'nama',
    //     'asal',
    //     'target',
    //     'realisasi',
    //     'satuan',
    //     'deadline',
    //     'tgl_realisasi',
    //     'nilai',
    //     'keterangan',
    //     'file'
    // ];

    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(File::class);
    }

}
