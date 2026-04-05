<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;


class FrontendController extends Controller
{

public function index()
{
   $buku = Buku::orderBy('id_buku', 'desc')->get();

    $totalBuku = Buku::count();
    $totalAnggota = Anggota::count();
    $totalPinjaman = Peminjaman::where('status','dipinjam')->count();
    $totalKembali = Peminjaman::where('status','dikembalikan')->count();

    return view('frontend.view.index', compact(
        'buku',
        'totalBuku',
        'totalAnggota',
        'totalPinjaman',
        'totalKembali'
    ));
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
