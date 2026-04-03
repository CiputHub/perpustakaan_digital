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
}
