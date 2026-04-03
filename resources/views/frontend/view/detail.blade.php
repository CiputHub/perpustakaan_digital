@extends('frontend.layouts.clean')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card border-0 shadow-lg p-4">
                <div class="row align-items-center">

                    <!-- Gambar -->
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <img
                            src="{{ asset('/storage/buku/'.$buku->gambar) }}"
                            class="img-fluid rounded"
                            style="max-height: 350px; object-fit: cover;"
                        >
                    </div>

                    <!-- Detail -->
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-3">{{ $buku->judul }}</h2>

                        <hr>

                        <div class="mb-2">
                            <strong>Penulis:</strong> {{ $buku->penulis }}
                        </div>

                        <div class="mb-2">
                            <strong>Penerbit:</strong> {{ $buku->penerbit }}
                        </div>

                        <div class="mb-2">
                            <strong>Tahun Terbit:</strong>
                            {{ \Carbon\Carbon::parse($buku->tahun_terbit)->format('d-m-Y') }}
                        </div>

                        <div class="mb-3">
                            <strong>Stok:</strong>
                            @if($buku->stok > 0)
                                <span class="badge bg-success">
                                    Tersedia ({{ $buku->stok }})
                                </span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary me-2">
                                ← Kembali
                            </a>

                            <a href="{{ route('pinjam.form', $buku->id_buku) }}" class="btn btn-warning">
                                Pinjam Buku
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
