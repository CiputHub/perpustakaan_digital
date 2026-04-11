@extends('frontend.layouts.clean')

@section('content')
    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">📖 Data Peminjaman</h3>
                <p class="text-muted mb-0">Berisi buku dan history pinjaman</p>
            </div>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Statistik Ringkas -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 bg-primary bg-gradient text-white hover-stats">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">Total Pinjaman</small>
                                <h3 class="fw-bold mb-0">{{ $data->count() }}</h3>
                            </div>
                            <i class="fas fa-book fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark hover-stats">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">Dipinjam</small>
                                <h3 class="fw-bold mb-0">{{ $data->where('status', 'dipinjam')->count() }}</h3>
                            </div>
                            <i class="fas fa-spinner fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 bg-success text-white hover-stats">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">Selesai</small>
                                <h3 class="fw-bold mb-0">{{ $data->where('status', 'dikembalikan')->count() }}</h3>
                            </div>
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 bg-danger text-white hover-stats">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">Terlambat</small>
                                <h3 class="fw-bold mb-0">{{ $data->where('status', 'terlambat')->count() }}</h3>
                            </div>
                            <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Grid -->
        <div class="row g-4">
            @forelse($data as $row)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-card overflow-hidden">
                        <!-- Gambar Buku - TIDAK KEPOTONG -->
                        <div class="position-relative bg-light" style="height: 220px;">
                            <img src="{{ $row->buku->gambar ? asset('storage/buku/' . $row->buku->gambar) : asset('default-book.jpg') }}"
                                class="w-100 h-100"
                                alt="{{ $row->buku->judul }}"
                                style="object-fit: contain; padding: 1rem; transition: transform 0.3s;">

                            <!-- Badge Status -->
                            <div class="position-absolute top-0 end-0 m-3">
                                @if ($row->status == 'menunggu')
                                    <span class="badge bg-warning rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas fa-clock me-1"></i> Menunggu
                                    </span>
                                @elseif($row->status == 'dipinjam')
                                    <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas fa-book-open me-1"></i> Dipinjam
                                    </span>
                                @elseif($row->status == 'dikembalikan')
                                    <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                    </span>
                                @elseif($row->status == 'terlambat')
                                    <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Terlambat
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Body Card -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-2">
                                <a href="{{ route('detail', $row->buku->id_buku) }}" class="text-dark text-decoration-none">
                                    {{ Str::limit($row->buku->judul, 45) }}
                                </a>
                            </h5>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-user me-1 text-primary"></i>
                                {{ $row->buku->penulis ?? 'Tidak diketahui' }}
                            </p>

                            <!-- Info Peminjaman -->
                            <div class="bg-light rounded-3 p-3 mb-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-calendar-alt me-1"></i> Tanggal Pinjam
                                        </small>
                                        <span class="fw-semibold">{{ date('d/m/Y', strtotime($row->tanggal_pinjam)) }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-calendar-check me-1"></i> Tanggal Kembali
                                        </small>
                                        <span class="fw-semibold">{{ date('d/m/Y', strtotime($row->tanggal_pengembalian)) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Denda jika terlambat -->
                            @if ($row->status == 'terlambat' && ($row->denda ?? 0) > 0)
                                <div class="alert alert-danger py-2 mb-3 rounded-3">
                                    <small>
                                        <i class="fas fa-money-bill-wave me-1"></i>
                                        Denda: Rp {{ number_format($row->denda, 0, ',', '.') }}
                                    </small>
                                </div>
                            @endif

                            <!-- Button Kembalikan (hanya untuk dipinjam/terlambat) -->
                            @if (in_array($row->status, ['dipinjam', 'terlambat']))
                                <a href="{{ route('peminjaman.formKembali', $row->id_peminjaman) }}"
                                   class="btn btn-warning w-100 rounded-pill py-2 fw-semibold"
                                   style="background: #e64444; border: none; color: #1e293b;">
                                    <i class="fas fa-undo-alt me-2"></i> Kembalikan Buku
                                </a>
                            @elseif($row->status == 'dikembalikan')
                                <div class="text-center text-success small py-2">
                                    <i class="fas fa-check-circle me-1"></i> Buku sudah dikembalikan
                                </div>
                            @else
                                <div class="text-center text-muted small py-2">
                                    <i class="fas fa-clock me-1"></i> Menunggu konfirmasi
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">Belum ada history peminjaman</h5>
                            <p class="text-muted small">Mulai pinjam buku sekarang!</p>
                            <a href="{{ route('semua.buku') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                                <i class="fas fa-book me-2"></i>Lihat Buku
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Konfirmasi Pengembalian -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header bg-gradient-danger text-white border-0 rounded-top-4">
                    <h5 class="modal-title">
                        <i class="fas fa-undo-alt me-2"></i>Konfirmasi Pengembalian
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Apakah Anda yakin ingin mengembalikan buku:</p>
                    <h5 class="fw-bold text-center py-3 bg-light rounded-3" id="modalBookTitle">-</h5>

                    <div class="alert alert-warning mt-3" id="dendaInfo" style="display: none;">
                        <i class="fas fa-clock me-2"></i>
                        <div id="dendaText"></div>
                    </div>

                    <div class="alert alert-info mt-2 small">
                        <i class="fas fa-info-circle me-2"></i>
                        Pastikan buku dalam kondisi baik saat dikembalikan.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form id="returnForm" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning rounded-pill px-4" style="background: #ffc107; border: none;">
                            <i class="fas fa-check me-2"></i>Ya, Kembalikan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Hover Effects */
        .hover-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .hover-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 1.5rem 2.5rem rgba(0, 0, 0, 0.12) !important;
        }

        .hover-card:hover img {
            transform: scale(1.05);
        }

        .hover-stats {
            transition: all 0.3s ease;
        }

        .hover-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15) !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .rounded-top-4 {
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
        }

        .bg-gradient {
            background: linear-gradient(135deg, var(--bs-primary) 0%, #0a58ca 100%);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
        }

        .badge {
            font-weight: 500;
            font-size: 0.75rem;
            backdrop-filter: blur(4px);
        }

        .btn-warning {
            transition: all 0.2s ease;
        }

        .btn-warning:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }

        /* Alert styling */
        .alert {
            border: none;
            border-radius: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .card-title {
                font-size: 0.95rem;
            }
        }
    </style>

    <script>
        function confirmReturn(id, judul, tanggalKembali) {
            document.getElementById('modalBookTitle').innerText = judul;

            let today = new Date();
            let tglKembali = new Date(tanggalKembali);

            // Reset time to midnight for accurate comparison
            today.setHours(0, 0, 0, 0);
            tglKembali.setHours(0, 0, 0, 0);

            let denda = 0;
            let hari = 0;

            if (today > tglKembali) {
                let diff = today - tglKembali;
                hari = Math.ceil(diff / (1000 * 60 * 60 * 24));
                denda = hari * 2000;
            }

            const dendaInfo = document.getElementById('dendaInfo');
            const dendaText = document.getElementById('dendaText');

            if (denda > 0) {
                dendaInfo.style.display = 'block';
                dendaText.innerHTML = `
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terlambat ${hari} hari</strong><br>
                    <span class="fs-5">Denda: <strong class="text-danger">Rp ${denda.toLocaleString('id-ID')}</strong></span><br>
                    <small class="text-muted">⚠️ Dibayar langsung saat pengembalian di perpustakaan</small>
                `;
            } else {
                dendaInfo.style.display = 'block';
                dendaText.innerHTML = `
                    <i class="fas fa-smile-wink me-2"></i>
                    Tidak ada denda. Terima kasih telah mengembalikan tepat waktu! 👍
                `;
            }

            // Set form action
            document.getElementById('returnForm').action = `/peminjaman/${id}/kembali`;

            // Show modal
            new bootstrap.Modal(document.getElementById('returnModal')).show();
        }
    </script>

@endsection
