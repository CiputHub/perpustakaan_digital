@extends('frontend.layouts.clean')

@section('content')

<div class="container py-5">
    <!-- Header with Back Button -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Page Title -->
    <div class="text-center mb-5">
        <span class="badge bg-primary px-3 py-2 rounded-pill mb-2">Koleksi Perpustakaan</span>
        <h3 class="fw-bold display-6 mb-2">📚 Lihat Semua Buku</h3>
        <p class="text-muted">Daftar lengkap koleksi buku perpustakaan digital</p>
    </div>

    <!-- Search & Filter Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold mb-2">
                        <i class="fas fa-search text-primary me-1"></i> Cari Buku
                    </label>
                    <input type="text"
                           id="searchInput"
                           class="form-control form-control-lg rounded-pill"
                           placeholder="Cari berdasarkan judul, penulis, atau penerbit..."
                           autocomplete="off">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold mb-2">
                        <i class="fas fa-tag text-primary me-1"></i> Kategori
                    </label>
                    <select id="filterKategori" class="form-select rounded-pill">
                        <option value="all">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                        <option value="{{ strtolower($kat->nama_kategori) }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold mb-2">
                        <i class="fas fa-filter text-primary me-1"></i> Filter Stok
                    </label>
                    <select id="filterStok" class="form-select rounded-pill">
                        <option value="all">Semua Buku</option>
                        <option value="tersedia">Tersedia (Stok > 0)</option>
                        <option value="habis">Habis (Stok = 0)</option>
                    </select>
                </div>
            </div>
            <small class="text-muted mt-3 d-block" id="searchInfo"></small>
        </div>
    </div>

    <!-- Result Count -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h5 class="fw-semibold mb-0">
                <span id="totalCount">{{ $buku->count() }}</span> Buku Ditemukan
            </h5>
        </div>
        <div class="text-muted small">
            <i class="fas fa-sort me-1"></i> Urutkan berdasarkan terbaru
        </div>
    </div>

    <!-- Buku Grid -->
    <div class="row g-4" id="bukuGrid">
        @foreach($buku as $item)
        <div class="col-md-6 col-lg-4 col-xl-3 buku-item"
             data-judul="{{ strtolower($item->judul) }}"
             data-penulis="{{ strtolower($item->penulis ?? '') }}"
             data-penerbit="{{ strtolower($item->penerbit ?? '') }}"
             data-kategori="{{ strtolower($item->kategori->nama_kategori ?? '') }}"
             data-stok="{{ $item->stok }}">
            <div class="card h-100 border-0 shadow-sm rounded-4 hover-card">
                <!-- Gambar dengan Badge (TIDAK KEPOTONG) -->
                <div class="position-relative overflow-hidden rounded-top-4 bg-light" style="height: 260px;">
                    <a href="{{ route('detail', $item->id_buku) }}">
                        <img src="{{ asset('/storage/buku/'.$item->gambar) }}"
                             class="card-img-top"
                             alt="{{ $item->judul }}"
                             style="height: 100%; width: 100%; object-fit: contain; padding: 1rem; transition: transform 0.3s;">
                    </a>

                    <!-- Badge Stok -->
                    @if($item->stok > 0)
                    <span class="position-absolute top-0 end-0 m-2 badge bg-success rounded-pill px-3 py-2 shadow-sm">
                        <i class="fas fa-check-circle me-1"></i> Tersedia
                    </span>
                    @else
                    <span class="position-absolute top-0 end-0 m-2 badge bg-danger rounded-pill px-3 py-2 shadow-sm">
                        <i class="fas fa-times-circle me-1"></i> Habis
                    </span>
                    @endif
                </div>

                <!-- Card Body -->
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold mb-2">
                        <a href="{{ route('detail', $item->id_buku) }}" class="text-dark text-decoration-none">
                            {{ Str::limit($item->judul, 50) }}
                        </a>
                    </h6>

                    <!-- Kategori Badge -->
                    @if($item->kategori)
                    <div class="mb-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                            <i class="fas fa-tag me-1"></i> {{ $item->kategori->nama_kategori }}
                        </span>
                    </div>
                    @endif

                    <div class="mb-3">
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-user me-2 text-primary" style="width: 16px;"></i>
                            {{ $item->penulis ?? 'Tidak diketahui' }}
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-building me-2 text-primary" style="width: 16px;"></i>
                            {{ $item->penerbit ?? 'Tidak diketahui' }}
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-calendar me-2 text-primary" style="width: 16px;"></i>
                            {{ \Carbon\Carbon::parse($item->tahun_terbit)->format('d/m/Y') }}
                        </p>
                        <p class="mb-0 small fw-bold {{ $item->stok > 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fas fa-box me-2" style="width: 16px;"></i>
                            Stok: {{ $item->stok }} Buku
                        </p>
                    </div>

                    <!-- Button Pinjam (WARNA KUNING) -->
                    <div class="mt-auto">
                        <button class="btn btn-warning w-100 rounded-pill py-2 fw-semibold"
                                onclick="pinjamBuku({{ $item->id_buku }})"
                                {{ $item->stok < 1 ? 'disabled' : '' }}
                                style="background: #ffc107; border: none; color: #1e293b;">
                            <i class="fas fa-cart-plus me-2"></i>
                            {{ $item->stok > 0 ? 'Pinjam Sekarang' : 'Stok Habis' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="text-center py-5 d-none">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body py-5">
                <i class="fas fa-search fa-4x text-muted mb-3 d-block"></i>
                <h5 class="text-muted">Buku tidak ditemukan</h5>
                <p class="text-muted small">Coba cari dengan kata kunci atau kategori yang berbeda</p>
                <button class="btn btn-primary rounded-pill px-4" onclick="resetSearch()">
                    <i class="fas fa-redo me-2"></i>Reset Pencarian
                </button>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if(method_exists($buku, 'links'))
    <div class="d-flex justify-content-center mt-5">
        {{ $buku->links() }}
    </div>
    @endif
</div>

<style>
    /* Hover Effects */
    .hover-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1.5rem 2.5rem rgba(0,0,0,0.12) !important;
    }

    .hover-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-img-top {
        transition: transform 0.3s ease;
    }

    .rounded-4 {
        border-radius: 1rem !important;
    }

    .rounded-top-4 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }

    /* Search Input Styling */
    #searchInput:focus, #filterStok:focus, #filterKategori:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.2);
        border-color: #0d6efd;
    }

    /* Animasi fade in untuk card */
    .buku-item {
        animation: fadeInUp 0.4s ease backwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tombol warning hover effect */
    .btn-warning:hover {
        background: #e0a800 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255,193,7,0.3);
    }

    .btn-warning:disabled {
        background: #e9ecef !important;
        cursor: not-allowed;
        transform: none;
    }
</style>

<script>
    // Fungsi Search & Filter (termasuk kategori)
    function filterBuku() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const filterStok = document.getElementById('filterStok').value;
        const filterKategori = document.getElementById('filterKategori').value.toLowerCase();
        const bukuItems = document.querySelectorAll('.buku-item');
        let visibleCount = 0;

        bukuItems.forEach(item => {
            const judul = item.dataset.judul || '';
            const penulis = item.dataset.penulis || '';
            const penerbit = item.dataset.penerbit || '';
            const kategori = item.dataset.kategori || '';
            const stok = parseInt(item.dataset.stok);

            // Cek pencarian
            const matchesSearch = searchTerm === '' ||
                                 judul.includes(searchTerm) ||
                                 penulis.includes(searchTerm) ||
                                 penerbit.includes(searchTerm);

            // Cek filter kategori
            const matchesKategori = filterKategori === 'all' || kategori === filterKategori;

            // Cek filter stok
            let matchesStok = true;
            if (filterStok === 'tersedia') {
                matchesStok = stok > 0;
            } else if (filterStok === 'habis') {
                matchesStok = stok === 0;
            }

            // Tampilkan atau sembunyikan
            if (matchesSearch && matchesKategori && matchesStok) {
                item.style.display = '';
                visibleCount++;
                // Tambah animasi sedikit
                item.style.animation = 'none';
                setTimeout(() => {
                    item.style.animation = '';
                }, 10);
            } else {
                item.style.display = 'none';
            }
        });

        // Update jumlah dan empty state
        const totalCountSpan = document.getElementById('totalCount');
        const emptyState = document.getElementById('emptyState');
        const bukuGrid = document.getElementById('bukuGrid');

        totalCountSpan.textContent = visibleCount;

        if (visibleCount === 0) {
            emptyState.classList.remove('d-none');
            bukuGrid.classList.add('d-none');
        } else {
            emptyState.classList.add('d-none');
            bukuGrid.classList.remove('d-none');
        }

        // Update search info
        const searchInfo = document.getElementById('searchInfo');
        if ((searchTerm || filterKategori !== 'all') && visibleCount > 0) {
            let infoText = '';
            if (searchTerm) infoText += `"${searchTerm}" `;
            if (filterKategori !== 'all') infoText += `di kategori ${filterKategori} `;
            searchInfo.innerHTML = `<i class="fas fa-check-circle text-success"></i> Menampilkan ${visibleCount} hasil untuk ${infoText}`;
        } else if ((searchTerm || filterKategori !== 'all') && visibleCount === 0) {
            let infoText = '';
            if (searchTerm) infoText += `"${searchTerm}" `;
            if (filterKategori !== 'all') infoText += `di kategori ${filterKategori} `;
            searchInfo.innerHTML = `<i class="fas fa-times-circle text-danger"></i> Tidak ada hasil untuk ${infoText}`;
        } else {
            searchInfo.innerHTML = '';
        }
    }

    // Reset search
    function resetSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('filterStok').value = 'all';
        document.getElementById('filterKategori').value = 'all';
        filterBuku();
    }

    // Fungsi Pinjam Buku
    function pinjamBuku(id) {
        if(confirm('Apakah Anda yakin ingin meminjam buku ini?')) {
            window.location.href = "{{ url('pinjam') }}/" + id;
        }
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterStok = document.getElementById('filterStok');
        const filterKategori = document.getElementById('filterKategori');

        if (searchInput) {
            searchInput.addEventListener('keyup', filterBuku);
        }
        if (filterStok) {
            filterStok.addEventListener('change', filterBuku);
        }
        if (filterKategori) {
            filterKategori.addEventListener('change', filterBuku);
        }

        // Debounce untuk search
        let debounceTimer;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(filterBuku, 300);
            });
        }
    });
</script>

@endsection
