<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // default
    $labelUser = 'Total Anggota';
    $totalUser = Anggota::count();

    // kalau kepala perpus
    if ($user->role == 'kepala_perpus') {
        $labelUser = 'Total Petugas';
        $totalUser = Petugas::count();
    }

    $totalBuku = Buku::count();

    $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
    $terlambat = Peminjaman::where('status', 'terlambat')->count();
    $selesai = Peminjaman::where('status', 'dikembalikan')->count();

    $totalDenda = Peminjaman::sum('denda');
    $totalTransaksi = Peminjaman::count();

    $data = Peminjaman::with(['buku','anggota'])
        ->orderBy('id_peminjaman','desc')
        ->limit(5)
        ->get();

    return view('dashboard', compact(
        'totalBuku',
        'labelUser',
        'totalUser',
        'peminjamanAktif',
        'terlambat',
        'selesai',
        'totalDenda',
        'totalTransaksi',
        'data'
    ));
}
}
