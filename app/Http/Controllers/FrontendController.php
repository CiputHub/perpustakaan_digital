<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class FrontendController extends Controller
{
    // 🔥 HALAMAN UTAMA
    public function index()
    {
        // Buku terbaru
        $buku = Buku::with('kategori')
                    ->orderBy('id_buku', 'desc')
                    ->get();

        // Kategori + jumlah buku
        $kategoris = Kategori::withCount('buku')->get();

        // Statistik
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $totalPinjaman = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count();
        $totalKembali = Peminjaman::where('status', 'dikembalikan')->count();

        return view('frontend.view.index', compact(
            'buku',
            'kategoris',
            'totalBuku',
            'totalAnggota',
            'totalPinjaman',
            'totalKembali'
        ));
    }

    // 🔥 FILTER BERDASARKAN KATEGORI
    public function kategoriBuku($id)
    {
        $kategori = Kategori::findOrFail($id);

        $buku = Buku::with('kategori')
                    ->where('kategori_id', $id)
                    ->paginate(12);

        return view('frontend.kategori-buku', compact('kategori', 'buku'));
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
