<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
        return view('backend.anggota.index', compact('data'));
    }

    /**
     * Menampilkan detail anggota berdasarkan ID
     */
    public function show($id)
    {
        // Ambil data anggota + relasi user
        $anggota = Anggota::with('user')->findOrFail($id);

        // Kirim ke halaman detail
        return view('backend.anggota.show', compact('anggota'));
    }
}
