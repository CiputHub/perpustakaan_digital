<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * =========================
     * MENAMPILKAN FORM LOGIN ANGGOTA
     * =========================
     */
    public function showLoginForm()
    {
        return view('frontend.auth.login_anggota');
    }

    /**
     * =========================
     * PROSES LOGIN ANGGOTA
     * =========================
     */
    public function login(Request $request)
    {
        // Ambil email & password dari input
        $credentials = $request->only('email', 'password');

        // Coba login menggunakan guard anggota
        if (Auth::guard('anggota')->attempt($credentials)) {

            // Pastikan role benar-benar anggota
            if (Auth::guard('anggota')->user()->role != 'anggota') {
                Auth::guard('anggota')->logout();
                return back()->with('error', 'Bukan akun anggota');
            }

            // Jika berhasil login
            return redirect()->route('frontend.index');
        }

        // Jika gagal login
        return back()->with('error', 'Email / Password salah');
    }

    /**
     * =========================
     * LOGOUT ANGGOTA
     * =========================
     */
    public function logout()
    {
        Auth::guard('anggota')->logout();
        return redirect()->route('login_anggota');
    }
}
