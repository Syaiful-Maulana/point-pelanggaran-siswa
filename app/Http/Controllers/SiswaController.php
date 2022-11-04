<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function isi(){
        $kelas = Kelas::all();
        return view('kelas.dataKelas',compact('kelas'));
    }
    public function detail_kelas($id)
    {
        $siswa = Siswa::where('kelas_id', $id)->get();
        $kelas = Kelas::where('id', $id)->first();
        return view('kelas.siswa',compact('siswa', 'kelas'),['var_id' => $id]);
    }
    public function insertSiswa(Request $request){
        $rules = [
            'nisn' => 'required|unique:siswas|min:9',
            'nama' => 'required',
            'kelas_id' => 'required',
            'tempat' => 'required',
            'ttl' => 'required',
            'alamat' => 'required'
        ];
        $text = [
            'nisn.required' => 'NIS tidak boleh kosong',
            'nisn.min' => 'NIS minimal 9 digit',
            'nisn.unique' => 'NIS Sudah ada',
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'kelas_id.required' => 'Kelas Tidak Boleh Kosong',
            'tempat.required' => 'Tanggal Lahir Tidak Boleh Kosong',
            'ttl.required' => 'Tanggal Lahir Tidak Boleh Kosong',
            'alamat.required' => 'Alamat Tidak Boleh Kosong',
        ];


        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
        $siswa = new siswa();
        $siswa->nisn = $request['nisn'];
        if ($request->password) {
            $siswa->password = bcrypt($request->password);
        }
        
        $siswa->nama = $request['nama'];
        $siswa->kelas_id = $request['kelas_id'];
        $siswa->tempat = $request['tempat'];
        $siswa->ttl = $request['ttl'];
        $siswa->alamat = $request['alamat'];
        $siswa->save();
            if($siswa){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
    }
    
    public function index(){
        $kelas = Kelas::all();
        $data = Siswa::join()->get();
        if(request()->ajax()){
            return datatables()->of($data)
            ->addColumn('aksi', function ($data){
                $button = ' <a href="" style="color:white" class="add btn btn-sm btn-primary" id="'.$data->id.'" name="edit"><i class="fas fa-edit"></i> Pelanggaran Siswa</a>';
                // $button = ' <button class="edit btn btn-sm btn-warning" id="'.$data->id.'" name="edit"><i class="fas fa-edit"></i> Edit</button>';
                // $button .= '  <button class="hapus btn btn-sm btn-danger" id="'.$data->id.'" name="hapus"><i class="fas fa-trash-alt"></i> Hapus</button>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }

        return view('siswa.siswa', compact('kelas'));
    }
    public function store(Request $request){
        $rules = [
            'nisn' => 'required',
            'kelas_id' => 'required',
            'tempat' => 'required',
            'ttl' => 'required',
            'alamat' => 'required'
        ];
        $text = [
            'nisn.required' => 'NISN tidak boleh kosong',
            'kelas_id.required' => 'Kelas Tidak Boleh Kosong',
            'tempat.required' => 'Tanggal Lahir Tidak Boleh Kosong',
            'ttl.required' => 'Tanggal Lahir Tidak Boleh Kosong',
            'alamat.required' => 'Alamat Tidak Boleh Kosong',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
            $simpan = Siswa::create($request->all());
            if($simpan){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
        }
    public function edit(Request $request){
        $data = Siswa::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request){
        $rules = [
            'nisn' => 'required',
            'nama' => 'required',
            'kelas_id' => 'required',
            'tempat' => 'required',
            'ttl' => 'required',
            'alamat' => 'required'
        ];
        $text = [
            'nisn.required' => 'NISN tidak boleh kosong',
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'kelas_id.required' => 'Kelas Tidak Boleh Kosong',
            'tempat.required' => 'Tanggal Lahir Tidak Boleh Kosong',
            'ttl.required' => 'Tanggal Lahir Tidak Boleh Kosong',
            'alamat.required' => 'Alamat Tidak Boleh Kosong',
        ];
        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
        $data = Siswa::find($request->id);
        $simpan = $data->update($request->all());
            if($simpan){
                return response()->json(['text'=>'Data Berhasil di Update'],200);
            }else{
                return response()->json(['text'=>'Data Gagal di Update'],422);
            }
    }

    public function delete(Request $request){
        $data = Siswa::find($request->id);
        $simpan = $data->delete($request->all());
        if($simpan){
            return response()->json(['text'=>'Data Berhasil di Hapus'],200);
        }else{
            return response()->json(['text'=>'Data Gagal di Hapus'], 422);
        }
    }
    public function exportExcel1()
    {
        return Excel::download(new SiswaExport, 'dataSiswa.xlsx');
    }
    public function importExcel1(Request $request){
        
        $data = $request->file('file');
        $nama = $data->getClientOriginalName();
        $data->move('DataSiswa', $nama);
        $simpan = Excel::import(new SiswaImport, \public_path('/DataSiswa/'.$nama));
        if($simpan){
            return response()->json(['text'=>'Data Berhasil Di Simpan'],200);
        }else{
            return response()->json(['text'=>'Data Gagal Di Simpan'], 422);
        }
    }
}
