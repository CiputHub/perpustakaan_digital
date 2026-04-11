<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class BukuController extends Controller
{
    /**
     * Menampilkan semua data buku
     */
    public function index()
    {
        $buku = Buku::all();
        $kategori = Kategori::all();

        return view('buku.index', compact('buku', 'kategori'));
    }

    /**
     * Menampilkan form tambah buku
     */
    public function create(): View
    {
        $kategori = Kategori::all();
        return view('buku.create', compact('kategori'));
    }

    /**
     * Menyimpan data buku baru
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|min:3',
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'penulis' => 'required|min:5',
            'penerbit' => 'required|min:3',
            'tahun_terbit' => 'required|date',
            'stok' => 'required|min:0',
            'deskripsi' => 'required|min:1',
            'kategori_id' => 'required'
        ]);

        // Upload gambar
        $gambar = $request->file('gambar');
        $gambar->storeAs('buku', $gambar->hashName(), 'public');

        // Simpan ke database
        Buku::create([
            'judul' => $request->judul,
            'gambar' => $gambar->hashName(),
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id
        ]);

        return redirect()->route('buku.index')->with('success', 'Data Berhasil Disimpan!');
    }

    /**
     * Menampilkan detail buku
     */
    public function show(string $id): View
    {
        $buku = Buku::findOrFail($id);
        return view("buku.show", compact('buku'));
    }

    /**
     * Menampilkan form edit buku
     */
    public function edit(string $id): View
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();

        return view("buku.edit", compact('buku', 'kategori'));
    }

    /**
     * Mengupdate data buku
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'judul' => 'required|min:3',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:2048',
            'penulis' => 'required|min:3',
            'penerbit' => 'required|min:3',
            'tahun_terbit' => 'required|date',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required',
            'kategori_id' => 'required'
        ]);

        $buku = Buku::findOrFail($id);

        // Jika upload gambar baru
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            Storage::delete('buku/' . $buku->gambar);

            $gambar = $request->file('gambar');
            $gambar->storeAs('buku', $gambar->hashName(), 'public');

            $buku->update([
                'judul' => $request->judul,
                'gambar' => $gambar->hashName(),
                'penulis' => $request->penulis,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'stok' => $request->stok,
                'deskripsi' => $request->deskripsi,
                'kategori_id' => $request->kategori_id
            ]);
        } else {
            // Update tanpa gambar
            $buku->update($request->except('gambar'));
        }

        return redirect()->route('buku.index')->with('success', 'Data Berhasil Diubah!');
    }

    /**
     * Menghapus data buku
     */
    public function destroy($id): RedirectResponse
    {
        $buku = Buku::findOrFail($id);

        // Cek apakah buku sedang dipinjam
        $dipakai = \App\Models\Peminjaman::where('buku_id', $id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($dipakai) {
            return redirect()->route('buku.index')
                ->with('error', 'Buku masih dipinjam!');
        }

        // Hapus gambar & data
        Storage::disk('public')->delete('buku/' . $buku->gambar);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data Berhasil Dihapus!');
    }

    /**
     * Menampilkan semua buku (frontend)
     */
    public function semuaBuku(Request $request)
    {
        $query = Buku::query();

        // Fitur search
        if ($request->has('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('penulis', 'like', '%' . $request->search . '%')
                ->orWhere('penerbit', 'like', '%' . $request->search . '%');
        }

        $buku = $query->paginate(12);

        return view('frontend.semua-buku', compact('buku'));
    }
}
