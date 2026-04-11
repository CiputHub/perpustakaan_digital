<?php

namespace App\Http\Controllers;

use App\Models\Anggota;

class AnggotaController extends Controller
{
    public function index()
    {

        $data = Anggota::all();
        return view('anggota.index', compact('data'));
    }

    public function show($id)
    {
        $anggota = Anggota::with('user')->findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }
}
