{{--
    ============================================================
    EDIT BLADE - Form Edit Buku
    ============================================================
    Fungsi: Form untuk mengedit data buku yang sudah ada
    Route: GET /admin/buku/{id}/edit
    Controller: BukuController@edit
    Data yang dikirim: $buku (data buku yang akan diedit), $kategori
    Form submit ke: route('buku.update', $buku->id_buku) method PUT
    ============================================================
--}}

@extends('layout')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="text-center mb-4">
                <h3>Edit Data Buku</h3>
                <hr>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            {{--
                                FORM EDIT BUKU
                                - method: POST (dengan @method('PUT'))
                                - enctype: multipart/form-data (karena upload file gambar)
                            --}}
                            <form action="{{ route('buku.update', $buku->id_buku) }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')  {{-- Method spoofing untuk PUT --}}

                                {{-- ==================== FIELD JUDUL ==================== --}}
                                <div class="mb-3">
                                    <label>Judul</label>
                                    <input type="text"
                                           name="judul"
                                           value="{{ old('judul', $buku->judul) }}"  {{-- old() lebih prioritas --}}
                                           class="form-control @error('judul') is-invalid @enderror">

                                    @error('judul')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- ==================== FIELD GAMBAR ==================== --}}
                                <div class="mb-3">
                                    <label>Gambar</label>

                                    {{-- Tampilkan gambar lama jika ada --}}
                                    @if ($buku->gambar)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/buku/' . $buku->gambar) }}"
                                                 width="120"
                                                 alt="Gambar {{ $buku->judul }}">
                                            <small class="text-muted d-block">Gambar saat ini</small>
                                        </div>
                                    @endif

                                    {{-- Input upload gambar baru (opsional) --}}
                                    <input type="file" name="gambar" class="form-control">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                </div>

                                {{-- ==================== FIELD PENULIS ==================== --}}
                                <div class="mb-3">
                                    <label>Penulis</label>
                                    <input type="text"
                                           name="penulis"
                                           value="{{ old('penulis', $buku->penulis) }}"
                                           class="form-control">
                                </div>

                                {{-- ==================== FIELD PENERBIT ==================== --}}
                                <div class="mb-3">
                                    <label>Penerbit</label>
                                    <input type="text"
                                           name="penerbit"
                                           value="{{ old('penerbit', $buku->penerbit) }}"
                                           class="form-control">
                                </div>

                                {{-- ==================== FIELD TAHUN TERBIT ==================== --}}
                                <div class="mb-3">
                                    <label>Tahun Terbit</label>
                                    <input type="date"
                                           name="tahun_terbit"
                                           value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                                           class="form-control">
                                </div>

                                {{-- ==================== FIELD DESKRIPSI ==================== --}}
                                <div class="mb-3">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi"
                                              class="form-control">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                                </div>

                                {{-- ==================== FIELD STOK ==================== --}}
                                {{-- 🔥 Stok tidak boleh minus --}}
                                <div class="mb-3">
                                    <label>Stok</label>
                                    <input type="number"
                                           name="stok"
                                           value="{{ old('stok', $buku->stok) }}"
                                           class="form-control"
                                           min="0"
                                           step="1"
                                           oninput="this.value = Math.abs(this.value)"
                                           required>
                                    <small class="text-muted">Stok minimal 0 (tidak bisa minus)</small>
                                </div>

                                {{-- ==================== FIELD KATEGORI (DROPDOWN) ==================== --}}
                                <div class="mb-3">
                                    <label>Kategori</label>
                                    <select name="kategori_id" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>

                                        {{-- Loop kategori, pilih yang sesuai dengan data buku --}}
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}"
                                                {{ $buku->kategori_id == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- ==================== TOMBOL FORM ==================== --}}
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Update
                                    </button>

                                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- ==================== JAVASCRIPT VALIDASI STOK ==================== --}}
    <script>
        // Validasi tambahan: cegah stok minus
        document.querySelector('input[name="stok"]').addEventListener('change', function() {
            if (this.value < 0) {
                this.value = 0;
                alert('Stok tidak boleh bernilai minus!');
            }
        });
    </script>
@endsection
