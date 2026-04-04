<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CekRoleAnggota
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::get('login') || Session::get('role') != 'anggota') {
            return redirect()->route('login_anggota')->with('error','Silahkan login dulu');
        }
        return $next($request);
    }

}
