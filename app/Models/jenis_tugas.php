<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tim;

class jenis_tugas extends Model
{
    protected $table = 'jenis_tasks';
    protected $primaryKey = 'no';

    protected $guarded = [];
    protected $casts = [
        'no' => 'string',
        'tim_id' => 'string', // Atur 'tim_id' untuk di-cast sebagai tipe data string (karakter)
    ];
    public function jenisTim(){
        return $this->belongsTo(tim::class, 'tim_id', 'kode');
    }

}
