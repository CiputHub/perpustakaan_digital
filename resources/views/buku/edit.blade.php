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

                        <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label>Judul</label>
                                <input type="text" name="judul"
                                    value="{{ old('judul', $buku->judul) }}"
                                    class="form-control @error('judul') is-invalid @enderror">

                                @error('judul')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Gambar</label>

                                @if($buku->gambar)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/buku/' . $buku->gambar) }}" width="120">
                                    </div>
                                @endif

                                <input type="file" name="gambar" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Penulis</label>
                                <input type="text" name="penulis"
                                    value="{{ old('penulis', $buku->penulis) }}"
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Penerbit</label>
                                <input type="text" name="penerbit"
                                    value="{{ old('penerbit', $buku->penerbit) }}"
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Tahun Terbit</label>
                                <input type="date" name="tahun_terbit"
                                    value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi"
                                    value="{{ old('deskripsi', $buku->deskripsi) }}"
                                    class="form-control">
                                </textarea>
                            </div>

                            <div class="mb-3">
                                <label>Stok</label>
                                <input type="number" name="stok"
                                    value="{{ old('stok', $buku->stok) }}"
                                    class="form-control">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>

                                <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                                    Kembali
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
