<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tim;

class JBT extends Model
{
    protected $table = 'users_tim';
    protected $primaryKey = 'no';

    protected $guarded = [];
    protected $casts = [
        'KodeTim' => 'string', // Atur 'tim_id' untuk di-cast sebagai tipe data string (karakter)
    ];

    public function NamaTim(){
        return $this->belongsTo(tim::class, 'KodeTim', 'kode');
    }


}
