<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(){
        $data = User::all();
        if(request()->ajax()){
            return datatables()->of($data)
            ->addColumn('aksi', function ($data){
                // $button = ' <a href="" style="color:white" class="add btn btn-sm btn-primary" id="'.$data->id.'" name="edit"><i class="fas fa-edit"></i> Pelanggaran Siswa</a>';
                $button = ' <button class="edit btn btn-sm btn-warning" id="'.$data->id.'" name="edit"><i class="fas fa-edit"></i> Edit</button>';
                // $button .= '  <button class="hapus btn btn-sm btn-danger" id="'.$data->id.'" name="hapus"><i class="fas fa-trash-alt"></i> Hapus</button>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
        return view('admin.index', compact('data'));
    }
    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'level' => 'required',
            'password' => 'required',
        ];
        $text = [
            'name.required' => 'Nama User tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'email.required' => 'Emial tidak boleh kosong',
            'level.required' => 'level tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong'
        ];


        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
            $simpan = User::create([
                'name' => $request->name,
                'level' => $request->level,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'remember_token' => Str::random(60)
            ]);
            if($simpan){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
        }
    public function edit(Request $request){
        $data = User::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request){

        $rules = [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ];
        $text = [
            'name.required' => 'Nama User tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'email.required' => 'Emial tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong'
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
        $data = User::find($request->id);
        $simpan = $data->update($request->all());
            if($simpan){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
    }

}
