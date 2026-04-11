<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthAnggotaController extends Controller
{
    /**
     * Menampilkan form login anggota
     */
    public function loginForm()
    {
        return view('frontend.auth.login_anggota');
    }

    /**
     * Menampilkan form register anggota
     */
    public function registerForm()
    {
        return view('frontend.auth.register_anggota');
    }

    /**
     * Proses register anggota
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:1',
            'nama' => 'required',
        ]);

        // Simpan ke tabel users
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota'
        ]);

        // Simpan ke tabel anggota
        Anggota::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        // Redirect ke login
        return redirect()->route('login_anggota')->with('success', 'Register berhasil');
    }
}
