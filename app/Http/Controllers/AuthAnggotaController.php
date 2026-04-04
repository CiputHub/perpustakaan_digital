<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class AuthAnggotaController extends Controller
{
    // ================= LOGIN =================
    public function loginForm()
    {
        return view('frontend.auth.login_anggota');
    }

    // ================= REGISTER =================
    public function registerForm()
{
    return view('frontend.auth.register_anggota');
}

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:1',
            'nama' => 'required',
        ]);

        // simpan ke users
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota'
        ]);

        // simpan ke anggota
        Anggota::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('login_anggota')->with('success', 'Register berhasil');
    }

}
