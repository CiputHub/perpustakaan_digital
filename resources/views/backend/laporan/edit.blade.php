@extends('layout')

@section('content')

<div class="container">
    <div class="page-inner">

        <div class="text-center mb-4">
            <h3 class="fw-bold">✏️ Edit Data Peminjaman</h3>
            <p class="text-muted">Ubah informasi peminjaman buku</p>
            <hr>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">

                        <form action="{{ route('laporan.update', $data->id_peminjaman) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Anggota -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>Nama Anggota
                                </label>
                                <select name="anggota_id" class="form-select @error('anggota_id') is-invalid @enderror">
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach($anggota as $a)
                                    <option value="{{ $a->id_anggota }}"
                                        {{ $data->anggota_id == $a->id_anggota ? 'selected' : '' }}>
                                        {{ $a->nama }} ({{ $a->nomor_induk ?? $a->nis ?? '-' }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('anggota_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buku -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-book me-2 text-primary"></i>Judul Buku
                                </label>
                                <select name="buku_id" class="form-select @error('buku_id') is-invalid @enderror">
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach($buku as $b)
                                    <option value="{{ $b->id_buku }}"
                                        {{ $data->buku_id == $b->id_buku ? 'selected' : '' }}>
                                        {{ $b->judul }} (Stok: {{ $b->stok }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('buku_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Pinjam
                                </label>
                                <input type="date" name="tanggal_pinjam"
                                    value="{{ old('tanggal_pinjam', $data->tanggal_pinjam) }}"
                                    class="form-control @error('tanggal_pinjam') is-invalid @enderror">
                                @error('tanggal_pinjam')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Kembali -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-check me-2 text-primary"></i>Tanggal Kembali
                                </label>
                                <input type="date" name="tanggal_pengembalian"
                                    value="{{ old('tanggal_pengembalian', $data->tanggal_pengembalian) }}"
                                    class="form-control">
                                <small class="text-muted">Kosongkan jika belum dikembalikan</small>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-tag me-2 text-primary"></i>Status
                                </label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="menunggu" {{ $data->status == 'menunggu' ? 'selected' : '' }}>
                                        ⏳ Menunggu
                                    </option>
                                    <option value="dipinjam" {{ $data->status == 'dipinjam' ? 'selected' : '' }}>
                                        📖 Dipinjam
                                    </option>
                                    <option value="dikembalikan" {{ $data->status == 'dikembalikan' ? 'selected' : '' }}>
                                        ✅ Dikembalikan
                                    </option>
                                    <option value="terlambat" {{ $data->status == 'terlambat' ? 'selected' : '' }}>
                                        ⚠️ Terlambat
                                    </option>
                                </select>
                                @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Denda (Opsional) -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-money-bill-wave me-2 text-primary"></i>Denda (Rp)
                                </label>
                                <input type="number" name="denda"
                                    value="{{ old('denda', $data->denda) }}"
                                    class="form-control"
                                    placeholder="0">
                                <small class="text-muted">Isi jika ada denda keterlambatan</small>
                            </div>

                            <!-- Tombol -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-save me-2"></i>Update
                                </button>
                                <a href="{{ route('laporan.index') }}" class="btn btn-secondary rounded-pill px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .form-select, .form-control {
        border-radius: 0.5rem;
        padding: 0.6rem 1rem;
    }
    .form-select:focus, .form-control:focus {
        box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
        border-color: #0d6efd;
    }
</style>

@endsection
