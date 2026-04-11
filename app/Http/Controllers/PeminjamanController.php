<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * =========================
     * MENAMPILKAN DATA PEMINJAMAN
     * =========================
     */
    public function index()
    {
        // Ambil semua data peminjaman + relasi buku dan anggota
        $data = Peminjaman::with(['buku', 'anggota'])
            ->orderBy('id_peminjaman', 'desc')
            ->get();

        return view('peminjaman.index', compact('data'));
    }

    /**
     * =========================
     * ACC PEMINJAMAN (PETUGAS)
     * =========================
     */
    public function acc($id)
    {
        $data = Peminjaman::findOrFail($id);

        // Ubah status menjadi dipinjam
        $data->status = 'dipinjam';
        $data->save();

        // Kurangi stok buku
        $buku = Buku::find($data->buku_id);
        $buku->stok -= 1;
        $buku->save();

        return back()->with('success', 'Peminjaman disetujui');
    }

    /**
     * =========================
     * FORM PINJAM BUKU (ANGGOTA)
     * =========================
     */
    public function create($id)
    {
        // Cek apakah user sudah login sebagai anggota
        if (!Auth::guard('anggota')->check()) {
            return redirect()->route('login_anggota')
                ->with('error', 'Silahkan login dulu sebelum meminjam!');
        }

        // Ambil data buku
        $buku = Buku::findOrFail($id);

        // Ambil data anggota dari user login
        $user = Auth::guard('anggota')->user();
        $anggota = Anggota::where('user_id', $user->id)->first();

        // Validasi anggota
        if (!$anggota) {
            return redirect()->route('login_anggota')
                ->with('error', 'Data anggota tidak ditemukan');
        }

        return view('frontend.peminjaman.form', compact('buku', 'anggota'));
    }

    /**
     * =========================
     * PROSES SIMPAN PEMINJAMAN
     * =========================
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'buku_id' => 'required',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addDays(7)->format('Y-m-d'),
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        // Cek stok
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok habis!');
        }

        $user = Auth::guard('anggota')->user();
        $anggota = Anggota::where('user_id', $user->id)->first();

        if (!$anggota) {
            return redirect()->route('login_anggota');
        }

        // Maksimal pinjam 3 buku
        $jumlahPinjam = Peminjaman::where('anggota_id', $anggota->id_anggota)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->count();

        if ($jumlahPinjam >= 3) {
            return back()->with('error', 'Maksimal peminjaman 3 buku!');
        }

        // Simpan data peminjaman
        Peminjaman::create([
            'buku_id' => $buku->id_buku,
            'anggota_id' => $anggota->id_anggota,
            'user_id' => $user->id,
            'tanggal_pinjam' => now(),
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => 'menunggu'
        ]);

        return redirect('/')->with('success', 'Menunggu konfirmasi petugas');
    }

    /**
     * =========================
     * HISTORY PEMINJAMAN ANGGOTA
     * =========================
     */
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

        // Ambil data peminjaman milik anggota
        $data = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id_anggota)
            ->orderBy('id_peminjaman', 'desc')
            ->get();

        // Update status otomatis jika terlambat
        foreach ($data as $row) {
            if ($row->status == 'dipinjam') {
                if (now()->gt(Carbon::parse($row->tanggal_pengembalian))) {
                    $row->status = 'terlambat';
                }
            }
        }

        return view('frontend.history.index', compact('data'));
    }

    /**
     * =========================
     * PROSES PENGEMBALIAN BUKU
     * =========================
     */
    public function kembalikan($id)
    {
        try {
            $pinjam = Peminjaman::findOrFail($id);

            // Hitung denda
            $today = now()->startOfDay();
            $tglKembali = Carbon::parse($pinjam->tanggal_pengembalian)->startOfDay();

            $hariTelat = 0;
            $denda = 0;

            if ($today->gt($tglKembali)) {
                $hariTelat = $tglKembali->diffInDays($today);
                $denda = $hariTelat * 2000;
            }

            // Update status & denda
            $pinjam->status = 'dikembalikan';
            $pinjam->denda = $denda;
            $pinjam->save();

            // Tambah stok buku
            $buku = Buku::find($pinjam->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }

            return redirect()->route('history')->with('success', 'Buku berhasil dikembalikan');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * =========================
     * FORM PENGEMBALIAN + DENDA
     * =========================
     */
    public function formKembali($id)
    {
        $pinjam = Peminjaman::with('buku', 'anggota')->findOrFail($id);

        $today = now()->startOfDay();
        $tglKembali = Carbon::parse($pinjam->tanggal_pengembalian)->startOfDay();

        $hariTelat = 0;
        $denda = 0;

        if ($today->gt($tglKembali)) {
            $hariTelat = $tglKembali->diffInDays($today);
            $denda = $hariTelat * 2000;
        }

        return view('frontend.pengembalian.index', compact('pinjam', 'denda', 'hariTelat'));
    }

    /**
     * =========================
     * LAPORAN PEMINJAMAN
     * =========================
     */
    public function laporan()
    {
        $data = Peminjaman::with(['buku', 'anggota'])
            ->orderBy('id_peminjaman', 'desc')
            ->get();

        return view('backend.laporan.index', compact('data'));
    }
}
