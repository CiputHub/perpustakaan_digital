@extends('frontend.layouts.frontend')

@section('content')

<!-- Carousel Start -->
<div id="home" class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="owl-carousel header-carousel py-5">
        @foreach($buku as $key => $row)
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="carousel-text">
                        <h1 class="display-1 text-uppercase mb-4 fw-bold">{{ $row->judul }}</h1>
                        <p class="mb-4 text-muted">{{ Str::limit($row->deskripsi ?? 'Nikmati pengalaman membaca yang menyenangkan dengan koleksi buku terbaik kami.', 120) }}</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a class="btn btn-primary py-3 px-5 rounded-pill shadow-sm" href="#!">
                                <i class="fas fa-book-open me-2"></i>Pinjam Sekarang
                            </a>
                            <a class="btn btn-outline-secondary py-3 px-5 rounded-pill" href="{{ route('detail', $row->id_buku) }}">
                                <i class="fas fa-info-circle me-2"></i>Detail Buku
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="carousel-img text-center">
                       <img class="img-fluid shadow-lg"
     src="{{ asset('/storage/buku/'.$row->gambar) }}"
     alt="{{ $row->judul }}"
     style="max-height:400px; width:100%; object-fit:contain;">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Carousel End -->

<!-- Statistik / Info Cepat Start -->
<div class="container mt-4 pt-3">
    <div class="row g-4">
        <div class="col-md-3 col-6">
            <div class="bg-primary bg-gradient text-white rounded-4 p-4 text-center shadow-sm">
                <i class="fas fa-book fa-3x mb-2 opacity-75"></i>
                <h3 class="fw-bold mb-0">{{ $totalBuku }}</h3>
                <small>Total Buku</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="bg-secondary bg-gradient text-white rounded-4 p-4 text-center shadow-sm">
                <i class="fas fa-users fa-3x mb-2 opacity-75"></i>
                <h3 class="fw-bold mb-0">{{ $totalAnggota }}</h3>
                <small>Anggota Aktif</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="bg-success bg-gradient text-white rounded-4 p-4 text-center shadow-sm">
                <i class="fas fa-hand-peace fa-3x mb-2 opacity-75"></i>
                <h3 class="fw-bold mb-0">{{ $totalPinjaman }}</h3>
                <small>Buku Dipinjam</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="bg-warning bg-gradient text-dark rounded-4 p-4 text-center shadow-sm">
                <i class="fas fa-book-reader fa-3x mb-2"></i>

               @auth
                    <h6 class="fw-bold">Ayo mulai membaca!</h6>
                    <a href="{{ route('buku.index') }}" class="btn btn-dark btn-sm rounded-pill">
                        Baca Sekarang
                    </a>
                @else
                    <h6 class="fw-bold">Gabung sekarang!</h6>
                    <a href="{{ route('register_anggota') }}" class="btn btn-dark btn-sm rounded-pill">
                        Daftar Sekarang
                    </a>
                @endauth

            </div>
        </div>
    </div>
</div>
<!-- Statistik End -->


<!-- Buku Terbaru Start -->
<div id="buku" class="container py-5">
    <div class="text-center mb-5">
        <span class="badge bg-primary px-3 py-2 rounded-pill mb-2">Koleksi Terbaru</span>
        <h2 class="fw-bold display-6">BUKU TERBARU</h2>
        <p class="text-muted">Temukan berbagai buku menarik terbaru dari perpustakaan kami</p>
    </div>

    <div class="row g-4">
        @foreach($buku->take(4) as $item)
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 hover-card">
                <div class="position-relative overflow-hidden rounded-top-4">
                    <a href="{{ route('detail', $item->id_buku) }}">
                        <img src="{{ asset('/storage/buku/'.$item->gambar) }}"
                        class="card-img-top p-3"
                        style="height:250px; width:100%; object-fit:contain;">
                    </a>
                    @if($item->stok > 0)
                    <span class="position-absolute top-0 end-0 m-3 badge bg-success rounded-pill px-3 py-2">
                        <i class="fas fa-check-circle me-1"></i> Tersedia
                    </span>
                    @else
                    <span class="position-absolute top-0 end-0 m-3 badge bg-danger rounded-pill px-3 py-2">
                        <i class="fas fa-times-circle me-1"></i> Habis
                    </span>
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold mb-2">
                        <a href="{{ route('detail', $item->id_buku) }}" class="text-dark text-decoration-none stretched-link">
                            {{ Str::limit($item->judul, 40) }}
                        </a>
                    </h6>

                    <div class="mb-3">
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-user me-2 text-primary"></i>{{ $item->penulis ?? 'Tidak diketahui' }}
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-building me-2 text-primary"></i>{{ $item->penerbit ?? 'Tidak diketahui' }}
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-calendar me-2 text-primary"></i>{{ \Carbon\Carbon::parse($item->tahun_terbit)->format('Y') }}
                        </p>
                        <p class="mb-0 small fw-bold {{ $item->stok > 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fas fa-box me-2"></i>Stok: {{ $item->stok }}
                        </p>
                    </div>

                    <div class="mt-auto">
                        <button class="btn btn-sm btn-primary w-100 rounded-pill"
                                onclick="pinjamBuku({{ $item->id_buku }})"
                                {{ $item->stok < 1 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus me-2"></i>Pinjam Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('semua.buku') }}" class="btn btn-warning px-5 py-3 rounded-pill shadow-sm fw-semibold">
            <i class="fas fa-eye me-2"></i>Lihat Semua Buku
            <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>
<!-- Buku Terbaru End -->



<!-- Call to Action Start -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-primary bg-gradient text-white rounded-4 p-5 text-center shadow-lg">
                <i class="fas fa-graduation-cap fa-3x mb-3 opacity-75"></i>
                <h2 class="fw-bold mb-3">Bergabung Menjadi Anggota</h2>
                <p class="mb-4 opacity-75">Dapatkan akses ke ribuan koleksi buku dan nikmati kemudahan peminjaman online</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('register_anggota') }}" class="btn btn-light text-primary px-4 py-2 rounded-pill fw-bold">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                    <a href="{{ route('login_anggota') }}" class="btn btn-outline-light px-4 py-2 rounded-pill">
                        <i class="fas fa-info-circle me-2"></i>Login Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Call to Action End -->

<style>
    /* Hover Effects */
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.1) !important;
    }

    .hover-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .category-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
    }

    .hover-category:hover .category-icon .rounded-circle {
        background-color: var(--bs-primary) !important;
    }

    .hover-category:hover .category-icon i {
        color: white !important;
    }

    .bg-gradient {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #0a58ca 100%);
    }

    .bg-secondary.bg-gradient {
        background: linear-gradient(135deg, var(--bs-secondary) 0%, #6c757d 100%);
    }

    .bg-success.bg-gradient {
        background: linear-gradient(135deg, var(--bs-success) 0%, #198754 100%);
    }

    .bg-warning.bg-gradient {
        background: linear-gradient(135deg, var(--bs-warning) 0%, #ffc107 100%);
    }

    .rounded-4 {
        border-radius: 1rem !important;
    }

    .rounded-top-4 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }

    /* Owl Carousel Custom */
    .header-carousel .owl-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
    }

    .header-carousel .owl-nav button {
        background: rgba(0,0,0,0.5) !important;
        color: white !important;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 20px !important;
    }

    .header-carousel .owl-dots {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 8px;
    }
</style>

<script>
    function pinjamBuku(id) {
        // Anda bisa custom alert atau redirect sesuai kebutuhan
        if(confirm('Apakah Anda ingin meminjam buku ini?')) {
            window.location.href = "{{ url('pinjam') }}/" + id;
        }
    }
</script>

@endsection
