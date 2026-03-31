<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PeminjamanController extends Controller
{

    public function index()
    {
        $data = Peminjaman::all();
        return view('peminjaman.index', compact('data'));
    }
}
