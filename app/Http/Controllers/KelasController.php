<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
class KelasController extends Controller
{

    public function index(){
        $data = Kelas::all();
        if(request()->ajax()){
            return datatables()->of($data)
            ->addColumn('aksi', function ($data){
                $button = ' <a href="" style="color:white" class="add btn btn-sm btn-primary" id="'.$data->id.'" name="edit"><i class="fas fa-edit"></i> Data Siswa</a>';
                if(auth()->user()->level=='admin'){
                    $button .= ' <button class="edit btn btn-sm btn-warning" id="'.$data->id.'" name="edit"><i class="fas fa-edit"></i> Edit</button>';
                    $button .= '  <button class="hapus btn btn-sm btn-danger" id="'.$data->id.'" name="hapus"><i class="fas fa-trash-alt"></i> Hapus</button>';
                }
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }

        return view('kelas.kelas', compact('data'));
    }
    public function store(Request $request){
        $rules = [
            'kelas' => 'required'
        ];
        $text = [
                'kelas.required' => 'kelas Pelanggaran Tidak Boleh Kosong'
        ];


        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
            $simpan = kelas::create($request->all());
            if($simpan){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
        }
    public function edit(Request $request){
        $data = kelas::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request){
        $rules = [
            'kelas' => 'required'
        ];
        $text = [
                'kelas.required' => 'kelas Pelanggaran Tidak Boleh Kosong'
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
        $data = kelas::find($request->id);
        $simpan = $data->update($request->all());
            if($simpan){
                    return response()->json(['text'=>'Data Berhasil di Update'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Update'],422);
                }
    }
    public function delete(Request $request){
        $data = kelas::find($request->id);
        $simpan = $data->delete($request->all());
        if($simpan){
            return response()->json(['text'=>'Data Berhasil di Hapus'],200);
        }else{
            return response()->json(['text'=>'Data Gagal di Hapus'], 422);
        }
    }
}

