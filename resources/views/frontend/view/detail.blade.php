@extends('frontend.layouts.clean')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Breadcrumb -->
            <nav class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}" class="text-decoration-none">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('semua.buku') }}" class="text-decoration-none">Semua Buku</a>
                    </li>
                    <li class="breadcrumb-item active text-muted">{{ Str::limit($buku->judul, 30) }}</li>
                </ol>
            </nav>

            <!-- Main Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="row g-4 align-items-start">

                        <!-- Gambar Section -->
                        <div class="col-md-5">
                            <div class="position-relative">
                                <div class="bg-light rounded-4 p-3 text-center">
                                    <img src="{{ asset('/storage/buku/'.$buku->gambar) }}"
                                         class="img-fluid rounded-3"
                                         alt="{{ $buku->judul }}"
                                         style="max-height: 400px; width: 100%; object-fit: contain;">
                                </div>

                                <!-- Badge Stok di Gambar -->
                                @if($buku->stok > 0)
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas fa-check-circle me-1"></i> Tersedia
                                    </span>
                                </div>
                                @else
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas fa-times-circle me-1"></i> Stok Habis
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Detail Section -->
                        <div class="col-md-7">
                            <!-- Judul -->
                            <h1 class="fw-bold mb-3">{{ $buku->judul }}</h1>

                            <!-- Rating Placeholder -->
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star-half-alt text-warning"></i>

                            </div>

                            <!-- Info Buku dalam Grid -->
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-3">
                                        <small class="text-muted d-block mb-1">
                                            <i class="fas fa-user me-1"></i> Penulis
                                        </small>
                                        <span class="fw-semibold">{{ $buku->penulis ?? 'Tidak diketahui' }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-3">
                                        <small class="text-muted d-block mb-1">
                                            <i class="fas fa-building me-1"></i> Penerbit
                                        </small>
                                        <span class="fw-semibold">{{ $buku->penerbit ?? 'Tidak diketahui' }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-3">
                                        <small class="text-muted d-block mb-1">
                                            <i class="fas fa-calendar me-1"></i> Tahun Terbit
                                        </small>
                                        <span class="fw-semibold">
                                            {{ \Carbon\Carbon::parse($buku->tahun_terbit)->format('d F Y') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-3">
                                        <small class="text-muted d-block mb-1">
                                            <i class="fas fa-box me-1"></i> Stok Buku
                                        </small>
                                        @if($buku->stok > 0)
                                        <span class="fw-bold text-success">{{ $buku->stok }} Buku</span>
                                        @else
                                        <span class="fw-bold text-danger">Stok Habis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi dengan Fitur Lihat Selengkapnya -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-book-open me-2 text-primary"></i>
                                    <h5 class="fw-bold mb-0">Deskripsi / Sinopsis</h5>
                                </div>
                                <div class="bg-light rounded-3 p-4">
                                    <div id="deskripsiShort" class="deskripsi-content">
                                        <p class="mb-0 text-muted">
                                            {{ Str::limit($buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.', 200) }}
                                        </p>
                                    </div>
                                    <div id="deskripsiFull" class="deskripsi-content d-none">
                                        <p class="mb-0 text-muted">
                                            {{ $buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                                        </p>
                                    </div>
                                    @if(strlen($buku->deskripsi ?? '') > 200)
                                    <button id="toggleDeskripsi" class="btn btn-link text-primary p-0 mt-2" onclick="toggleDeskripsi()">
                                        <i class="fas fa-chevron-down me-1"></i> Lihat Selengkapnya
                                    </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="d-flex flex-wrap gap-3 mt-4">
                                <a href="{{ url('/') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>

                                @if($buku->stok > 0)
                                <a href="{{ route('pinjam.form', $buku->id_buku) }}" class="btn btn-warning rounded-pill px-5 py-2 shadow-sm">
                                    <i class="fas fa-hand-peace me-2"></i>Pinjam Buku
                                </a>
                                @else
                                <button class="btn btn-secondary rounded-pill px-5 py-2" disabled>
                                    <i class="fas fa-times-circle me-2"></i>Stok Habis
                                </button>
                                @endif

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rekomendasi Buku Lainnya -->
            @if(isset($rekomendasi) && $rekomendasi->count() > 0)
            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-bookmark me-2 text-primary"></i>Buku Lainnya yang Mungkin Anda Suka
                    </h4>
                    <a href="{{ route('semua.buku') }}" class="text-decoration-none small">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @foreach($rekomendasi as $item)
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm rounded-4 hover-card h-100">
                            <a href="{{ route('detail', $item->id_buku) }}" class="text-decoration-none">
                                <img src="{{ asset('/storage/buku/'.$item->gambar) }}"
                                     class="card-img-top rounded-top-4 p-3"
                                     style="height: 180px; object-fit: cover;"
                                     alt="{{ $item->judul }}">
                                <div class="card-body p-3 text-center">
                                    <h6 class="fw-bold text-dark mb-1">{{ Str::limit($item->judul, 30) }}</h6>
                                    <small class="text-muted">{{ $item->penulis ?? 'Unknown' }}</small>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
    .rounded-4 {
        border-radius: 1rem !important;
    }

    .rounded-3 {
        border-radius: 0.75rem !important;
    }

    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }

    .deskripsi-content p {
        line-height: 1.6;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9f00 100%);
        border: none;
        transition: all 0.2s;
    }

    .btn-warning:hover {
        transform: scale(1.02);
        box-shadow: 0 0.5rem 1rem rgba(255,193,7,0.3);
    }

    .breadcrumb-item a {
        color: #6c757d;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: #0d6efd;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.4s ease;
    }
</style>

<script>
    function toggleDeskripsi() {
        const short = document.getElementById('deskripsiShort');
        const full = document.getElementById('deskripsiFull');
        const btn = document.getElementById('toggleDeskripsi');

        if (short.classList.contains('d-none')) {
            // Sedang menampilkan full, pindah ke short
            short.classList.remove('d-none');
            full.classList.add('d-none');
            btn.innerHTML = '<i class="fas fa-chevron-down me-1"></i> Lihat Selengkapnya';
        } else {
            // Sedang menampilkan short, pindah ke full
            short.classList.add('d-none');
            full.classList.remove('d-none');
            btn.innerHTML = '<i class="fas fa-chevron-up me-1"></i> Sembunyikan';
        }
    }

    function shareBuku() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $buku->judul }}',
                text: '{{ Str::limit($buku->deskripsi ?? "Buku menarik untuk dibaca!", 100) }}',
                url: window.location.href
            }).catch(() => {});
        } else {
            // Fallback copy to clipboard
            navigator.clipboard.writeText(window.location.href);
            alert('Link buku telah disalin ke clipboard!');
        }
    }
</script>

@endsection
