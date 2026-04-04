<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{

    public function index()
{
    $data = Peminjaman::with(['buku', 'anggota'])
        ->orderBy('id_peminjaman', 'desc')
        ->get();

    return view('peminjaman.index', compact('data'));

    }

    public function acc($id)
{
    $data = Peminjaman::findOrFail($id);

    // ubah status jadi dipinjam
    $data->status = 'dipinjam';
    $data->save();

    // kurangi stok buku
    $buku = Buku::find($data->buku_id);
    $buku->stok -= 1;
    $buku->save();

    return back()->with('success', 'Peminjaman disetujui');
}

    public function create($id)
{
    $buku = Buku::findOrFail($id);

    $user = Auth::guard('anggota')->user();

$anggota = Anggota::where('user_id', $user->id)->first();

    if (!$anggota) {
        return redirect()->route('login_anggota')
            ->with('error', 'Silahkan login dulu');
    }

    return view('frontend.peminjaman.form', compact('buku', 'anggota'));
}

public function store(Request $request)
{
    $request->validate([
        'buku_id' => 'required',
        'tanggal_pinjam' => 'required|date',
        'tanggal_pengembalian' => 'required|date',
    ]);

    $buku = Buku::findOrFail($request->buku_id);

    if ($buku->stok <= 0) {
        return back()->with('error', 'Stok habis!');
    }

    $user = Auth::guard('anggota')->user();

    $anggota = Anggota::where('user_id', $user->id)->first();

    if (!$anggota) {
        return redirect()->route('login_anggota');
    }

    // batas max 3 buku
    $jumlahPinjam = Peminjaman::where('anggota_id', $anggota->id_anggota)
        ->whereIn('status', ['menunggu', 'dipinjam'])
        ->count();

    if ($jumlahPinjam >= 3) {
        return back()->with('error', 'Maksimal peminjaman 3 buku!');
    }

    // ✅ HANYA SEKALI
    Peminjaman::create([
        'buku_id' => $buku->id_buku,
        'anggota_id' => $anggota->id_anggota,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_pengembalian' => $request->tanggal_pengembalian,
        'status' => 'menunggu'
    ]);

    return redirect('/')->with('success', 'Menunggu konfirmasi petugas');
}


public function history()
{
    $user = Auth::guard('anggota')->user();

    if (!$user) {
        return redirect()->route('login_anggota')
            ->with('error', 'Silahkan login dulu');
    }

    $anggota = Anggota::where('user_id', $user->id)->first();

    if (!$anggota) {
        return back()->with('error', 'Data anggota tidak ditemukan');
    }

    $data = Peminjaman::with('buku')
        ->where('anggota_id', $anggota->id_anggota)
        ->orderBy('id_peminjaman', 'desc')
        ->get();

    foreach ($data as $row) {
        if ($row->status == 'dipinjam') {
            if (now()->gt(\Carbon\Carbon::parse($row->tanggal_pengembalian))) {
                $row->status = 'terlambat';
            }
        }
    }

    return view('frontend.history.index', compact('data'));
}

public function kembalikan($id)
{
    try {
        $pinjam = Peminjaman::findOrFail($id);

        $today = now();
        if (!$pinjam->tanggal_pengembalian) {
    return back()->with('error', 'Tanggal pengembalian tidak valid');
}

$tglKembali = \Carbon\Carbon::parse($pinjam->tanggal_pengembalian);

        $denda = 0;

        if ($today->gt($tglKembali)) {
            $hariTelat = $tglKembali->diffInDays($today);
            $denda = $hariTelat * 2000;
        } else {
            $denda = 0;
        }

        // 🔥 STATUS SELALU DIKEMBALIKAN
        $pinjam->status = 'dikembalikan';

        $pinjam->denda = $denda;
        $pinjam->save();

        // 🔥 FIX DI SINI
        $buku = Buku::find($pinjam->buku_id);
        if ($buku) {
            $buku->increment('stok');
        }

        return redirect()->route('history')->with('success', 'Buku berhasil dikembalikan');

    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}

public function formKembali($id)
{
    $pinjam = Peminjaman::with('buku', 'anggota')->findOrFail($id);

    $today = now();
    $tglKembali = \Carbon\Carbon::parse($pinjam->tanggal_pengembalian);

    $hariTelat = 0;
    $denda = 0;

    if ($today->gt($tglKembali)) {
        $hariTelat = $tglKembali->diffInDays($today);
        $denda = $hariTelat * 2000;
    }

    return view('frontend.pengembalian.index', compact('pinjam', 'denda', 'hariTelat'));
}

}
