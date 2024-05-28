<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim extends Model
{
    protected $table = 'tim';
    protected $primaryKey = 'kode';
    protected $casts = [
        'kode' => 'string', // Atur 'tim_id' untuk di-cast sebagai tipe data string (karakter)
    ];
    protected $guarded = [];
}
