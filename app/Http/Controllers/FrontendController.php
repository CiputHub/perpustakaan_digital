<?php

namespace App\Http\Controllers;

use App\Models\Buku;


class FrontendController extends Controller
{
    public function index()
{
    $buku = Buku::all(); // ambil data dari database
    return view('frontend.view.index', compact('buku'));
}

public function detail($id)
{
    $buku = Buku::where('id_buku', $id)->firstOrFail();

    return view('frontend.view.detail', compact('buku'));
}

public function semuaBuku()
{
    $buku = Buku::all();
    return view('frontend.view.semua_buku', compact('buku'));
}

}
