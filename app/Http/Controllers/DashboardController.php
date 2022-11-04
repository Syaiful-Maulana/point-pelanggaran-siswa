<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $kategori = Kategori::count();
        $siswa = Siswa::count();
        $kelas = Kelas::count();
        $pelanggar = Pelanggaran::count();
        $kelass = Kelas::all();
        $siswas = Siswa::all();
        // Menyiapkan data chart
        $kategoris = [];
        $data = [];
        foreach($kelass as $sw){
            $kategoris[] = $sw->kelas;
            // $data[] = $sw->kelas_id;
        }
        foreach($siswas as $dt){
            $data[] = $dt->kelas_id;
        }
        // dd($data);
        
        return view('home', compact('kategori','siswa','kelas','pelanggar', 'kategoris','data'));
    }
   
}
