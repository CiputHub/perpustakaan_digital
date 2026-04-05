 @extends('layout')

@section('content')

<div class="container">
    <div class="page-inner">

 <div>
        <h3 class="text-center my-4">Tambah Data buku</h3>
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
                                <label class="font-weight-bold">judul</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul">

                                <!-- error message untuk judul -->
                                @error('judul')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                             <div class="form-group mb-3">
                                <label class="font-weight-bold">Gambar</label>
                                <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                    name="gambar">

                                <!-- error message untuk gambar -->
                                @error('gambar')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                              <div class="form-group mb-3">
                                <label class="font-weight-bold">Penulis</label>
                                <input type="text" class="form-control @error('penulis') is-invalid @enderror"
                                name="penulis" value=" {{ old('penulis') }}"
                                    placeholder="Masukkan penulis">

                                <!-- error message untuk penulis -->
                                @error('penulis')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                              <div class="form-group mb-3">
                                <label class="font-weight-bold">Penerbit</label>
                                <input type="text" class="form-control @error('penerbit') is-invalid @enderror"
                                name="penerbit" value=" {{ old('penerbit') }}"
                                     placeholder="Masukkan penerbit">

                                <!-- error message untuk penerbit -->
                                @error('penerbit')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                              <div class="form-group mb-3">
                                <label class="font-weight-bold">Tahun Terbit</label>
                                <input type="date" class="form-control @error('tahun_terbit') is-invalid @enderror"
                                name="tahun_terbit" value=" {{ old('tahun_terbit') }}"
                                    placeholder="Masukkan tahun_terbit">

                                <!-- error message untuk tahun_terbit -->
                                @error('tahun_terbit')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                              <div class="form-group mb-3">
                                <label class="font-weight-bold">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
                                <!-- error message untuk deskripsi -->
                                @error('deskripsi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                              <div class="form-group mb-3">
                                <label class="font-weight-bold">Stok</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                name="stok" value=" {{ old('stok') }}"
                                    placeholder="Masukkan stok">

                                <!-- error message untuk stok -->
                                @error('stok')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <select name="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>



                            <button type="submit" class="btn btn-md btn-primary me-3">Simpan</button>
                            <a href="/admin/buku" class="btn btn-warning">Kembali</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        </div>
   @endsection
