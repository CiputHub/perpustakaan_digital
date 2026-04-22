<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan semua laporan peminjaman
     */
    public function index(Request $request)
{
    $query = Peminjaman::with(['buku', 'anggota']);

    // FILTER
    if ($request->filter == 'hari_ini') {
        $query->whereDate('tanggal_pinjam', now());
    } elseif ($request->filter == 'mingguan') {
        $query->whereBetween('tanggal_pinjam', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($request->filter == 'bulanan') {
        $query->whereMonth('tanggal_pinjam', now()->month);
    }

    $data = $query->latest('id_peminjaman')->get();

    $totalPinjam = $data->count();
    $totalDenda = $data->sum('denda');

    return view('backend.laporan.index', compact('data', 'totalPinjam', 'totalDenda'));
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


    public function exportPdf(Request $request)
{
    $query = Peminjaman::with(['anggota', 'buku']);

    // FILTER SAMA
    if ($request->filter == 'hari_ini') {
        $query->whereDate('tanggal_pinjam', now());
    } elseif ($request->filter == 'mingguan') {
        $query->whereBetween('tanggal_pinjam', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($request->filter == 'bulanan') {
        $query->whereMonth('tanggal_pinjam', now()->month);
    }

    $data = $query->get();

    $totalPinjam = $data->count();
    $totalDenda = $data->sum('denda');

    $pdf = Pdf::loadView('backend.laporan.pdf', compact('data', 'totalPinjam', 'totalDenda'))
        ->setPaper('A4', 'landscape');

    return $pdf->download('laporan_peminjaman.pdf');
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
