<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pelanggaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_id',
        'kelas_id',
        'bentuk_id',
        'bobot_id'
    ];
    public function getCreatedAtFormattedAttribute()
    {
       return $this->created_at->format('H:i d, M Y');
    }
    public static function join(){
        $data = DB::table('pelanggarans')
        ->join('siswas', 'siswas.id', 'pelanggarans.nama_id')
        ->join('kelas', 'kelas.id', 'pelanggarans.kelas_id')
        ->join('bentuks', 'bentuks.id', 'pelanggarans.bentuk_id')
        ->select('pelanggarans.*', 'kelas.kelas as kelas','siswas.nisn as nisn','siswas.nama as nama','bentuks.bentuk as bentuk','bentuks.bobot as bobot')
        ->get();
        return $data;
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }
    public function bentuk()
    {
        return $this->belongsTo(Bentuk::class);
    }

}
