<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama
     */
    public function index()
    {
        $user = Auth::user();

        // Default data
        $labelUser = 'Total Anggota';
        $totalUser = Anggota::count();

        // Jika kepala perpustakaan
        if ($user->role == 'kepala_perpus') {
            $labelUser = 'Total Petugas';
            $totalUser = Petugas::count();
        }

        // Statistik
        $totalBuku = Buku::count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        $terlambat = Peminjaman::where('status', 'terlambat')->count();
        $selesai = Peminjaman::where('status', 'dikembalikan')->count();

        $totalDenda = Peminjaman::sum('denda');
        $totalTransaksi = Peminjaman::count();

        // Data terbaru
        $data = Peminjaman::with(['buku', 'anggota'])
            ->latest('id_peminjaman')
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
