@extends('layout')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div>
                <h3 class="text-center my-4">Tambah Data Buku</h3>
                <hr>
            </div>

            <div class="container mt-5 mb-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow p-3 mb-5 bg-body-tertiary rounded">
                            <div class="card-body">
                                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Judul</label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                            name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul"
                                            required>
                                        @error('judul')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Gambar</label>
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                            name="gambar" accept="image/*">
                                        @error('gambar')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Penulis</label>
                                        <input type="text" class="form-control @error('penulis') is-invalid @enderror"
                                            name="penulis" value="{{ old('penulis') }}" placeholder="Masukkan penulis"
                                            required>
                                        @error('penulis')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Penerbit</label>
                                        <input type="text" class="form-control @error('penerbit') is-invalid @enderror"
                                            name="penerbit" value="{{ old('penerbit') }}" placeholder="Masukkan penerbit"
                                            required>
                                        @error('penerbit')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Tahun Terbit</label>
                                        <input type="date"
                                            class="form-control @error('tahun_terbit') is-invalid @enderror"
                                            name="tahun_terbit" value="{{ old('tahun_terbit') }}" required>
                                        @error('tahun_terbit')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Stok</label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                            name="stok" value="{{ old('stok') }}" placeholder="Masukkan stok"
                                            min="0" step="1" oninput="this.value = Math.abs(this.value)"
                                            required>
                                        @error('stok')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Kategori</label>
                                        <select name="kategori_id"
                                            class="form-control @error('kategori_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $k)
                                                <option value="{{ $k->id }}"
                                                    {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-md btn-primary">Simpan</button>
                                        <a href="/admin/buku" class="btn btn-warning">Kembali</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            opacity: 1;
        }

        .alert {
            margin-top: 5px;
            margin-bottom: 0;
            padding: 8px 12px;
            font-size: 13px;
        }
    </style>

    <script>
        // Validasi tambahan dengan JavaScript
        document.querySelector('input[name="stok"]').addEventListener('change', function() {
            if (this.value < 0) {
                this.value = 0;
                alert('Stok tidak boleh bernilai minus!');
            }
        });
    </script>
@endsection
