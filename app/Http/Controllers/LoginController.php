<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login_anggota');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('anggota')->attempt($credentials)) {
            // 🔥 CEK ROLE
            if (Auth::guard('anggota')->user()->role != 'anggota') {
                Auth::guard('anggota')->logout();
                return back()->with('error', 'Bukan akun anggota');
            }

            return redirect()->route('frontend.index');
        }

        return back()->with('error', 'Email / Password salah');
    }

    public function logout()
    {
        Auth::guard('anggota')->logout();
        return redirect()->route('login_anggota');
    }
}
