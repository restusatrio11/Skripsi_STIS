<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'urutan',
        'id',
        'name',
        'tim',
        'idtim',
        'jabatan',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'idtim' => 'string',
    ];

    public function TimAnggota(){
        return $this->belongsTo(tim::class, 'idtim', 'kode');
    }

    public function JenisJabatan(){
        return $this->belongsTo(JBT::class, 'id', 'NIPpegawai');
    }

    public function jbtpegawai()
    {
        return $this->hasOne(JBT::class);
    }


}
