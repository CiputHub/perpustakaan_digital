<?php

namespace App\Http\Controllers;

use App\Models\KepalaPerpus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Menampilkan form login admin
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Hapus session sebelumnya
        Session::flush();

        // Cek login
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        // Jika gagal
        return back()->with('error', 'Email atau password salah!');
    }

    /**
     * Menampilkan form register admin
     */
    public function registerForm()
    {
        return view('auth.register');
    }

    /**
     * Proses register kepala perpustakaan
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:1',
            'nama'     => 'required',
            'alamat'   => 'required',
            'no_telp'  => 'required'
        ]);

        // Simpan user
        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'kepala_perpus'
        ]);

        // Simpan data kepala perpustakaan
        KepalaPerpus::create([
            'user_id' => $user->id,
            'nama'    => $request->nama,
            'alamat'  => $request->alamat,
            'no_telepon'  => $request->no_telp
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
