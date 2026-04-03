@extends('frontend.layouts.clean')

@section('content')

<div class="container py-5">
    <a href="{{ url('/') }}" class="btn btn-outline-secondary me-2">
        ← Kembali
    </a>

    <div class="text-center mb-4">
        <h3 class="fw-bold">Lihat Semua Buku</h3>
        <p class="text-muted">Daftar lengkap koleksi buku perpustakaan digital</p>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <input type="text" class="form-control" placeholder="Cari buku, judul, penulis, penerbit...">
    </div>

    <div class="row g-4">

        @foreach($buku as $item)
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">

                <a href="{{ route('detail', $item->id_buku) }}">
                    <img
                        src="{{ asset('/storage/buku/'.$item->gambar) }}"
                        class="card-img-top p-3"
                        style="height: 230px; object-fit: cover;"
                    >
                </a>

                <div class="card-body text-center">
                    <h6 class="fw-bold text-uppercase">
                        <a href="{{ route('detail', $item->id_buku) }}" class="text-dark text-decoration-none">
                            {{ $item->judul }}
                        </a>
                    </h6>

                    <small class="text-muted d-block">
                        Penulis: {{ $item->penulis }}
                    </small>

                    <small class="text-muted d-block">
                        Tahun: {{ \Carbon\Carbon::parse($item->tahun_terbit)->format('d-m-Y') }}
                    </small>

                    <small class="text-muted">
                        Stok: {{ $item->stok }}
                    </small>
                </div>

            </div>
        </div>
        @endforeach

    </div>

</div>

@endsection
