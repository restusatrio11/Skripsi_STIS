<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = ['id','file_id','file_name', 'file_path'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
