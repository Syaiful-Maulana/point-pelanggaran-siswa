<?php

namespace App\Http\Controllers;

use App\Models\DetailSanksi;
use App\Models\Sanksi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function index(){
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
                if(auth()->user()->level=='admin' ){
                $button .= ' <button class="edit btn btn-sm btn-warning" id="'.$data->id.'" name="edit"><i class="fas fa-edit"></i> Edit</button>';
                $button .= '  <button class="hapus btn btn-sm btn-danger" id="'.$data->id.'" name="hapus"><i class="fas fa-trash-alt"></i> Hapus</button>';
            }
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }

        return view('tataTertib.sanksi', compact('data'));
    }
    public function store(Request $request){
        $rules = [
            'kriteria' => 'required',
            'bobot' => 'required',
            'sanksi' => 'required',
        ];
        $text = [
            'kriteria.required' => 'Kriteria Pelanggaran Tidak Boleh Kosong',
            'bobot.required' => 'Bobot Pelanggaran Tidak Boleh Kosong',
            'sanksi.required' => 'Sanksi Pelanggaran Tidak Boleh Kosong'
        ];


        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
            $simpan = Sanksi::create($request->all());
            if($simpan){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
        }

    public function edit(Request $request){
        $data = Sanksi::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request){
        $rules = [
            'kriteria' => 'required',
            'bobot' => 'required',
            'sanksi' => 'required',
        ];
        $text = [
            'kriteria.required' => 'Kriteria Pelanggaran Tidak Boleh Kosong',
            'bobot.required' => 'Bobot Pelanggaran Tidak Boleh Kosong',
            'sanksi.required' => 'Sanksi Pelanggaran Tidak Boleh Kosong'
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
        $data = Sanksi::find($request->id);
        $simpan = $data->update($request->all());
            if($simpan){
                    return response()->json(['text'=>'Data Berhasil di Update'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Update'],422);
                }
    }
    public function delete(Request $request){
        $data = Sanksi::find($request->id);
        $simpan = $data->delete($request->all());
        if($simpan){
            return response()->json(['text'=>'Data Berhasil di Hapus'],200);
        }else{
            return response()->json(['text'=>'Data Gagal di Hapus'], 422);
        }
    }

}
