{{--
    ============================================================
    SHOW BLADE - Halaman Detail Buku
    ============================================================
    Fungsi: Menampilkan detail lengkap satu buku
    Route: GET /admin/buku/{id}
    Controller: BukuController@show
    Data yang dikirim: $buku (satu data buku lengkap dengan relasi kategori)
    ============================================================
--}}

@extends('backend.layout')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="text-center mb-4">
                <h3 class="fw-bold">Detail Buku</h3>
                <hr>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">

                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <div class="row">

                                {{-- ==================== KOLOM GAMBAR ==================== --}}
                                <div class="col-md-5 text-center">
                                    <img src="{{ asset('storage/buku/' . $buku->gambar) }}"
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height: 350px; object-fit: cover;"
                                         alt="Gambar {{ $buku->judul }}">
                                </div>

                                {{-- ==================== KOLOM DETAIL ==================== --}}
                                <div class="col-md-7">

                                    {{-- Tabel detail informasi buku --}}
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="150">Judul</th>
                                            <td>: {{ $buku->judul }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penulis</th>
                                            <td>: {{ $buku->penulis }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penerbit</th>
                                            <td>: {{ $buku->penerbit }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tahun Terbit</th>
                                            <td>: {{ \Carbon\Carbon::parse($buku->tahun_terbit)->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Stok</th>
                                            <td>:
                                                <span class="badge bg-primary">
                                                    {{ $buku->stok }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Kategori</th>
                                            <td>:
                                                <span class="badge bg-primary">
                                                    {{ $buku->kategori->nama_kategori ?? '-' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>

                                    {{-- Deskripsi / Sinopsis --}}
                                    <b>
                                        <h5 class="mt-3">📚 Deskripsi/Sinopsis Buku:</h5>
                                    </b>
                                    <p class="text-muted" style="line-height: 1.6;">
                                        {{ $buku->deskripsi ?? 'Tidak ada deskripsi' }}
                                    </p>

                                    {{-- ==================== TOMBOL AKSI ==================== --}}
                                    <div class="mt-3 d-flex gap-2">
                                        <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-1"></i> Kembali
                                        </a>

                                        <a href="{{ route('buku.edit', $buku->id_buku) }}" class="btn btn-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
