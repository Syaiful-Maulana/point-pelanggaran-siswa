<?php

namespace App\Http\Controllers;

use App\Exports\BentukExport;
use App\Imports\BentukImport;
use App\Models\Bentuk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;

class BentukController extends Controller
{
    public function index1(){
        $kategori = Kategori::all();
        // $jumlah = Bentuk::where('kategori', '=', $kategori->id)->count();
        return view('tataTertib.bentuk1',compact('kategori'));
    }
    public function detail_pelanggaran($id)
    {
        $bentuk = Bentuk::where('kategori', $id)->get();
        $kategori = Kategori::where('id', $id)->first();
        // return $bentuk;
        
        return view('tataTertib.piliKategori',compact('bentuk', 'kategori'),['var_id' => $id]);
    }
    public function insert(Request $request){
        $rules = [
            'bentuk' => 'required',
            'bobot' => 'required'
        ];
        $text = [
            'bentuk.required' => 'Bentuk Pelanggaran Tidak Boleh Kosong',
            'bobot.required' => 'Bobot Tidak Boleh Kosong'
        ];


        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
        $bentuk = new Bentuk();
        $bentuk->kategori = $request['kategori'];
        $bentuk->bentuk = $request['bentuk'];
        $bentuk->bobot = $request['bobot'];
        $bentuk->save();
            if($bentuk){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
        }
    
    public function index(){
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

        return view('tataTertib.bentuk', compact('kategori'));
    }
    public function store(Request $request){
        $rules = [
            'kategori' => 'required',
            'bentuk' => 'required',
            'bobot' => 'required'
        ];
        $text = [
            'kategori.required' => 'Kategori Tidak Boleh Kosong',
            'bentuk.required' => 'Bentuk Pelanggaran Tidak Boleh Kosong',
            'bobot.required' => 'Bobot Tidak Boleh Kosong'
        ];


        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
            $simpan = Bentuk::create($request->all());
            if($simpan){
                    return response()->json(['text'=>'Data Berhasil di Simpan'],200);
                }else{
                    return response()->json(['text'=>'Data Gagal di Simpan'],422);
                }
        }
    public function edit(Request $request){
        $data = Bentuk::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request){
        $rules = [
            'bentuk' => 'required',
            'bobot' => 'required'
        ];
        $text = [
            'bentuk.required' => 'Bentuk Pelanggaran Tidak Boleh Kosong',
            'bobot.required' => 'Bobot Tidak Boleh Kosong'
        ];

        
        $validasi = Validator::make($request->all(), $rules, $text);
        if($validasi->fails()){
            return response()->json(['text'=>$validasi->errors()->first(), 'success'=> 0 ],422);
        }
        $data = Bentuk::find($request->id);
        $simpan = $data->update($request->all());
            if($simpan){
                return response()->json(['text'=>'Data Berhasil di Update'],200);
            }else{
                return response()->json(['text'=>'Data Gagal di Update'],422);
            }
    }

    public function delete(Request $request){
        $data = Bentuk::find($request->id);
        $simpan = $data->delete($request->all());
        if($simpan){
            return response()->json(['text'=>'Data Berhasil di Hapus'],200);
        }else{
            return response()->json(['text'=>'Data Gagal di Hapus'], 422);
        }
    }

    public function exportExcel()
    {
        return Excel::download(new BentukExport, 'BentukPelanggaran.xlsx');
    }
    public function importExcel(Request $request){
        
        $data = $request->file('file');
        $nama = $data->getClientOriginalName();
        $data->move('BentukData', $nama);
        $simpan = Excel::import(new BentukImport, \public_path('/BentukData/'.$nama));
        if($simpan){
            return response()->json(['text'=>'Data Berhasil Di Simpan'],200);
        }else{
            return response()->json(['text'=>'Data Gagal Di Simpan'], 422);
        }
    }
}
