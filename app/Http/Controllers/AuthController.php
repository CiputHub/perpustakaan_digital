<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\KepalaPerpus;

class AuthController extends Controller
{
    // FORM LOGIN
    public function loginForm()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email','password'))) {
            return redirect()->route('dashboard');
        }

        return back()->with('error','Email atau password salah!');
    }

    public function registerForm()
{
    return view('auth.register');
}

    // FORM REGISTER
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

    // 1. SIMPAN USER
    $user = User::create([
        'username' => $request->username,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => 'kepala_perpus'
    ]);

    // 2. SIMPAN KE KEPALA PERPUS
    KepalaPerpus::create([
        'user_id' => $user->id,
        'nama'    => $request->nama,
        'alamat'  => $request->alamat,
        'no_telepon'  => $request->no_telp
    ]);

    return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
}

    // LOGOUT
   public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
