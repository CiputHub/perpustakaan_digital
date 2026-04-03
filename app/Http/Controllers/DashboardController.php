<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
{
    $data = Peminjaman::all(); // ambil data

    return view('dashboard', compact('data'));
}
}
