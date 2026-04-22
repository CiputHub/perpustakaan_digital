{{--
    ============================================================
    INDEX BLADE - Halaman Daftar Buku
    ============================================================
    Fungsi: Menampilkan semua data buku dalam bentuk tabel
    Route: GET /admin/buku
    Controller: BukuController@index
    Data yang dikirim: $buku (semua data buku), $kategori
    ============================================================
--}}

@extends('backend.layout')  {{-- Memanggil layout utama admin --}}

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold mb-4">Data Buku</h3>
                    </div>
                    <div class="card-body">

                        {{-- ==================== ALERT / NOTIFIKASI ==================== --}}
                        {{-- Alert SUCCESS - Muncul saat ada session 'success' (setelah simpan/update/hapus) --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Alert ERROR - Muncul saat ada session 'error' (gagal hapus karena sedang dipinjam) --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">

                                {{-- Arahkan ke route 'buku.create' yang menampilkan form tambah buku --}}
                                <a href="{{ route('buku.create') }}" class="btn btn-md btn-success mb-3">
                                    <i class="fas fa-plus me-1"></i> Tambah
                                </a>

                                {{-- ==================== HEADER TABEL ==================== --}}
                                <thead>
                                    <tr>
                                        <th>No</th>        {{-- Nomor urut (loop index) --}}
                                        <th>Judul</th>     {{-- Judul buku --}}
                                        <th>Gambar</th>    {{-- Thumbnail gambar buku --}}
                                        <th>Penulis</th>   {{-- Nama penulis --}}
                                        <th>Penerbit</th>  {{-- Nama penerbit --}}
                                        <th>Stok</th>      {{-- Jumlah stok tersedia --}}
                                        <th>Kategori</th>  {{-- Nama kategori (relasi) --}}
                                        <th>Aksi</th>      {{-- Tombol Detail, Edit, Hapus --}}
                                    </tr>
                                </thead>

                                {{-- ==================== BODY TABEL (LOOP DATA) ==================== --}}
                                <tbody>
                                    {{-- Loop setiap data buku yang dikirim dari controller --}}
                                    @foreach ($buku as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $row->judul }}</td>

                                            {{-- Gambar: tampilkan gambar dari storage --}}
                                            <td class="text-center">
                                                <img src="{{ asset('/storage/buku/' . $row->gambar) }}"
                                                     class="rounded"
                                                     style="width: 90px"
                                                     alt="{{ $row->judul }}">
                                            </td>


                                            <td>{{ $row->penulis }}</td>


                                            <td>{{ $row->penerbit }}</td>


                                            <td>{{ $row->stok }}</td>

                                            {{-- Kategori: ambil dari relasi kategori (jika null tampilkan '-') --}}
                                            <td>{{ $row->kategori->nama_kategori ?? '-' }}</td>

                                            {{-- ==================== TOMBOL AKSI ==================== --}}
                                            <td>
                                                {{-- Tombol DETAIL: menuju halaman show --}}
                                                <a href="{{ route('buku.show', $row->id_buku) }}"
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>

                                                {{-- Tombol EDIT: menuju halaman edit --}}
                                                <a href="{{ route('buku.edit', $row->id_buku) }}"
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>

                                                {{--
                                                    Tombol HAPUS:
                                                    - Menggunakan form POST dengan method DELETE
                                                    - Ada konfirmasi sebelum hapus
                                                    - CEK apakah buku sedang dipinjam sebelum hapus
                                                --}}
                                                <form action="{{ route('buku.destroy', $row->id_buku) }}"
                                                      method="POST"
                                                      style="display:inline;"
                                                      onsubmit="return confirm('Yakin hapus data ini?')">

                                                    @csrf      {{-- Token keamanan Laravel --}}
                                                    @method('DELETE')  {{-- Method spoofing untuk DELETE --}}

                                                    {{--
                                                        🔥 PENTING: Cek apakah buku sedang dipinjam
                                                        Jika ada peminjaman dengan status 'dipinjam' atau 'terlambat'
                                                        maka tombol hapus tetap ada tapi akan ditolak di controller
                                                    --}}
                                                    @php
                                                        $dipakai = \App\Models\Peminjaman::where('buku_id', $row->id_buku)
                                                            ->whereIn('status', ['dipinjam', 'terlambat'])
                                                            ->exists();
                                                    @endphp

                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            {{-- Opsional: disable tombol jika sedang dipinjam --}}
                                                            {{-- {{ $dipakai ? 'disabled' : '' }} --}}>
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
