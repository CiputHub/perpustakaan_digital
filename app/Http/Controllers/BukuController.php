<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('buku.index', compact('buku'));
    }

      public function create(): View
    {
        return view('buku.create');
    }

     public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul'         => 'required|min:3',
            'gambar'        => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'penulis'       => 'required|min:5',
            'penerbit'      => 'required|min:3',
            'tahun_terbit'  =>'required|date',
            'stok'          =>'required|min:1',
            'deskripsi'     =>'required|min:1'
        ]);

        $gambar = $request->file('gambar');
        $path = $gambar->storeAs('buku', $gambar->hashName(), 'public');

        Buku::create([
            'judul'         => $request->judul,
            'gambar'        => $gambar->hashName(),
            'penulis'       => $request->penulis,
            'penerbit'      => $request->penerbit,
            'tahun_terbit'  => $request->tahun_terbit,
            'stok'          => $request->stok,
            'deskripsi'     => $request->deskripsi
        ]);

        //redirect to index
        return redirect()->route('buku.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

public function show(string $id): View
{
    $buku = Buku::findOrFail($id);
    return view("buku.show", compact('buku'));
}

    public function edit(string $id): View
    {
        $buku = Buku::findOrFail($id);
          return view("buku.edit", compact('buku'));
    }

   public function update(Request $request, $id): RedirectResponse
{
    $request->validate([
        'judul'        => 'required|min:3',
        'gambar'       => 'image|mimes:jpeg,jpg,png|max:2048',
        'penulis'      => 'required|min:3',
        'penerbit'     => 'required|min:3',
        'tahun_terbit' => 'required|date',
        'stok'         => 'required|integer|min:1',
        'deskripsi'    => 'required|min:1'
    ]);

    //get product by ID
        $buku = Buku::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('gambar')) {

            //delete old image
            Storage::delete('buku/' . $buku->gambar);

            //upload new image
            $gambar = $request->file('gambar');
            $gambar->storeAs('buku', $gambar->hashName(), 'public');


            //update product with new image
            $buku->update([
                'judul'         => $request->judul,
                'gambar'        => $gambar->hashName(),
                'penulis'       => $request->penulis,
                'penerbit'      => $request->penerbit,
                'tahun_terbit'  => $request->tahun_terbit,
                'stok'          => $request->stok,
                'deskripsi'     => $request->deskripsi
            ]);
        } else {

            //update product without image
            $buku->update([
                'judul'         => $request->judul,
                'penulis'       => $request->penulis,
                'penerbit'      => $request->penerbit,
                'tahun_terbit'  => $request->tahun_terbit,
                'stok'          => $request->stok,
                'deskripsi'     => $request->deskripsi
            ]);
        }

        //redirect to index
        return redirect()->route('buku.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    public function destroy($id): RedirectResponse
{
    $buku = Buku::findOrFail($id);
    Storage::disk('public')->delete('buku/' . $buku->gambar);
    $buku->delete();

    return redirect()->route('buku.index')

        ->with(['success' => 'Data Berhasil Dihapus!']);
}


public function semuaBuku(Request $request)
{
    $query = Buku::query();

    if ($request->has('search')) {
        $query->where('judul', 'like', '%'.$request->search.'%')
              ->orWhere('penulis', 'like', '%'.$request->search.'%')
              ->orWhere('penerbit', 'like', '%'.$request->search.'%');
    }

    $buku = $query->paginate(12);

    return view('frontend.semua-buku', compact('buku'));
}

}
