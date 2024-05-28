<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputNilai extends Model
{
    protected $table = 'output_nilais';
    protected $guarded = [];
    public function pegawai()
{
    return $this->belongsTo(User::class, 'pegawai_id');
}
}
