<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use \Illuminate\Contracts\Auth\Authenticatable;

class Siswa extends Authenticatable {
    protected $table = 'siswas';
    public $incrementing = false;
    protected $guard = 'siswa';
    use HasApiTokens, HasFactory, Notifiable;
    // use HasFactory;
    protected $fillable = [
        'nisn',
        'nama',
        'password',
        'kelas_id',
        'tempat',
        'ttl',
        'jekel',
        'alamat',
    ];
    public static function join(){
        $data = DB::table('siswas')
        ->join('kelas', 'kelas.id', 'siswas.kelas_id')
        ->select('siswas.*', 'kelas.kelas as kelas');
        return $data;
    }
    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


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
    ];
}
