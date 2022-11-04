<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Bentuk extends Model
{
    use HasFactory;
    protected $fillable = [
        'kategori',
        'bentuk',
        'bobot'
    ];
    public static function join(){
        $data = DB::table('bentuks')
        ->join('kategoris', 'kategoris.id', 'bentuks.kategori')
        ->select('bentuks.*', 'kategoris.kategori as kategoris')
        ->get();
        return $data;
    }
}
