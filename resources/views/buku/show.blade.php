@extends('layout')

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

                            <!-- GAMBAR -->
                            <div class="col-md-5 text-center">
                                <img
                                    src="{{ asset('storage/buku/'.$buku->gambar) }}"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-height: 350px; object-fit: cover;"
                                >
                            </div>

                            <!-- DETAIL -->
                            <div class="col-md-7">

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
                                        <td>: {{ $buku->tahun_terbit }}</td>
                                    </tr>
                                    <tr>
                                        <th>Stok</th>
                                        <td>:
                                            <span class="badge bg-primary">
                                                {{ $buku->stok }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>

                                <div class="mt-3">
                                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                                        Kembali
                                    </a>

                                    <a href="{{ route('buku.edit', $buku->id_buku) }}" class="btn btn-warning">
                                        Edit
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
