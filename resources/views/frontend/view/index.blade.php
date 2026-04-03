 @extends('frontend.layouts.frontend')

 @section('content')

 <!-- Carousel Start -->
 <div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
     <div class="owl-carousel header-carousel py-5">
         @foreach($buku as $key => $row)
         <div class="container py-5">
             <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="carousel-text">
                            <h1 class="display-1 text-uppercase mb-3">{{ $row->judul }}</p>
                            <div class="d-flex">
                                <a class="btn btn-primary py-3 px-4 me-3" href="#!">Pinjam Sekarang</a>
                                <a class="btn btn-secondary py-3 px-4" href="#!">Detail Buku</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-img">
                           <img class="w-100" src= {{ asset('/storage/buku/'.$row->gambar) }} alt="Image"  style="width: 200px">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Carousel End -->


<!-- Buku Terbaru Start -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">BUKU TERBARU</h2>
    </div>

    <div class="row g-4">
        @foreach($buku->take(4) as $item)
        <div class="col-md-3">
            <div class="card h-100 d-flex flex-column">
                <a href="{{ route('detail', $item->id_buku) }}">
                    <img
                            src="{{ asset('/storage/buku/'.$item->gambar) }}"
                            class="card-img-top p-3"
                            style="height: 250px; object-fit: cover;"
                        >
                    </a>

                    <h6 class="fw-bold text-uppercase mt-2">
                        <a href="{{ route('detail', $item->id_buku) }}" class="text-dark text-decoration-none">
                        {{ $item->judul }}
                    </a>
                    </h6>
                    <p class="mb-1 small">Penulis: {{ $item->penulis }}</p>
                    <p class="mb-1 small">Penerbit: {{ $item->penerbit }}</p>
                    <p class="mb-1 small">
                        Tahun Terbit: {{ \Carbon\Carbon::parse($item->tahun_terbit)->format('d-m-Y') }}
                    </p>
                    <p class="mb-0 small">Stok: {{ $item->stok }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('semua.buku') }}" class="btn btn-warning mt-3">
            Lihat Semua Buku
        </a>
    </div>
</div>
<!-- Buku Terbaru End -->




     @endsection
