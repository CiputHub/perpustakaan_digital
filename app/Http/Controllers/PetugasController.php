<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PetugasController extends Controller
{
    /**
     * =========================
     * MENAMPILKAN DATA PETUGAS
     * =========================
     */
    public function index(): View
    {
        $data = Petugas::with('user')->get();
        return view('petugas.index', compact('data'));
    }

    /**
     * =========================
     * FORM TAMBAH PETUGAS
     * =========================
     */
    public function create(): View
    {
        return view('petugas.create');
    }

    /**
     * =========================
     * SIMPAN DATA PETUGAS
     * =========================
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'username' => 'required|min:4|max:20|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:2',
            'nama' => 'required|min:3|max:100',
            'no_telepon' => 'required|min:3|max:15|unique:petugas,no_telepon',
            'alamat' => 'required|min:5'
        ]);

        // Simpan ke tabel user
        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas'
        ]);

        // Simpan ke tabel petugas
        Petugas::create([
            'user_id'     => $user->id,
            'nama'        => $request->nama,
            'no_telepon'  => $request->no_telepon,
            'alamat'      => $request->alamat
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil dibuat!');
    }

    /**
     * =========================
     * DETAIL PETUGAS
     * =========================
     */
    public function show($id): View
    {
        $petugas = Petugas::with('user')->findOrFail($id);
        return view('petugas.show', compact('petugas'));
    }

    /**
     * =========================
     * FORM EDIT PETUGAS
     * =========================
     */
    public function edit($id): View
    {
        $petugas = Petugas::with('user')->findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    /**
     * =========================
     * UPDATE DATA PETUGAS
     * =========================
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $petugas = Petugas::findOrFail($id);
        $user = User::findOrFail($petugas->user_id);

        // Validasi input
        $request->validate([
            'username' => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:1',
            'nama'       => 'required',
            'no_telepon' => 'required',
            'alamat'     => 'required'
        ]);

        // Update user
        $user->update([
            'username' => $request->username,
            'email'    => $request->email,
        ]);

        // Update password jika diisi
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // Update petugas
        $petugas->update([
            'nama'       => $request->nama,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Data berhasil diupdate!');
    }

    /**
     * =========================
     * HAPUS PETUGAS
     * =========================
     */
    public function destroy($id): RedirectResponse
    {
        $petugas = Petugas::findOrFail($id);
        $user = User::findOrFail($petugas->user_id);

        // Hapus data
        $petugas->delete();
        $user->delete();

        return redirect()->route('petugas.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}
