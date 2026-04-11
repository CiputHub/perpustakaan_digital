<?php

namespace App\Http\Controllers;

use App\Models\Anggota;

class AnggotaController extends Controller
{
    /**
     * Menampilkan semua data anggota
     */
    public function index()
    {
        // Ambil semua data anggota dari database
        $data = Anggota::all();

        // Kirim data ke view anggota.index
        return view('anggota.index', compact('data'));
    }

    /**
     * Menampilkan detail anggota berdasarkan ID
     */
    public function show($id)
    {
        // Ambil data anggota + relasi user
        $anggota = Anggota::with('user')->findOrFail($id);

        // Kirim ke halaman detail
        return view('anggota.show', compact('anggota'));
    }
}
