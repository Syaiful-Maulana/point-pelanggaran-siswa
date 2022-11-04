<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    
    public function loginPage()
    {
        return view('auth.login-siswa');
    }
    public function loginn(Request $req)
    {
        $this->validate($req, [
            'nisn' => 'required',
            'password' => 'required'
        ]);

        $credential = [
            'nisn' => $req->nisn,
            'password' => $req->password
        ];

        if(Auth::guard('siswa')->attempt($credential, $req->member)){
            return redirect('/homeSiswa')->with('status', 'Selamat datang di halaman admin');
        }
        return redirect('/login')->with('status', 'Username atau Password Salah');
        // dd($req);
    }
}
