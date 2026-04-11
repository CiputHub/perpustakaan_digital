<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan semua laporan peminjaman
     */
    public function index()
    {
        $data = Peminjaman::with(['buku', 'anggota'])
            ->latest('id_peminjaman')
            ->get();

        $anggota = Anggota::all();
        $buku = Buku::all();

        return view('backend.laporan.index', compact('data', 'anggota', 'buku'));
    }

    /**
     * Menyimpan data laporan
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required',
            'buku_id' => 'required',
            'tanggal_pinjam' => 'required|date',
        ]);

        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => 'dipinjam'
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Detail laporan
     */
    public function show($id)
    {
        $data = Peminjaman::with(['buku', 'anggota', 'user'])->findOrFail($id);
        return view('backend.laporan.detail', compact('data'));
    }

    /**
     * Form edit laporan
     */
    public function edit($id)
    {
        $data = Peminjaman::findOrFail($id);
        $anggota = Anggota::all();
        $buku = Buku::all();

        return view('backend.laporan.edit', compact('data', 'anggota', 'buku'));
    }

    /**
     * Update laporan
     */
    public function update(Request $request, $id)
    {
        $data = Peminjaman::findOrFail($id);

        $data->update([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => $request->status
        ]);

        return redirect()->route('laporan.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Hapus laporan
     */
    public function destroy($id)
    {
        $data = Peminjaman::findOrFail($id);
        $data->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
