<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama
     * Role petugas: 4 card (Total Buku, Total Anggota, Dipinjam, Total Transaksi)
     * Role kepala_perpus: 8 card (semua)
     */
    public function index()
    {
        $user = Auth::user();


        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        $totalTransaksi = Peminjaman::count();


        $totalPetugas = Petugas::count();
        $terlambat = Peminjaman::where('status', 'terlambat')->count();
        $selesai = Peminjaman::where('status', 'dikembalikan')->count();
        $totalDenda = Peminjaman::sum('denda');


        $data = Peminjaman::with(['buku', 'anggota'])
            ->latest('id_peminjaman')
            ->limit(5)
            ->get();


        return view('backend.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'peminjamanAktif',
            'totalTransaksi',
            'totalPetugas',
            'terlambat',
            'selesai',
            'totalDenda',
            'data'
        ));
    }
}
