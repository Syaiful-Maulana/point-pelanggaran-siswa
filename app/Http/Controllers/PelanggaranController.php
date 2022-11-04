<?php

namespace App\Http\Controllers;

use App\Models\Bentuk;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use Yajra\DataTables\Facades\DataTables;

class PelanggaranController extends Controller
{

    public function data(){
        $siswa = Siswa::all();
        return view('pelanggaran.data',compact('siswa'));
    }
    public function pelanggaran($id)
    {
        $pelanggaran = DB::table('pelanggarans')
        ->join('siswas', 'siswas.id', 'pelanggarans.nama_id')
        ->join('kelas', 'kelas.id', 'pelanggarans.kelas_id')
        ->join('bentuks', 'bentuks.id', 'pelanggarans.bentuk_id')
        ->select('pelanggarans.*', 'kelas.kelas as kelas','siswas.nama as nama','bentuks.bentuk as bentuk','bentuks.bobot as bobot')
        ->where('nama_id', $id)
        ->get();
        $siswa = DB::table('siswas')
        ->join('kelas', 'kelas.id', 'siswas.kelas_id')
        ->select('siswas.*', 'kelas.kelas as kelass')
        ->get() 
        ->where('id', $id)
        ->first();
        $bentuk = Bentuk::all();
        $kelas = Kelas::all();
        $siswas = Siswa::all();
        $hitung = Pelanggaran::join()->where('nama_id', $id)->sum('bobot_id');
        $item = Pelanggaran::where('nama_id', $id)->get();
        return view('pelanggaran.siswa', compact('siswa','pelanggaran','kelas','hitung','bentuk', 'siswas', 'item'),['var_id' => $id]);
    }

    public function getPelanggaran(Request $request)
    {
        $data = Bentuk::where('id', $request->id)->first();
        
        $null = [
            'bobot_id' => 0
        ];
        if($data !== null){
            return response()->json(['data' => $data]);
        }else{
            return response()->json(['data' => $null]);
        }
    }

    public function insertPelanggaran(Request $request)
    {
        // return $request;
        $rules = [
            'nama_id' => 'required',
            'bentuk_id' => 'required',
            'bobot_id' => 'required',
        ];
        $text = [
            'nama_id.required' => ' Nama Siswa Tidak Boleh Kosong',
            'bentuk_id.required' => 'Bentuk Pelanggaran Tidak Boleh Kosong',
            'bobot_id.required' => 'Bobot Pelanggaran Tidak Boleh Kosong',
        ];
        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }

        $pelanggaran = new Pelanggaran();
        $pelanggaran->nisn_id = $request['nama_id'];
        $pelanggaran->nama_id = $request['nama_id'];
        $pelanggaran->kelas_id = $request['kelas_id'];
        $pelanggaran->bentuk_id = $request['bentuk_id'];
        $pelanggaran->bobot_id = $request['bobot_id'];
        $pelanggaran->save();
            if($pelanggaran){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
    }

    public function index(){
        $kelas = Kelas::all();
        $bentuk = Bentuk::all();
        $siswa = Siswa::all();
        $data = Pelanggaran::join();
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

        return view('pelanggaran.index', compact('kelas','bentuk','siswa','data'));
    }
    public function store(Request $request){
        $rules = [
            'nama_id' => 'required',
            'kelas_id' => 'required',
            'bentuk_id' => 'required',
            'bobot_id' => 'required',
        ];
        $text = [
            'nama_id.required' => ' Nama Siswa Tidak Boleh Kosong',
            'kelas_id.required' => 'Kelas Tidak Boleh Kosong',
            'bentuk_id.required' => 'Bentuk Pelanggaran Tidak Boleh Kosong',
            'bobot_id.required' => 'Bobot Pelanggaran Tidak Boleh Kosong',
        ];


        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
            $simpan = Pelanggaran::create($request->all());
            if($simpan){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
        }
    public function edit(Request $request){
        $data = Pelanggaran::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $rules = [
            'bentuk_id' => 'required',
        ];
        $text = [
            'bentuk_id.required' => 'Bentuk Pelanggaran Tidak Boleh Kosong',
        ];

        
        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
        $pelanggaran = Pelanggaran::find($request->id);
        $pelanggaran = new Pelanggaran();
        $pelanggaran->nisn_id = $request['nama_id'];
        $pelanggaran->nama_id = $request['nama_id'];
        $pelanggaran->kelas_id = $request['kelas_id'];
        $pelanggaran->bentuk_id = $request['bentuk_id'];
        $pelanggaran->bobot_id = $request['bobot_id'];
        $pelanggaran->update($request->all());
            if($pelanggaran){
                return response()->json(['text'=>'Data Berhasil di Update'],200);
            }else{
                return response()->json(['text'=>'Data Gagal di Update'],422);
            }
    }

    public function delete(Request $request){
        $data = Pelanggaran::find($request->id);
        $simpan = $data->delete($request->all());
        if($simpan){
            return response()->json(['text'=>'Data Berhasil di Hapus'],200);
        }else{
            return response()->json(['text'=>'Data Gagal di Hapus'], 422);
        }
    }


    public function exportPDF(){
        $data = Pelanggaran::join();
        view()->share('data', $data);
        $pdf = PDF::loadview('pelanggaran.dataPDF');
        return $pdf->download('dataPelanggaran.pdf');
    }

}
