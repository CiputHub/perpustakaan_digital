<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class FrontendController extends Controller
{
    /**
     * =========================
     * HALAMAN UTAMA (HOME)
     * =========================
     */
    public function index()
    {
        // Ambil semua buku terbaru (descending)
        $buku = Buku::with('kategori')
            ->orderBy('id_buku', 'desc')
            ->get();

        // Ambil kategori + jumlah buku tiap kategori
        $kategoris = Kategori::withCount('buku')->get();

        // Statistik data
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $totalPinjaman = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count();
        $totalKembali = Peminjaman::where('status', 'dikembalikan')->count();

        // Kirim ke view frontend
        return view('frontend.view.index', compact(
            'buku',
            'kategoris',
            'totalBuku',
            'totalAnggota',
            'totalPinjaman',
            'totalKembali'
        ));
    }

    /**
     * =========================
     * FILTER BUKU BERDASARKAN KATEGORI
     * =========================
     */
    public function kategoriBuku($id)
    {
        // Ambil kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Ambil buku sesuai kategori
        $buku = Buku::with('kategori')
            ->where('kategori_id', $id)
            ->paginate(12);

        return view('frontend.kategori-buku', compact('kategori', 'buku'));
    }

    /**
     * =========================
     * DETAIL BUKU
     * =========================
     */
    public function detail($id)
    {
        // Ambil 1 buku berdasarkan ID
        $buku = Buku::where('id_buku', $id)->firstOrFail();

        return view('frontend.view.detail', compact('buku'));
    }

    /**
     * =========================
     * SEMUA BUKU (LIST)
     * =========================
     */
    public function semuaBuku()
    {
        // Ambil semua buku + kategori
        $buku = Buku::with('kategori')
            ->orderBy('id_buku', 'desc')
            ->get();

        // Ambil semua kategori
        $kategoris = Kategori::all();

        return view('frontend.view.semua_buku', compact('buku', 'kategoris'));
    }
}
