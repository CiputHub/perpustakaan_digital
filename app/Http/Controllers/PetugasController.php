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
    // ================= INDEX =================
    public function index(): View
    {
        $data = Petugas::with('user')->get();
        return view('petugas.index', compact('data'));
    }

    // ================= CREATE =================
    public function create(): View
    {
        return view('petugas.create');
    }

    // ================= STORE =================
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'username'   => 'required',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:1',

            'nama'       => 'required',
            'no_telepon' => 'required',
            'alamat'     => 'required'
        ]);

        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas'
        ]);

        Petugas::create([
            'user_id'     => $user->id,
            'nama'        => $request->nama,
            'no_telepon'  => $request->no_telepon,
            'alamat'      => $request->alamat
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil dibuat!');
    }

    // ================= SHOW =================
    public function show($id): View
    {
        $petugas = Petugas::with('user')->findOrFail($id);
        return view('petugas.show', compact('petugas'));
    }

    // ================= EDIT =================
    public function edit($id): View
    {
        $petugas = Petugas::with('user')->findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id): RedirectResponse
    {
        $petugas = Petugas::findOrFail($id);
        $user = User::findOrFail($petugas->user_id);

        $request->validate([
            'username' => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:1',

            'nama'       => 'required',
            'no_telepon' => 'required',
            'alamat'     => 'required'
        ]);

        // update user
        $user->update([
            'username' => $request->username,
            'email'    => $request->email,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // update petugas
        $petugas->update([
            'nama'       => $request->nama,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Data berhasil diupdate!');
    }

    // ================= DELETE =================
    public function destroy($id): RedirectResponse
    {
        $petugas = Petugas::findOrFail($id);
        $user = User::findOrFail($petugas->user_id);

        $petugas->delete();
        $user->delete();

        return redirect()->route('petugas.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}
