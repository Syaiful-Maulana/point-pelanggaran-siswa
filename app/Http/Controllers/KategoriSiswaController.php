<?php

namespace App\Http\Controllers;
use App\Models\Bentuk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use App\Models\Sanksi;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use Yajra\DataTables\Facades\DataTables;

class KategoriSiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:siswa');
    }
    public function indexSiswa(){
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
        
        return view('homeSiswa', compact('kategori','siswa','kelas','pelanggar', 'kategoris','data'));
    }
    public function index1(Request $request)
    {
        if($request->has('search')){
            $data = Kategori::where('kategori','LIKE', '%' .$request->search. '%')->paginate(5);
        }else{
            $data = Kategori::paginate(5);
        }
        // return $data;
        return view('tataTertib.kategori', compact('data')) ;
    }
    public function index(){
        $data = Kategori::all();
        if(request()->ajax()){
            return datatables()->of($data)
            ->addColumn('aksi', function ($data){
                $button = ' <a href="" style="color:white" class="add btn btn-sm btn-primary" id="'.$data->id.'" name="edit"><i class="fas fa-edit"></i> Bentuk Pelanggaran</a>';

                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }

        return view('componentSiswa.tataTertib.kategori', compact('data'));
    }

    public function bentuk(){
        $kategori = Kategori::all();
        $data = Bentuk::join();
        if(request()->ajax()){
            return datatables()->of($data)
            ->addColumn('aksi', function ($data){
                $button = ' <button class="edit btn btn-sm btn-warning" id="'.$data->id.'" name="edit"><i class="fas fa-edit"></i> Edit</button>';
                $button .= '  <button class="hapus btn btn-sm btn-danger" id="'.$data->id.'" name="hapus"><i class="fas fa-trash-alt"></i> Hapus</button>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }

        return view('componentSiswa.tataTertib.bentuk', compact('kategori'));
    }
    public function sanksi(){
        // $detail = DetailSanksi::all();
        $data = Sanksi::all();
        if(request()->ajax()){
            return datatables()->of($data)
            // ->addColumn('sanksi', function($data){
            //     $button = '<button class="lihat btn btn-success" id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#modal-add'.$data->id .'"><i class="fas fa-edit"></i>Tambah Sanksi</button>';
            //     return $button;
            // })
            // return datatables()->of($data)
            ->addColumn('aksi', function ($data){
                $button = '<button class="lihat btn btn-success" id="'.$data->id.'" data-bs-toggle="modal" data-bs-target="#modal-lihat'.$data->id .'"><i class="fas fa-edit"></i>Lihat Sanksi</button>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }

        return view('componentSiswa.tataTertib.sanksi', compact('data'));
    }

    public function detail()
    {
        $pelanggaran = DB::table('pelanggarans')
        ->join('siswas', 'siswas.id', 'pelanggarans.nama_id')
        ->join('kelas', 'kelas.id', 'pelanggarans.kelas_id')
        ->join('bentuks', 'bentuks.id', 'pelanggarans.bentuk_id')
        ->select('pelanggarans.*', 'kelas.kelas as kelas','siswas.nama as nama','bentuks.bentuk as bentuk','bentuks.bobot as bobot')
        ->where('nama_id',  auth()->user()->id)
        ->get();
        // $siswa = DB::table('siswas')
        // ->join('kelas', 'kelas.id', 'siswas.kelas_id')
        // ->select('siswas.*', 'kelas.kelas as kelass')
        // ->get() 
        // ->where('id', $id)
        // ->first();
        // $bentuk = Bentuk::all();
        // $kelas = Kelas::all();
        // $siswas = Siswa::all();
        $hitung = Pelanggaran::join()->where('nama_id', auth()->user()->id)->sum('bobot_id');
        // $item = Pelanggaran::where('nama_id', $id)->get();
        // return view('componentSiswa.tataTertib.detail', compact('siswa','pelanggaran','kelas','hitung','bentuk', 'siswas', 'item'),['var_id' => $id]);
        return view('componentSiswa.tataTertib.detail',compact('hitung','pelanggaran'));
    }
}
