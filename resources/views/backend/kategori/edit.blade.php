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

                            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label>Nama Kategori</label>
                                    <input type="text" name="nama_kategori"
                                        value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                        class="form-control @error('nama_kategori') is-invalid @enderror">

                                    @error('nama_kategori')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>

                                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
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
